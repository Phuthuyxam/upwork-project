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
                'images.*' => 'mimes:jpg,png,gif',
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
                    $images = $request->file('images');
                    $descriptions = $request->input('descriptions');
                    $itemMeta = [];
                    if (!empty($descriptions) && !empty($images)) {
                        foreach ($images as $key => $value) {
                            $value->storeAs('public/pages/' . $postId . '_' . $post_title . '/slides', $value->getClientOriginalName());
                            $itemMeta[] = [
                                'image' => 'storage/pages/' . $postId . '_' . $post_title . '/slides/' . $value->getClientOriginalName(),
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
                            $result = true;
                        }else{
                            $result = false;
                        }
                    }else{
                        $result = false;
                    }
                }

                if ($result) {
                    return redirect('Page::add')->with('message', 'success|Successfully create  "'. $request->input('post_title').'" page');
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
                'file.*' => 'mimes:jpg,png,gif',
                'post_content' => 'required',
                'post_excerpt' => 'required',
                'images.*' => 'mimes:jpg,png,gif',
                'template' => 'required',
                'items' => 'required'
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
        }
    }

    public function template(Request $request) {
        $template = $request->input('template');

        if ($template == PageTemplateConfigs::SERVICE['VALUE']) {
            $html = view(PageTemplateConfigs::SERVICE['VIEW'])->render();
            return response($html);
        }
    }

}
