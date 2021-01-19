<?php


namespace App\Modules\Page\Controllers;


use App\Core\Glosary\LocationConfigs;
use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PageTemplateConfigs;
use App\Core\Glosary\PostStatus;
use App\Core\Glosary\PostType;
use App\Http\Controllers\Controller;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use App\Modules\Translations\Model\TranslationRelationship;
use App\Modules\Translations\Repositories\TranslationRelationshipRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class PageController extends Controller
{
    protected $postRepository;
    protected $postMetaRepository;
    protected $termRepository;
    protected $termRelationRepository;
    protected $translationRelationRepository;

    public function __construct(PostRepository $posRepository, PostMetaRepository $postMetaRepository,
                                TermRepository $termRepository, TermRelationRepository $termRelationRepository,
                                TranslationRelationshipRepository $translationRelationRepository)
    {
        $this->postRepository = $posRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->termRepository = $termRepository;
        $this->termRelationRepository = $termRelationRepository;
        $this->translationRelationRepository = $translationRelationRepository;
    }

    public function add(Request $request,$template) {
        $pageTemplate = PageTemplateConfigs::parse($template)['VALUE'];
        if ($request->isMethod('get')) {
            $currentLanguage = generatePrefixLanguage() ? generatePrefixLanguage() : 'en/' ;
            $slugs = $this->postRepository->getAllSlugs();
            $allSlug = [];
            if ($slugs) {
               foreach ($slugs as $value) {
                   $allSlug[] = $value->post_name;
               }
            }
            $defaultTemplate = [PageTemplateConfigs::CONTACT['NAME'],PageTemplateConfigs::HOTEL['NAME']];
            $page = $this->postRepository->getInstantModel()->where('post_type',$template)->first();
            $pageMeta = [];
            $pageMetaMap = [];
            $translationRecord = false;
            if ($page) {
                $pageMeta = $page->postMeta;
                if ($pageMeta) {
                    foreach ($pageMeta->toArray() as $value) {
                        $pageMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                    }
                }

                // add translation record
                if (LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()) {
                    $translationPost = $page->postFromTranslation;
                }else {
                    $translationPost = $page->postToTranslation;
                }

                if (!empty($translationPost) && $translationPost->isNotEmpty()) {
                    $langCode = (LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()) ? $translationPost[0]->to_lang : $translationPost[0]->from_lang;
                    $langId = (LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()) ? $translationPost[0]->from_object_id : $translationPost[0]->to_object_id;
                    $translationRecord = ['url' => renderTranslationUrl(route('page.add', ['template' => $template]), $langCode), 'lang_code' => $langCode];
                } else {
                    $translationRecord = false;
                }

            }
            if ($template == PageTemplateConfigs::ABOUT['NAME']) {
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
                return view('Page::add',compact('template','defaultTemplate','pageMetaMap','imageMap','itemMap','page','translationRecord','allSlug','currentLanguage'));
            }
            return view('Page::add',compact('template','defaultTemplate','page','pageMetaMap', 'translationRecord','allSlug','currentLanguage'));
        }else{
            try {
                $currentLang = app()->getLocale();
                $page = $this->postRepository->getInstantModel()->where('post_type',$template)->first();

                if ($page) {
                    $validateRule = [
                        'post_title' => 'required|max:191',
                        'post_name' => 'required|unique:posts,id,'.$page->id,
                        'post_excerpt' => 'required',
                    ];

                    $prefixLanguage = generatePrefixLanguage();
                    if(isset($prefixLanguage) && !empty($prefixLanguage) && LocationConfigs::checkLanguageCode(str_replace("/","",$prefixLanguage))
                        && LocationConfigs::getLanguageDefault()['VALUE'] != str_replace("/","",$prefixLanguage))
                        $validateRule['post_name'] = "required|unique:posts_". str_replace("/","",$prefixLanguage) .",post_name," . $page->id;
                    $validate = $request->validate($validateRule);
                    // make translation
                    if(isset($request->translation) && !empty($request->translation) && LocationConfigs::checkLanguageCode($request->translation)) {
                        // check has record in relationship
                        $translationMapping = $this->translationRelationRepository->filter([['from_object_id',$page->id] , ['from_lang', $currentLang] , ['to_lang' , $request->translation], ['type' , 'post']]);
                        if($translationMapping && $translationMapping->isNotEmpty()) {
                            $transUrl = renderTranslationUrl(route('page.add', ['template' => $template]), $request->translation);
                            return redirect()->to($transUrl)->with('message', 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.');
                        }

                        $translation = $this->translationSave($request, $template);
                        if($translation){
                            // make record relationship translation
                            if(isset($translation['post_id']) && !empty($translation['post_id'])) {
                                $translationRecord = [
                                    'to_object_id' => $translation['post_id'],
                                    'from_object_id' => $page->id,
                                    'to_lang' => app()->getLocale(),
                                    'from_lang' => $currentLang,
                                    'type' => 'post',
                                ];
                                if($this->translationRelationRepository->create($translationRecord))
                                    return redirect()->to($translation['redirect_url'])->with('message', $translation['message']);
                                return redirect()->back()->with('message', 'danger|Something wrong when make a translation record try again!');
                            }
                            return redirect()->to($translation['redirect_url'])->with('message', $translation['message']);
                        }
                        return redirect()->back()->with('message', 'danger|Something wrong when make a translation record try again!');
                    }




                    $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
                    // Save Post
                    $dataPost = [
                        'post_title' => $request->input('post_title'),
                        'post_name' => $request->input('post_name'),
                        'post_author' => Auth::id(),
                        'post_excerpt' => $request->input('post_excerpt'),
                        'post_status' => $status,
                        'post_content' => $request->input('post_content')
                    ];

                    $this->postRepository->update($page->id,$dataPost);

                    $metaImages = $this->postMetaRepository->getInstantModel()->where([['post_id', $page->id] , ['meta_key', MetaKey::BANNER['VALUE']]])->get();
                    if($metaImages->isNotEmpty()) {
                        $this->postMetaRepository->getInstantModel()->where([['post_id', $page->id] , ['meta_key', MetaKey::BANNER['VALUE']]])
                            ->update(['meta_value' => json_encode($request->input('files'))]);
                    }else{
                        $this->postMetaRepository->getInstantModel()->create([
                            'post_id' => $page->id,
                            'meta_key' => MetaKey::BANNER['VALUE'],
                            'meta_value' => json_encode($request->input('files'))
                        ]);
                    }
                    if ($template == PageTemplateConfigs::SERVICE['NAME']) {
                        $this->updatePage($request,$page->id,MetaKey::COMPLETE_ITEM['VALUE']);
                    }

                    if ($template == PageTemplateConfigs::ABOUT['NAME']) {
                        $this->updatePage($request,$page->id,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE']);
                    }

                    return redirect()->route('page.add',$template)->with('message', 'success|Successfully create  "'. $request->input('post_title').'" page');
                }else{
                    $post_title = $request->input('post_title');
                    $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];

                    $dataPost = [
                        'post_title' => $post_title,
                        'post_name' => $request->input('post_name'),
                        'post_author' => Auth::id(),
                        'post_status' => $status,
                        'post_excerpt' => $request->input('post_excerpt'),
                        'post_content' => $request->input('post_content'),
                        'post_type' => $template
                    ];
                    $postId = $this->postRepository->create($dataPost)->id;
                    if ($postId) {
                        $result = false;
                        $files = $request->input('files');
                        if (isset($files) && !empty($files)){
                            $dataMeta =
                                [
                                    'post_id' => $postId,
                                    'meta_key' => MetaKey::BANNER['VALUE'],
                                    'meta_value' => json_encode($files)
                                ];
                            $this->postMetaRepository->create($dataMeta);
                        }

                        if ($pageTemplate == PageTemplateConfigs::SERVICE['VALUE']) {

                            $this->createPage($request,$postId,MetaKey::COMPLETE_ITEM['VALUE']);

                        }else if ($pageTemplate == PageTemplateConfigs::ABOUT['VALUE']) {

                            $this->createPage($request,$postId,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE']);

                        }
                        Log::info('User '.Auth::id().' has created page'.$postId);
                        return redirect()->route('page.add',$template)->with('message', 'success|Successfully create  "'. $request->input('post_title').'" page');
                    }
                }
            }catch (\Throwable $th){
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }

        }
    }

    private function createPage($request,$postId,$completeItem,$imageItem = null){
        $dataMeta = [];
        if ($imageItem) {
            $images = $request->input('gallery');
            $dataMeta[] = [
                'post_id' => $postId,
                'meta_key' => MetaKey::IMAGE_ITEM['VALUE'],
                'meta_value' => json_encode($images),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $dataMeta[] = [
                'post_id' => $postId,
                'meta_key' => MetaKey::INDEX_IMAGE_ITEM['VALUE'],
                'meta_value' => json_encode($request->input('rowItem')),
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        if ($completeItem){
            $images = $request->input('images');
            $descriptions = $request->input('descriptions');
            $itemMeta = [];
            if (!empty($descriptions) && !empty($images)) {
                foreach ($images as $key => $value) {
                    $itemMeta[] = [
                        'image' => $value,
                        'desc' => $descriptions[$key]
                    ];
                }
                $dataMeta[] = [
                    'post_id' => $postId,
                    'meta_key' => $completeItem,
                    'meta_value' => json_encode($itemMeta),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($request->input('numbers')) {
                    $dataMeta[] = [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::INDEX_COMPLETE_ITEM['VALUE'],
                        'meta_value' => json_encode($request->input('numbers')),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }

            }
        }

        if ($this->postMetaRepository->insert($dataMeta)) {
            return true;
        }else{
            return false;
        }

    }

    private function updatePage($request,$postId,$completeItem,$imageItem = null) {
        $result = false;

        if ($imageItem) {
            $condition = [['post_id','=',$postId],['meta_key' ,'=', $imageItem]];
            $images =  $request->input('gallery');
            $index = $request->input('rowItem');
            if (isset($images) && !empty($images)) {
                $dataMeta = [
                    'meta_value' => json_encode($images)
                ];
                if ($this->postMetaRepository->getMetaValueByCondition($condition)){
                    $this->postMetaRepository->updateByCondition($condition,$dataMeta);
                }else{
                    $this->postMetaRepository->create([
                        'post_id' => $postId,
                        'meta_key' => $imageItem,
                        'meta_value' => json_encode($images)
                    ]);
                }

                $result = true;
            }
            if (isset($index) && !empty($index)) {
                $indexCondition = [['post_id','=',$postId],['meta_key' ,'=', MetaKey::INDEX_IMAGE_ITEM['VALUE']]];
                $dataMeta = [
                    'meta_value' => json_encode($index)
                ];

                if ($this->postMetaRepository->getMetaValueByCondition($indexCondition)){
                    $this->postMetaRepository->updateByCondition($indexCondition,$dataMeta);
                }else{
                    $this->postMetaRepository->create([
                        'post_id' => $postId,
                        'meta_key' => MetaKey::INDEX_IMAGE_ITEM['VALUE'],
                        'meta_value' => json_encode($index)
                    ]);
                }
            }
        }
        if ($completeItem) {
            $images = $request->input('images');
            $descriptions = $request->input('descriptions');
            $condition = [['post_id','=',$postId],['meta_key' ,'=', $completeItem]];
            $items = [];
            if (isset($images) && !empty($images) && isset($descriptions) && !empty($descriptions)) {
                foreach ($images as $key => $value) {
                    $items[] = [
                        'image' => $value,
                        'desc' => $descriptions[$key]
                    ];
                }

                $dataMeta = [
                    'meta_value' => json_encode($items)
                ];

                if ($this->postMetaRepository->getMetaValueByCondition($condition)){
                    $this->postMetaRepository->updateByCondition($condition,$dataMeta);
                }else{
                    $this->postMetaRepository->create([
                        'post_id' => $postId,
                        'meta_key' => $completeItem,
                        'meta_value' => json_encode($items)
                    ]);
                }
                $result = true;
            }

            if ($request->input('numbers')) {
                $numberCondition = [['post_id','=',$postId],['meta_key' ,'=', MetaKey::INDEX_COMPLETE_ITEM['VALUE']]];
                $dataNumber = [
                    'meta_value' => json_encode($request->input('numbers')),
                ];

                if ($this->postMetaRepository->getMetaValueByCondition($numberCondition)){
                    $this->postMetaRepository->updateByCondition($numberCondition,$dataNumber);
                }else{
                    $this->postMetaRepository->create([
                        'post_id' => $postId,
                        'meta_key' => MetaKey::INDEX_COMPLETE_ITEM['VALUE'],
                        'meta_value' => json_encode($request->input('numbers'))
                    ]);
                }
                $result = true;
            }
        }
        return $result;
    }


    // translation
    public function translationSave(Request $request, $template) {
        app()->setLocale($request->translation);
        $this->postRepository->setModel();
        $this->postMetaRepository->setModel();
        $post_title = $request->input('post_title');
        $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
        $result = false;
        $pageTemplate = PageTemplateConfigs::parse($template)['VALUE'];
        $dataPost = [
            'post_title' => $post_title,
            'post_name' => $request->input('post_name'),
            'post_author' => Auth::id(),
            'post_status' => $status,
            'post_excerpt' => $request->input('post_excerpt'),
            'post_content' => $request->input('post_content'),
            'post_type' => $template
        ];

//        try {

            $translationRecord = $this->postRepository->filter([['post_name' , $request->input('post_name')]]);

            if($translationRecord && $translationRecord->isNotEmpty()) {
                // update
                $transUrl = renderTranslationUrl(route('page.add', ['template' => $template]), $request->translation);
                return [ 'redirect_url' => $transUrl, 'message' => 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.' ];
            } else {
                $postId = $this->postRepository->create($dataPost)->id;
                if ($postId) {
                    $files = $request->input('files');
                    if (isset($files) && !empty($files)) {
                        $dataMeta =
                            [
                                'post_id' => $postId,
                                'meta_key' => MetaKey::BANNER['VALUE'],
                                'meta_value' => json_encode($files)
                            ];
                        $this->postMetaRepository->create($dataMeta);
                    }

                    if ($pageTemplate == PageTemplateConfigs::SERVICE['VALUE']) {

                        $this->createPage($request, $postId, MetaKey::COMPLETE_ITEM['VALUE']);

                    } else if ($pageTemplate == PageTemplateConfigs::ABOUT['VALUE']) {

                        $this->createPage($request, $postId, MetaKey::COMPLETE_ITEM['VALUE'], MetaKey::IMAGE_ITEM['VALUE']);

                    }

                    Log::info('User ' . Auth::id() . ' has created page' . $postId);

                    $transUrl = renderTranslationUrl(route('page.add', ['template' => $template]), $request->translation);
                    return [ 'redirect_url' => $transUrl,
                        'message' => 'success|Successfully add a Translation"' . $request->input('post_name') . '" page', 'post_id' => $postId
                    ];

                } else {
                    return false;
                }

            }

//        } catch (\Throwable $th) {
//            return false;
//        }
    }
}
