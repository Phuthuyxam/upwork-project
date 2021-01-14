<?php


namespace App\Modules\Page\Controllers;


use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PageTemplateConfigs;
use App\Core\Glosary\PostStatus;
use App\Core\Glosary\PostType;
use App\Http\Controllers\Controller;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    protected $postRepository;
    protected $postMetaRepository;
    protected $termRepository;
    protected $termRelationRepository;

    public function __construct(PostRepository $posRepository, PostMetaRepository $postMetaRepository,
                                TermRepository $termRepository, TermRelationRepository $termRelationRepository)
    {
        $this->postRepository = $posRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->termRepository = $termRepository;
        $this->termRelationRepository = $termRelationRepository;
    }

    public function index(){
        return view('Page::index');
    }

    public function add(Request $request) {
        if ($request->isMethod('get')) {
            return view('Page::add');
        }else{
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts',
                'post_excerpt' => '',
//                'files.*' => 'mimes:jpg,png,gif',
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
                    if ($this->postMetaRepository->getInstantModel()->insert($dataMeta)) {
                        $result = true;
                    }else{
                        $result = false;
                    }
                }else {
                    $result = false;
                }

                if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {
                    if ($this->createPage($request,$postId,MetaKey::COMPLETE_ITEM['VALUE'])) {
                        $result = true;
                    }else{
                        $result = false;
                    }
                }

                if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {
                    if ($this->createPage($request,$postId,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE'])) {
                        $result = true;
                    }else{
                        $result = false;
                    }
                }
                if ($request->input('template') == PageTemplateConfigs::HOTEL['VALUE']) {
                    $this->postMetaRepository->create([
                        'post_id' => $postId,
                        'meta_key' => MetaKey::PAGE_TEMPLATE['VALUE'],
                        'meta_value' => $request->input('template')
                    ]);
                }

                if ($result) {
                    return redirect('/admin/page/edit/'.$postId)->with('message', 'success|Successfully create  "'. $request->input('post_title').'" page');
                }else{
                    return redirect()->back()->with('message', 'danger|Something wrong try again!');
                }
            }
        }
    }

    public function edit(Request $request,$id){
        if ($request->isMethod('get')) {
            $page = $this->postRepository->find($id);
            $result = $page->toArray();
            $slugs = $this->postRepository->getAllSlugs();
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
                return view('Page::edit',compact('result','slugs','imageMap','itemMap'));
            }

            return view('Page::edit',compact('result','slugs'));
        }else{
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts,post_name,'.$id,
                'post_excerpt' => 'required',
                'template' => 'required',
            ]);

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

                if ($this->postMetaRepository->updateByCondition([['post_id','=',$id],['meta_key' ,'=', MetaKey::PAGE_TEMPLATE['VALUE']]],$dataTemplate)){
                    $result = true;
                }else{
                    $result = false;
                }
            }


            if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {
                $this->updatePage($request,$id,MetaKey::COMPLETE_ITEM['VALUE']);
            }

            if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {
                $this->updatePage($request,$id,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE']);
            }

            if ($result) {
                return redirect()->back()->with('message', 'success|Successfully update  "'. $request->input('post_title').'" page');
            }else{
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
        if ($template == PageTemplateConfigs::HOTEL['VALUE']){
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
}
