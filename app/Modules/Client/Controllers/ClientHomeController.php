<?php


namespace App\Modules\Client\Controllers;


use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PageTemplateConfigs;
use App\Core\Glosary\PostStatus;
use App\Core\Glosary\PostType;
use App\Core\Glosary\SeoConfigs;
use App\Core\Helper\OptionHelpers;
use App\Http\Controllers\Controller;

use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Setting\Repositories\OptionRepository;

use Illuminate\Support\Facades\Auth;
use Spatie\SchemaOrg\Graph;


class ClientHomeController extends Controller
{

    protected $optionRepository;
    protected $postRepository;
    protected $postMetaRepository;

    public function __construct(OptionRepository $optionRepository, PostRepository $postRepository,
                                PostMetaRepository $postMetaRepository)
    {
        $this->optionRepository = $optionRepository;
        $this->postRepository = $postRepository;
        $this->postMetaRepository = $postMetaRepository;
    }
    public function index() {
        $systemConfig = OptionHelpers::getSystemConfigByKey('general');
        $seoConfig = SeoConfigs::getSeoKey();
        if($systemConfig && json_decode($systemConfig, true)){
            $systemConfig = json_decode($systemConfig, true);
        }
        $currentLanguage = app()->getLocale();
        if ($this->optionRepository->getByKey('home')) {
            $page = json_decode($this->optionRepository->getByKey('home')->option_value);
        }else{
            return view('Client::pages.404');
        }

        $seoDefault = [
            $seoConfig['SEO']['FOCUS_KEYPHARE'] => isset($systemConfig['site_title']) ? $systemConfig['site_title'] : "" ,
            $seoConfig['SEO']['TITLE'] => isset($systemConfig['site_title']) ? $systemConfig['site_title'] : "",
            $seoConfig['SEO']['DESC'] => isset($systemConfig['site_tagline']) ? $systemConfig['site_tagline'] : "",
            $seoConfig['SEO']['CANONICAL_URL'] => \url()->to("/"),
            $seoConfig['SOCIAL']['FACEBOOK']['TITLE'] => isset($systemConfig['site_title']) ? $systemConfig['site_title'] : "",
            $seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION'] => isset($systemConfig['site_tagline']) ? $systemConfig['site_tagline'] : "",
            'published_time' => '2021-01-05T06:39:17+00:00',
            'modified_time' => '2021-01-05T06:39:17+00:00',
            $seoConfig['SOCIAL']['FACEBOOK']['IMAGE'] => isset($systemConfig['logo']) ? $systemConfig['logo'] : "",
            $seoConfig['SOCIAL']['TWITTER']['TITLE'] => isset($systemConfig['site_title']) ? $systemConfig['site_title'] : "",
            $seoConfig['SOCIAL']['TWITTER']['DESCRIPTION'] => isset($systemConfig['site_tagline']) ? $systemConfig['site_tagline'] : "",
            $seoConfig['SOCIAL']['TWITTER']['IMAGE'] => isset($systemConfig['logo']) ? $systemConfig['logo'] : ""
        ];

        if (Auth::user()){
            $posts = $this->postRepository->getInstantModel()->where('post_type',PageTemplateConfigs::POST['NAME'])->get();
        }else{
            $posts = $this->postRepository->getInstantModel()->where([['post_type','=',PageTemplateConfigs::POST['NAME']],['post_status','=',PostStatus::PUBLIC['VALUE']]])->get();
        }
        $postMap = [];
        $mapData = [];
        if (count($posts)) {
            $ids = [];
            foreach ($posts->toArray() as $value) {
                $ids[] = $value['id'];
                $postMap[$value['id']] = [
                    'name' => $value['post_title'],
                    'slug' => $value['post_name']
                ];
            }
            $postMeta = $this->postMetaRepository->findByPostIds($ids);
            if (count($postMeta)) {
                foreach ($postMap as $key => $value){
                    foreach ($postMeta->toArray() as $item) {
                        if ($key == $item['post_id']) {
                            if ($item['meta_key']) {
                                $postMap[$key][MetaKey::display($item['meta_key'])] = json_decode($item['meta_value']);
                            }
                        }
                    }
                }
                if (isset($postMeta) && !empty($postMeta)) {
                    foreach ($postMap as $value) {
                        $mapData[] = [
                            'name' => isset($value['name']) ? $value['name'] : "",
                            'image' => isset($value[MetaKey::THUMBNAIL['NAME']]) ?  $value[MetaKey::THUMBNAIL['NAME']] : "",
                            'address' => isset($value[MetaKey::LOCATION['NAME']]->address) ? $value[MetaKey::LOCATION['NAME']]->address : "",
                            'city' => isset($value[MetaKey::LOCATION['NAME']]->city) ? $value[MetaKey::LOCATION['NAME']]->city : "",
                            'rate' => isset($value[MetaKey::RATE['NAME']]) ? $value[MetaKey::RATE['NAME']] : "",
                            'location' => [
                                'lat' => isset($value[MetaKey::LOCATION['NAME']]->location->lat) ? floatval($value[MetaKey::LOCATION['NAME']]->location->lat) : "",
                                'lng' => isset($value[MetaKey::LOCATION['NAME']]->location->long) ? floatval($value[MetaKey::LOCATION['NAME']]->location->long) : ""
                            ]
                        ];
                    }
                }
            }
        }
        return view('Client::homepage',compact('page', 'seoDefault','currentLanguage','mapData','postMap'));
    }

}
