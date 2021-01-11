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

    public function add(Request $request) {
        if ($request->isMethod('get')) {
            return view('Page::add');
        }else{
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts',
                'post_excerpt' => 'required',
                'files.*' => 'required|mimes:jpg,png,gif',
                'post_content' => 'required',
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
                $files = $request->file('files');
                if ($request->hasFile('files')){
                    $fileMap = [];
                    foreach ($files as $value) {
                        $fileName = $value->getClientOriginalName();
                        $value->storeAs('public/pages/' . $postId . '_' . $post_title . '/banner', $fileName);
                        $fileMap[] = 'storage/pages/' . $postId . '_' . $post_title . '/banner/'.$fileName;
                    }
                    $dataMeta = [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::BANNER['VALUE'],
                        'meta_value' => json_encode($fileMap)
                    ];
                    if ($this->postMetaRepository->create($dataMeta)) {
                        $result = true;
                    }else{
                        $result = false;
                    }
                }else {
                    $result = false;
                }

                if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {
                    if ($this->createServicePage($request)) {
                        $result = true;
                    }else{
                        $result = false;
                    }
                }

                if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {

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
                'files.*' => 'mimes:jpg,png,gif',
                'post_content' => 'required',
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

            if ($request->input('template') == PageTemplateConfigs::SERVICE['VALUE']) {
                $this->updateServicePage($request);
            }

//            if ($request->input('template') == PageTemplateConfigs::ABOUT['VALUE']) {
//
//            }

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
            if ($request->input('postId')) {
                $postId = $request->input('postId');
                $postMeta = $this->postMetaRepository->getMetaValueByCondition([['post_id','=',$postId],['meta_key','=',MetaKey::SERVICE_ITEM['VALUE']]])->toArray();
            }
            $html = view(PageTemplateConfigs::SERVICE['VIEW'])->render();
            return response($html);
        }
        if ($template == PageTemplateConfigs::ABOUT['VALUE']) {
            $html = view(PageTemplateConfigs::ABOUT['VIEW'])->render();
            return response($html);
        }
    }

    private function createServicePage($request){
        $images = $request->file('images');
        $descriptions = $request->input('descriptions');
        $itemMeta = [];
        if (!empty($descriptions) && !empty($images)) {
            foreach ($images as $key => $value) {
                $value->storeAs('public/pages/' . $postId . '_' . $post_title . '/items', $value->getClientOriginalName());
                $itemMeta[] = [
                    'image' => 'storage/pages/' . $postId . '_' . $post_title . '/items/' . $value->getClientOriginalName(),
                    'desc' => $descriptions[$key]
                ];
            }

            $dataMeta = [
                [
                    'post_id' => $postId,
                    'meta_key' => MetaKey::SERVICE_ITEM['VALUE'],
                    'meta_value' => json_encode($itemMeta),
                    'created_at' => date('Y-m-d H:i:s')
                ],
                [
                    'post_id' => $postId,
                    'meta_key' => MetaKey::PAGE_TEMPLATE['VALUE'],
                    'meta_value' => $request->input('template'),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];

            if ($this->postMetaRepository->insert($dataMeta)) {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    private function updateServicePage($request) {
        $images = $request->file('images');
        $descriptions = $request->input('descriptions');
        if ($request->hasFile('images')) {
            // add or edit slide
            $postMeta = $this->postMetaRepository->getMetaValueByCondition([['post_id', '=', $id], ['meta_key', '=', MetaKey::SERVICE_ITEM['VALUE']]]);
            $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::SERVICE_ITEM['VALUE']]];
            if ($postMeta) {
                $postMeta = $postMeta->toArray();
                $slideMeta = json_decode($postMeta['meta_value']);
                foreach ($images as $key => $value) {
                    $value->storeAs('public/pages/' . $id . '_' . $post_title . '/items', $value->getClientOriginalName());
                    $slideMeta[$key] = [
                        'image' => 'storage/pages/' . $id . '_' . $post_title . '/items/' . $value->getClientOriginalName(),
                        'desc' =>$descriptions[$key]
                    ];
                }
                $dataPostMeta = [
                    'meta_value' => json_encode($slideMeta)
                ];
                if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                    return true;
                }
            }
        }else{
            // delete
            $imageMap = $request->input('imageMap');
            $descriptions = $request->input('descriptions');
            $serviceMap = [];
            if (!empty($imageMap)) {
                $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::SERVICE_ITEM['VALUE']]];

                foreach ($imageMap as $key => $value) {
                    $serviceMap[] = [
                        'image' => $value,
                        'desc' => $descriptions[$key]
                    ];
                }
                $dataPostMeta = [
                    'meta_value' => json_encode($serviceMap)
                ];

                if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                    return true;
                }
            }
        }
        return false;
    }
}
