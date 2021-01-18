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
use App\Modules\Taxonomy\Repositories\TermMetaRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class ClientPostController extends Controller
{

    protected $postRepository;
    protected $postMetaRepository;
    protected $termRepository;
    protected $termRelationRepository;
    protected $termMetaRepository;

    public function __construct(PostRepository $postRepository, PostMetaRepository $postMetaRepository,
                                TermRepository $termRepository, TermRelationRepository $termRelationRepository,
                                TermMetaRepository $termMetaRepository)
    {
        $this->postRepository = $postRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->termRepository = $termRepository;
        $this->termRelationRepository = $termRelationRepository;
        $this->termMetaRepository = $termMetaRepository;
    }

    public function detail($slug){
        if ($this->postRepository->getBySlug($slug)) {

            $currentLanguage = app()->getLocale();
            $translationMode = [ "mode" => "post" , "slug" => $slug ];
            $user = Auth::user();
            $post = $this->postRepository->getBySlug($slug);

            if ($user == null && $post->post_status == PostStatus::DRAFT['VALUE']) {
                return view('Client::pages.404');
            }

            $postMeta = $this->postMetaRepository->getByPostId($post->id);
            $getBanner = $this->postMetaRepository->filter([['post_id' , $post->id] , ['meta_key', MetaKey::BANNER['VALUE'] ]]);
            if($getBanner && $getBanner->isNotEmpty()) {
                $banners = json_decode($getBanner[0]->meta_value , true);

            }
            $seoConfig = SeoConfigs::getSeoKey();
            $seoDefault = [
                $seoConfig['SEO']['FOCUS_KEYPHARE'] => isset($post->post_title) ? $post->post_title : "" ,
                $seoConfig['SEO']['TITLE'] => isset($post->post_title) ? $post->post_title : "" ,
                $seoConfig['SEO']['DESC'] => isset($post->post_excerpt) ? $post->post_excerpt : "",
                $seoConfig['SEO']['CANONICAL_URL'] => \url()->current(),
                $seoConfig['SOCIAL']['FACEBOOK']['TITLE'] => isset($post->post_title) ? $post->post_title : "",
                $seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION'] => isset($post->post_excerpt) ? $post->post_excerpt : "",
                'published_time' => isset($post->created_at) ? $post->created_at : '2021-01-05T06:39:17+00:00',
                'modified_time' => isset($post->updated_at) ? $post->updated_at : '2021-01-05T06:39:17+00:00',
                $seoConfig['SOCIAL']['FACEBOOK']['IMAGE'] => isset($banners[0]) ?  $banners[0] : "",
                $seoConfig['SOCIAL']['TWITTER']['TITLE'] => isset($post->post_title) ? $post->post_title : "",
                $seoConfig['SOCIAL']['TWITTER']['DESCRIPTION'] => isset($post->post_excerpt) ? $post->post_excerpt : "",
                $seoConfig['SOCIAL']['TWITTER']['IMAGE'] => isset($banners[0]) ?  $banners[0] : ""
            ];

            $postMetaMap = [];
            foreach ($postMeta as $value) {
                $postMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
            }

            if (isset($postMetaMap[MetaKey::PAGE_TEMPLATE['NAME']])) {
                $template = $postMetaMap[MetaKey::PAGE_TEMPLATE['NAME']];
                $pageMeta = $this->postMetaRepository->getByPostId($post->id);
                $pageMetaMap = [];
                if ($pageMeta) {
                    foreach ($pageMeta->toArray() as $value) {
                        $pageMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                    }
                }
                if ($template == PageTemplateConfigs::ABOUT['VALUE']) {
                    $imageMap = [];
                    if (isset($pageMetaMap[MetaKey::IMAGE_ITEM['NAME']]) && !empty($pageMetaMap[MetaKey::IMAGE_ITEM['NAME']])){
                        $imageItem = $pageMetaMap[MetaKey::IMAGE_ITEM['NAME']];
                        $indexImage = $pageMetaMap[MetaKey::INDEX_IMAGE_ITEM['NAME']];
                        $index = $indexImage[0];
                        foreach ($indexImage as $k => $value) {
                            foreach ($imageItem as $key => $item) {
                                if (!array_key_exists($k, $imageMap) || count($imageMap[$k]) < intval($value)) {
                                    $imageMap[$k][] = $item;
                                    unset($imageItem[$key]);
                                } else {
                                    break;
                                }
                            }
                        }
                    }

                    $itemMap = [];
                    if (isset($pageMetaMap[MetaKey::INDEX_COMPLETE_ITEM['NAME']]) && !empty($pageMetaMap[MetaKey::INDEX_COMPLETE_ITEM['NAME']])) {
                        $items = $pageMetaMap[MetaKey::COMPLETE_ITEM['NAME']];
                        $indexItem = $pageMetaMap[MetaKey::INDEX_COMPLETE_ITEM['NAME']];
                        foreach ($indexItem as $k => $value) {
                            foreach ($items as $key => $item) {
                                if (!array_key_exists($k, $itemMap) || count($itemMap[$k]) < intval($value)) {
                                    $itemMap[$k][] = $item;
                                    unset($items[$key]);
                                } else {
                                    break;
                                }
                            }
                        }
                    }
                    return view('Client::about',compact('post','pageMetaMap','imageMap','itemMap', 'translationMode','currentLanguage', 'seoDefault'));
                }
                if ($template == PageTemplateConfigs::SERVICE['VALUE']) {
                    return view('Client::service',compact('post','pageMetaMap','translationMode','currentLanguage', 'seoDefault'));
                }
                if ($template == PageTemplateConfigs::HOTEL['VALUE']) {
                    $posts = $this->postRepository->getInstantModel()->where('post_type',PostType::POST['VALUE'])->get();
                    $ids = [];
                    $postsMetaMap = [];
                    if (count($posts)) {
                        foreach ($posts->toArray() as $value) {
                            $ids[] = $value['id'];
                            $postsMetaMap[$value['id']] = [
                                'title' => $value['post_title'],
                                'slug' => $value['post_name']
                            ];
                        }
                    }

                    $postMetas = $this->postMetaRepository->findByPostIds($ids);
                    if (count($postMetas)) {
                        foreach ($postsMetaMap as $key => $item) {
                            foreach ($postMetas->toArray() as $value) {
                                if ($key == $value['post_id']) {
                                    if (isset($value['meta_key'])) {
                                        $postsMetaMap[$key][MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                                    }
                                }
                            }
                        }
                    }
                    return view('Client::hotel',compact('post','postsMetaMap','pageMetaMap','translationMode','currentLanguage', 'seoDefault'));
                }
                if ($template == PageTemplateConfigs::CONTACT['VALUE']) {
                    return view('Client::contact',compact('post','pageMetaMap', 'translationMode','currentLanguage', 'seoDefault'));
                }
                if ($template == PageTemplateConfigs::DEFAULT['VALUE']) {
                    return view('Client::hotel',compact('post','pageMetaMap', 'translationMode','currentLanguage', 'seoDefault'));
                }
            }else {
                $termRelation = $this->termRelationRepository->getInstantModel()->where('object_id', $post->id)->first();
                $termMeta = $termRelation != null ? $this->termMetaRepository->getInstantModel()->where('term_id', $termRelation->term_taxonomy_id)->get() : false ;
                $termMetaMap = [];
                if ($termMeta) {
                    foreach ($termMeta->toArray() as $value) {
                        $termMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                    }
                }

                $relatePost = $termRelation != null ? $this->termRelationRepository->getInstantModel()->where('term_taxonomy_id', $termRelation->term_taxonomy_id)->get() : false;
                $ids = [];
                if ($relatePost) {
                    $relatePost = $relatePost->toArray();
                    foreach ($relatePost as $value) {
                        if ($value['object_id'] != $post->id) {
                            $ids[] = $value['object_id'];
                        }
                    }
                }
                $relatePostMap = [];
                $relatePostMetaMap = [];
                if ($user) {
                    $relatePosts = $this->postRepository->findByIds($ids);
                }else{
                    $relatePosts = $this->postRepository->findByIds($ids,false);
                }
                if (count($relatePosts)) {
                    $relatePostMap = $relatePosts->toArray();
                    foreach ($relatePostMap as $key => $value) {
                        $relatePostMetaMap[$value['id']] = [
                            'slug' => $value['post_name'],
                            'title' => $value['post_title'],
                        ];
                    }
                }

                $relatePostMeta = $this->postMetaRepository->findByPostIds($ids);

                if (count($relatePostMeta)) {
                    $relatePostMeta = $relatePostMeta->toArray();
                    foreach ($relatePostMetaMap as $key => $value) {
                        foreach ($relatePostMeta as $k => $meta) {
                            if ($key == $meta['post_id']) {
                                if (isset($meta['meta_key'])) {
                                    $relatePostMetaMap[$key][MetaKey::display($meta['meta_key'])] = json_decode($meta['meta_value']);
                                }
                            }
                        }
                    }
                }

                return view('Client::hotel-detail', compact('post', 'postMetaMap', 'termMetaMap', 'relatePostMetaMap', 'relatePostMap', 'translationMode','currentLanguage', 'seoDefault'));
            }
        }else{
            return view('Client::pages.404');
        }
    }

    public function saveContactForm(Request $request) {

        $this->validate($request, [
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9'
        ]);

        $systemConfig = OptionHelpers::getSystemConfigByKey('general');
        if($systemConfig && json_decode($systemConfig,true))
            $systemConfig = json_decode($systemConfig, true);

        $input = $request->all();
        Mail::send('mail_temaplate.contact', ['name'=>$input["contact_name"], 'email'=>$input["contact_email"], 'phone'=>$input['contact_phone'],'project' => $input['contact_project'] ,'contact_message' => $input['contact_message'] ], function ($message) {
            $message->from('youremail@your_domain');
            $message->to('youremail@your_domain', 'Your Name')
                ->subject('Your Website Contact Form');
        });
        Session::flash('flash_message', 'Send message successfully!');

    }

}
