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

    public function index(){
        $pages = $this->postRepository->getPages();
        return view('Page::index',compact('pages'));
    }

    public function add(Request $request) {
        if ($request->isMethod('get')) {
            return view('Page::add');
        }else{
            try {
                $validate = $request->validate([
                    'post_title' => 'required|max:191',
                    'post_name' => 'required|unique:posts',
                    'post_excerpt' => '',
                    'template' => 'required'
                ]);

                $post_title = $request->input('post_title');
                $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
                $result = false;

                $dataPost = [
                    'post_title' => $post_title,
                    'post_name' => $request->input('post_name'),
                    'post_author' => Auth::id(),
                    'post_status' => $status,
                    'post_excerpt' => $request->input('post_excerpt'),
                    'post_content' => $request->input('post_content'),
                    'post_type' => PostType::PAGE['VALUE']
                ];
                $postId = $this->postRepository->create($dataPost)->id;
                if ($postId) {
                    $result = false;
                    $files = $request->input('files');
                    if (isset($files) && !empty($files)){
                        $fileMap = [];
                        foreach ($files as $value) {
                            $fileMap[] = $value;
                        }
                        $dataMeta = [
                            [
                                'post_id' => $postId,
                                'meta_key' => MetaKey::BANNER['VALUE'],
                                'meta_value' => json_encode($fileMap)
                            ],

                            [
                                'post_id' => $postId,
                                'meta_key' => MetaKey::PAGE_TEMPLATE['VALUE'],
                                'meta_value' => $request->input('template')
                            ],
                        ];
                        $this->postMetaRepository->getInstantModel()->insert($dataMeta);
                    }

                    if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {

                        $this->createPage($request,$postId,MetaKey::COMPLETE_ITEM['VALUE']);

                    }else if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {

                        $this->createPage($request,$postId,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE']);

                    }else{
                        $this->postMetaRepository->create([
                            'post_id' => $postId,
                            'meta_key' => MetaKey::PAGE_TEMPLATE['VALUE'],
                            'meta_value' => $request->input('template')
                        ]);
                    }
                    Log::info('User '.Auth::id().' has created page'.$postId);
                    return redirect()->route('page.edit', ['id' => $postId])->with('message', 'success|Successfully create  "'. $request->input('post_title').'" page');
                }
            }catch (\Throwable $th){
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }

        }
    }

    public function edit(Request $request,$id){
        if ($request->isMethod('get')) {
            $page = $this->postRepository->find($id);
            $result = $page->toArray();
            $slugs = $this->postRepository->getAllSlugs();

            if(LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()){
                $translationPost = $page->postFromTranslation;
            }

            $translationPost = $page->postToTranslation;

            if(!empty($translationPost) && $translationPost->isNotEmpty()){
                $langCode = (LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()) ?  $translationPost[0]->to_lang : $translationPost[0]->from_lang;
                $langId = (LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()) ?  $translationPost[0]->from_object_id : $translationPost[0]->to_object_id;
                $translationRecord = [ 'url' => renderTranslationUrl(route('page.edit' , $langId), $langCode) , 'lang_code' => $langCode ];
            } else {
                $translationRecord = false;
            }





            $pageMeta = $page->postMeta->toArray();

            foreach ($pageMeta as $value) {
                $result[MetaKey::display($value['meta_key'])] = $value['meta_value'];
            }

            if ($result[MetaKey::PAGE_TEMPLATE['NAME']] == PageTemplateConfigs::ABOUT['VALUE']){
                $imageMap = [];
                if (isset($result[MetaKey::IMAGE_ITEM['NAME']]) && !empty($result[MetaKey::IMAGE_ITEM['NAME']])){
                    $imageItem = json_decode($result[MetaKey::IMAGE_ITEM['NAME']]);
                    $indexImage = json_decode($result[MetaKey::INDEX_IMAGE_ITEM['NAME']]);
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
                if (isset($result[MetaKey::INDEX_COMPLETE_ITEM['NAME']]) && !empty($result[MetaKey::INDEX_COMPLETE_ITEM['NAME']])) {
                    $items = json_decode($result[MetaKey::COMPLETE_ITEM['NAME']]);
                    $indexItem = json_decode($result[MetaKey::INDEX_COMPLETE_ITEM['NAME']]);
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
                return view('Page::edit',compact('result','slugs','imageMap','itemMap','translationRecord'));
            }

            return view('Page::edit',compact('result','slugs', 'translationRecord'));
        }else{
            try {
                $currentLang = app()->getLocale();
                $validateRule = [
                    'post_title' => 'required|max:191',
                    'post_name' => 'required|unique:posts,post_name,'.$id,
                    'post_excerpt' => 'required',
                    'template' => 'required',
                ];
                $prefixLanguage = generatePrefixLanguage();
                if(isset($prefixLanguage) && !empty($prefixLanguage) && LocationConfigs::checkLanguageCode(str_replace("/","",$prefixLanguage))
                    && LocationConfigs::getLanguageDefault()['VALUE'] != str_replace("/","",$prefixLanguage))
                    $validateRule['post_name'] = "required|unique:posts_". str_replace("/","",$prefixLanguage) .",post_name," . $id;
                $validate = $request->validate($validateRule);
                // make translation
                if(isset($request->translation) && !empty($request->translation) && LocationConfigs::checkLanguageCode($request->translation)) {
                    // check has record in relationship
                    $translationMapping = $this->translationRelationRepository->filter([['from_object_id',$id] , ['from_lang', $currentLang] , ['to_lang' , $request->translation], ['type' , 'post']]);
                    if($translationMapping && $translationMapping->isNotEmpty()) {
                        $transUrl = renderTranslationUrl(route('page.edit', ['id' => $translationMapping[0]->to_object_id]), $request->translation);
                        return redirect()->to($transUrl)->with('message', 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.');
                    }

//                    $translationMapping = $this->translationRelationRepository->filter([['to_object_id',$id] , ['from_lang', $currentLang] , ['to_lang' , $request->translation], ['type' , 'post']]);
//                    if($translationMapping && $translationMapping->isNotEmpty()) {
//                        $transUrl = renderTranslationUrl(route('page.edit', ['id' => $translationMapping[0]->to_object_id]), $request->translation);
//                        return redirect()->to($transUrl)->with('message', 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.');
//                    }

                        $translation = $this->translationSave($request);
                        if($translation){
                            // make record relationship translation
                            if(isset($translation['post_id']) && !empty($translation['post_id'])) {
                                $translationRecord = [
                                    'to_object_id' => $translation['post_id'],
                                    'from_object_id' => $id,
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


                $pageMetaMap = [];
                $pageMeta = $this->postMetaRepository->getByPostId($id)->toArray();
                foreach ($pageMeta as $value) {
                    $pageMetaMap[MetaKey::display($value['meta_key'])] = $value['meta_value'];
                }

                $post_title = $request->input('post_title');
                $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
                $result = false;

                // Save Post
                $dataPost = [
                    'post_title' => $post_title,
                    'post_name' => $request->input('post_name'),
                    'post_author' => Auth::id(),
                    'post_excerpt' => $request->input('post_excerpt'),
                    'post_status' => $status,
                    'post_content' => $request->input('post_content'),
                    'post_type' => PostType::PAGE['VALUE']
                ];

                if ($this->postRepository->update($id,$dataPost)) {
                    $result = true;
                }
                // update image
                $metaImages = $this->postMetaRepository->getInstantModel()->where([['post_id', $id] , ['meta_key', MetaKey::PAGE_TEMPLATE['VALUE']]])->get();
                if($metaImages->isNotEmpty()) {
                    $this->postMetaRepository->getInstantModel()->where([['post_id', $id] , ['meta_key', MetaKey::BANNER['VALUE']]])
                        ->update(['meta_value' => json_encode($request->input('files'))]);
                }else{
                    $this->postMetaRepository->getInstantModel()->create([
                        'post_id' => $id,
                        'meta_key' => MetaKey::BANNER['VALUE'],
                        'meta_value' => json_encode($request->input('files'))
                    ]);
                }

                // change template
                if ($pageMetaMap[MetaKey::PAGE_TEMPLATE['NAME']] != $request->input('template')) {
                    $fields = MetaKey::pageDeleteAbleField();
                    $this->postMetaRepository->deleteFields($id,$fields);
                    $dataTemplate = [
                        'meta_value' => $request->input('template')
                    ];

                    $this->postMetaRepository->updateByCondition([['post_id','=',$id],['meta_key' ,'=', MetaKey::PAGE_TEMPLATE['VALUE']]],$dataTemplate);
                }


                if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {
                    $this->updatePage($request,$id,MetaKey::COMPLETE_ITEM['VALUE']);
                }

                if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {
                    $this->updatePage($request,$id,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE']);
                }

                Log::info('User '.Auth::id().' has updated page'.$id);
                return redirect()->back()->with('message', 'success|Successfully update  "'. $request->input('post_title').'" page');
            }catch (\Throwable $th) {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }

    public function template(Request $request) {
        $template = $request->input('template');

        if ($template == PageTemplateConfigs::SERVICE['VALUE']) {
            $html = view(PageTemplateConfigs::SERVICE['VIEW'])->render();
            return response($html);
        }
        if ($template == PageTemplateConfigs::ABOUT['VALUE']) {
            $html = view(PageTemplateConfigs::ABOUT['VIEW'])->render();
            return response($html);
        }
        if ($template == PageTemplateConfigs::HOTEL['VALUE'] || $template == PageTemplateConfigs::DEFAULT['VALUE']
        || $template == PageTemplateConfigs::CONTACT['VALUE']){
            return response('default');
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

    public function deleteMany(Request $request) {
        $data = $request->input('ids');
        if ($data != '') {
            $valid = false;
            $ids = explode(',',$data);
            if ($this->posRepository->deleteMany('id',$ids)) $valid = true;
            if ($this->postMetaRepository->deleteMany('post_id',$ids)) $valid = true;
            if ($valid) {
                return response(ResponeCode::SUCCESS['CODE']);
                Log::info('user '.Auth::id().' has deleted page ['.$data.']');
            }else{
                return response(ResponeCode::SERVERERROR['CODE']);
            }
        }else{
            return response(ResponeCode::BADREQUEST['CODE']);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        try {
            if (isset($id) && !empty($id)) {
                $this->posRepository->delete($id);
                $this->postMetaRepository->deleteByPostId($id);
            }
            Log::info('user '.Auth::id().' has deleted post '.$id);
            return response(ResponeCode::SUCCESS['CODE']);
        } catch (\Throwable $th) {
            return response(ResponeCode::SERVERERROR['CODE']);
        }
    }

    // translation
    public function translationSave(Request $request) {
        app()->setLocale($request->translation);
        $this->postRepository->setModel();
        $this->postMetaRepository->setModel();
        $post_title = $request->input('post_title');
        $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
        $result = false;

        $dataPost = [
            'post_title' => $post_title,
            'post_name' => $request->input('post_name'),
            'post_author' => Auth::id(),
            'post_status' => $status,
            'post_excerpt' => $request->input('post_excerpt'),
            'post_content' => $request->input('post_content'),
            'post_type' => PostType::PAGE['VALUE']
        ];

        try {

            $translationRecord = $this->postRepository->filter([['post_name' , $request->input('post_name')]]);

            if($translationRecord && $translationRecord->isNotEmpty()) {
                // update
                $transUrl = renderTranslationUrl(route('page.edit', ['id' => $translationRecord[0]->id]), $request->translation);
                return [ 'redirect_url' => $transUrl, 'message' => 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.' ];
            } else {
                $postId = $this->postRepository->create($dataPost)->id;
                if ($postId) {
                    $result = false;
                    $files = $request->input('files');
                    if (isset($files) && !empty($files)) {
                        $fileMap = [];
                        foreach ($files as $value) {
                            $fileMap[] = $value;
                        }
                        $dataMeta = [
                            [
                                'post_id' => $postId,
                                'meta_key' => MetaKey::BANNER['VALUE'],
                                'meta_value' => json_encode($fileMap)
                            ],

                            [
                                'post_id' => $postId,
                                'meta_key' => MetaKey::PAGE_TEMPLATE['VALUE'],
                                'meta_value' => $request->input('template')
                            ],
                        ];
                        $this->postMetaRepository->getInstantModel()->insert($dataMeta);
                    }

                    if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {

                        $this->createPage($request, $postId, MetaKey::COMPLETE_ITEM['VALUE']);

                    } else if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {

                        $this->createPage($request, $postId, MetaKey::COMPLETE_ITEM['VALUE'], MetaKey::IMAGE_ITEM['VALUE']);

                    } else {
                        $this->postMetaRepository->create([
                            'post_id' => $postId,
                            'meta_key' => MetaKey::PAGE_TEMPLATE['VALUE'],
                            'meta_value' => $request->input('template')
                        ]);
                    }
                    Log::info('User ' . Auth::id() . ' has created page' . $postId);

                    $transUrl = renderTranslationUrl(route('page.edit', ['id' => $postId]), $request->translation);
                    return [ 'redirect_url' => $transUrl,
                        'message' => 'success|Successfully add a Translation"' . $request->input('post_name') . '" page', 'post_id' => $postId
                    ];

                } else {
                    return false;
                }
            }

        } catch (\Throwable $th) {
            return false;
        }




    }
}
