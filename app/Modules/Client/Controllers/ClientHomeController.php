<?php


namespace App\Modules\Client\Controllers;


use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PostType;
use App\Core\Glosary\SeoConfigs;
use App\Core\Helper\OptionHelpers;
use App\Http\Controllers\Controller;

use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Setting\Repositories\OptionRepository;

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
            $seoConfig['SEO']['FOCUS_KEYPHARE'] => $systemConfig['site_title'],
            $seoConfig['SEO']['TITLE'] => $systemConfig['site_title'],
            $seoConfig['SEO']['DESC'] => $systemConfig['site_tagline'],
            $seoConfig['SEO']['CANONICAL_URL'] => \url()->to("/"),
            $seoConfig['SOCIAL']['FACEBOOK']['TITLE'] => $systemConfig['site_title'],
            $seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION'] => $systemConfig['site_tagline'],
            'published_time' => '2021-01-05T06:39:17+00:00',
            'modified_time' => '2021-01-05T06:39:17+00:00',
            $seoConfig['SOCIAL']['FACEBOOK']['IMAGE'] => $systemConfig['logo'],
            $seoConfig['SOCIAL']['TWITTER']['TITLE'] => $systemConfig['site_title'],
            $seoConfig['SOCIAL']['TWITTER']['DESCRIPTION'] => $systemConfig['site_tagline'],
            $seoConfig['SOCIAL']['TWITTER']['IMAGE'] => $systemConfig['logo']
        ];

        $posts = $this->postRepository->getInstantModel()->where('post_type',PostType::POST['VALUE'])->get();
        if (count($posts)) {
            $ids = [];
            $postMap = [];
            foreach ($posts->toArray() as $value) {
                $ids[] = $value['id'];
                $postMap[$value['id']] = [
                    'name' => $value['post_title'],
                ];
            }
            $postMeta = $this->postMetaRepository->findByPostIds($ids);
            $mapData = [];
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
            }
        }
        return view('Client::homepage',compact('page', 'seoDefault','currentLanguage'));
    }

}
