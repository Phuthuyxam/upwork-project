<?php


namespace App\Modules\Client\Controllers;


use App\Core\Glosary\BookingTypes;
use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PageTemplateConfigs;
use App\Core\Glosary\PostStatus;
use App\Core\Glosary\PostType;
use App\Core\Glosary\SeoConfigs;
use App\Core\Helper\OptionHelpers;
use App\Http\Controllers\Controller;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\SystemConfig\Repositories\SystemConfigRepository;
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
    protected $systemRepository;

    public function __construct(PostRepository $postRepository, PostMetaRepository $postMetaRepository, SystemConfigRepository $systemRepository)
    {
        $this->postRepository = $postRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->systemRepository = $systemRepository;
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

            $hotelPage = '';
            $bookingType = '';
            $relatePostMap = [];
            $relatePostMetaMap = [];
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

            if ($post->post_type != PageTemplateConfigs::POST['NAME']) {
                $template = PageTemplateConfigs::parse($post->post_type)['VALUE'];
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
                    if ($user) {
                        $condition = [
                            ['post_type','=',PageTemplateConfigs::POST['NAME']]
                        ];
                    }else {
                        $condition = [
                            ['post_type','=',PageTemplateConfigs::POST['NAME']],
                            ['post_status','=',PostStatus::PUBLIC['VALUE']]
                        ];
                    }
                    $posts = $this->postRepository->getInstantModel()->where($condition)->get();
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
            }else {

                $hotelPage = $this->postRepository->getInstantModel()->where('post_type',PageTemplateConfigs::HOTEL['NAME'])->first();

                $relatePosts = '';
                $relatePostMetaMap = [];
                if ($user) {
                    $condition = [
                        ['post_type','=',PageTemplateConfigs::POST['NAME']],
                        ['id','<>',$post->id]
                    ];
                }else{
                    $condition = [
                        ['post_type','=',PageTemplateConfigs::POST['NAME']],
                        ['id','<>',$post->id],
                        ['post_status','=',PostStatus::PUBLIC['VALUE']]
                    ];
                }
                $relatePost = $this->postRepository->getInstantModel()->where($condition)->orderBy('created_at', 'desc')->limit(3)->get();
                if ($relatePost) {
                    $ids = [];
                    foreach ($relatePost->toArray() as $value) {
                        $relatePostMetaMap[$value['id']] = [
                            'post_title' => $value['post_title'],
                            'post_name' => $value['post_name'],
                        ];
                        $ids[] = $value['id'];
                    }

                    $relatePostMeta = $this->postMetaRepository->findByPostIds($ids);

                    if (count($relatePostMeta)) {
                        foreach ($relatePostMetaMap as $key => $value) {
                            foreach ($relatePostMeta->toArray() as $k => $meta) {
                                if ($key == $meta['post_id']) {
                                    if (isset($meta['meta_key'])) {
                                        $relatePostMetaMap[$key][MetaKey::display($meta['meta_key'])] = json_decode($meta['meta_value']);
                                    }
                                }
                            }
                        }
                    }

                }

                return view('Client::hotel-detail', compact('post', 'postMetaMap', 'translationMode','currentLanguage', 'seoDefault','hotelPage','relatePostMetaMap'));
            }
        }else{
            $currentLanguage = app()->getLocale();
            return view('Client::pages.404',compact('currentLanguage'));
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
        Mail::send('mail_template.contact', ['name'=>$input["contact_name"], 'email'=>$input["contact_email"], 'phone'=>$input['contact_phone'],'project' => $input['contact_project'] ,'contact_message' => $input['contact_message'] ], function ($message) use ($systemConfig) {
            $message->from($systemConfig['site_admin_mail']);
            $message->to($systemConfig['site_admin_mail'], 'Employee')
                ->subject('Your Website Contact Form');
        });
        Session::flash('flash_message', 'Send message successfully!');

    }

    public function booking(Request $request){
        try {
            if ($request->input('type') == BookingTypes::FORM['VALUE']) {
                $validate = $request->validate([
                    'start' => 'required',
                    'end' => 'required',
                    'adults' => 'required',
                    'child' => 'required'
                ]);
                $ages = [];
                if($request->input('childrenAge')) {
                    $ages = $request->input('childrenAge');
                    foreach ($ages as $key => $value ) {
                        if ($value < 0) {
                            unset($ages[$key]);
                        }
                    }
                }
                $systemConfig = OptionHelpers::getSystemConfigByKey('general');
                if($systemConfig && json_decode($systemConfig,true))
                    $systemConfig = json_decode($systemConfig, true);

                $postMeta = $this->postMetaRepository->getMetaValueByCondition([['post_id','=',$request->input('postId')],['meta_key','=',MetaKey::BOOKING_TYPE['VALUE']]]);
                if (isset($postMeta) && !empty($postMeta))
                {
                    $mail_to = json_decode($postMeta->meta_value)->value;
                    Mail::send('mail_template.booking',
                        [
                            'start' => $request->input('start'),
                            'end' => $request->input('end'),
                            'adults' => $request->input('adults'),
                            'children' => $request->input('child'),
                            'ages' => $ages
                        ],function ($message) use ($systemConfig,$mail_to) {
                            $message->from($systemConfig['site_admin_mail']);
                            $message->to($mail_to, 'Employee')
                                ->subject('Your Website Contact Form');
                        });
                    return redirect()->back()->with('message','success');
                }
            }
        }catch (\Throwable $th){
            Session::flash('flash_message', 'Send message successfully!');
            return redirect()->back();
        }
    }
}
