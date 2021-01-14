<?php


namespace App\Modules\Page\Controllers;


use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PageTemplateConfigs;
use App\Core\Glosary\PostStatus;
use App\Core\Glosary\PostType;
use App\Core\Glosary\ResponeCode;
use App\Http\Controllers\Controller;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
        $pages = $this->postRepository->getPages();
        return view('Page::index',compact('pages'));
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
//                    $this->createPage($request,$postId,MetaKey::PAGE_TEMPLATE['VALUE'],MetaKey::COMPLETE_ITEM['VALUE'],'items');
                        $this->createPage($request,$postId,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE']);
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
            return view('Page::edit',compact('result','slugs'));
        }else{
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts,post_name,'.$id,
//                'files.*' => 'mimes:jpg,png,gif',
//                'post_content' => 'required',
                'post_excerpt' => 'required',
                'template' => 'required',
            ]);


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

            if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {
                $this->updatePage($request,$id,MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE']);
            }

            if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {
                $this->updatePage($request,$id,MetaKey::COMPLETE_ITEM['VALUE'],'items');
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

    private function updatePage($request,$postId,$completeItem,$imageItem) {
        $result = false;
        $images = $request->input('images');
        $descriptions = $request->input('descriptions');
        if ($imageItem) {
            $folderName = 'imageItem';
            $condition = [['post_id','=',$postId],['meta_key' ,'=', $imageItem]];
            $keyArray = array_keys($request->all());
            $keyMap = [];
            foreach ($keyArray as $value) {
                if (strpos($value,'row')){
                    $keyMap[] = $value;
                }
            }
            if (!empty($keyMap)) {
                $postMeta = $this->postMetaRepository->getMetaValueByCondition($condition);
                if ($postMeta) {
                    $imageMap = $request->input('rowMap');
                    $imageMeta = json_decode($postMeta['meta_value']);
                    $itemMap = [];

                    foreach ($imageMap as $key => $value) {
                        if ($value == '') {

                        }
                    }
                }
            }
        }
        if ($completeItem) {
            $condition = [['post_id','=',$postId],['meta_key' ,'=', $completeItem]];
            $items = [];
            foreach ($images as $key => $value) {
                $items[] = [
                    'image' => $value,
                    'desc' => $descriptions[$key]
                ];
            }

            $dataMeta = [
                'meta_value' => json_encode($items)
            ];
            if ($request->input('numbers')) {
                $dataNumber = [
                    'meta_value' => json_encode($request->input('numbers')),
                ];
                $this->postMetaRepository->updateByCondition([['post_id','=',$postId],['meta_key' ,'=', MetaKey::COMPLETE_ITEM['VALUE']]],$dataNumber);
            }

            if ($this->postMetaRepository->updateByCondition($condition,$dataMeta)){
                return true;
            }else{
                return false;
            }
        }

        return false;
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
}
