<?php

namespace App\Modules\Post\Controllers;

use App\Core\Glosary\PostStatus;
use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PostType;
use App\Core\Glosary\ResponeCode;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{

    protected $posRepository;
    protected $postMetaRepository;
    protected $termRepository;
    protected $termRelationRepository;

    public function __construct(PostRepository $posRepository, PostMetaRepository $postMetaRepository,
                                TermRepository $termRepository, TermRelationRepository $termRelationRepository)
    {
        $this->posRepository = $posRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->termRepository = $termRepository;
        $this->termRelationRepository = $termRelationRepository;
    }

    public function index(Request $request)
    {
        $posts = $this->posRepository->getPosts();
        return view('Post::index',compact('posts'));
    }

    public function add(Request $request,$postType)
    {
        if ($request->isMethod('get')) {
            $taxonomy = $this->termRepository->getAll()->toArray();
            $slugs = $this->posRepository->getAllSlugs();
            return view('Post::add', compact('slugs', 'taxonomy'));
        } else {
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts',
                'file.*' => 'required|mimes:jpg,png,gif',
                'post_content' => 'required',
                'images.*' => 'mimes:jpg,png,gif',
            ]);
            $post_title = $request->input('post_title');
            $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
            $result = false;

            $dataPost = [
                'post_title' => $post_title,
                'post_name' => $request->input('post_name'),
                'post_author' => Auth::id(),
                'post_status' => $status,
                'post_content' => $request->input('post_content'),
                'post_type' => PostType::HOTEL['VALUE']
            ];
            $postId = $this->posRepository->create($dataPost)->id;
            if ($postId) {
                $result = true;
                // Slider
                $images = $request->file('images');
                $imageMap = [];
                if ($request->hasFile('images')) {
                    foreach ($images as $value) {
                        $value->storeAs('public/posts/' . $postId . '_' . $post_title . '/slides', $value->getClientOriginalName());
                        $imageMap[] = 'storage/posts/' . $postId . '_' . $post_title . '/slides/' . $value->getClientOriginalName();
                    }
                }

                // Banner
                $file = $request->file('file');
                $fileMap = [];
                foreach ($file as $value) {
                    $fileName = $value->getClientOriginalName();
                    $value->storeAs('public/posts/' . $postId . '_' . $post_title . '/banner', $fileName);
                    $fileMap[] = 'storage/posts/' . $postId . '_' . $post_title . '/banner/'.$fileName;
                }

                // Room Type
                $types = $request->input('room_types');
                $inventories = $request->input('inventories');

                $typeMap = [];
                if (!empty($types) && !empty($inventories)) {
                    foreach ($types as $key => $value) {
                        $typeMap[] = [
                            'type' => $value,
                            'inven' => $inventories[$key]
                        ];
                    }
                }

                // Facilities
                $facilities = $request->input('facilities');

                // Save post meta
                $dataPostMeta = [
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::BANNER['VALUE'],
                        'meta_value' => json_encode($fileMap),
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::SLIDE['VALUE'],
                        'meta_value' => !empty($imageMap) ? json_encode($imageMap) : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::ROOM_TYPE['VALUE'],
                        'meta_value' => !empty($typeMap) ? json_encode($typeMap) : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::FACILITY['VALUE'],
                        'meta_value' => !empty($facilities) ? json_encode($facilities) : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ];

                if ($this->postMetaRepository->insert($dataPostMeta)) {
                    $result = true;
                }

            }

            if ($result) {
                Log::info('user '.Auth::id().' has create post '. $postId);
                return redirect('admin/post/edit/' . $postId)->with('message', 'success|Successfully create  "' . $request->input('post_title') . '" post');
            } else {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            $post = $this->posRepository->find($id)->toArray();
            $postMeta = $this->postMetaRepository->getByPostId($id);
            $postMetaMap = [];
            foreach ($postMeta as $value) {
                $postMetaMap[$value['meta_key']] = json_decode($value['meta_value']);
            }
            $slugs = $this->termRepository->getAllSlug();
            $taxonomy = $this->termRepository->getAll();
            $term_id = $this->termRelationRepository->getByObjectId($id);
            return view('Post::edit', compact('post', 'postMetaMap','slugs','taxonomy','term_id'));
        }else {
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts,post_name,'.$id,
                'file.*' => 'mimes:jpg,png,gif',
                'post_content' => 'required',
                'images.*' => 'mimes:jpg,png,gif',
                'taxonomy' => 'required'
            ]);


            $post_title = $request->input('post_title');
            $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
            $result = false;

            // Save Post
            $dataPost = [
                'post_title' => $post_title,
                'post_name' => $request->input('post_name'),
                'post_author' => Auth::id(),
                'post_status' => $status,
                'post_content' => $request->input('post_content'),
                'post_type' => PostType::HOTEL['VALUE']
            ];

            if ($this->posRepository->update($id,$dataPost)) {
                $result = true;

                //Save Slider
                $images = $request->file('images');
                if ($request->hasFile('images')) {
                    // add or edit slide
                    $postMeta = $this->postMetaRepository->getMetaValueByCondition([['post_id', '=', $id], ['meta_key', '=', MetaKey::SLIDE['VALUE']]]);
                    $slideMeta = json_decode($postMeta['meta_value']);
                    foreach ($images as $key => $value) {
                        $value->storeAs('public/posts/' . $id . '_' . $post_title . '/slides', $value->getClientOriginalName());
                        $slideMeta[$key] = 'storage/posts/' . $id . '_' . $post_title . '/slides/' . $value->getClientOriginalName();
                    }
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::SLIDE['VALUE']]];
                    $dataPostMeta = [
                        'meta_value' => json_encode($slideMeta)
                    ];

                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }else{
                    // delete
                    $imageMap = $request->input('imageMap');
                    if (!empty($imageMap)) {
                        $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::SLIDE['VALUE']]];
                        $dataPostMeta = [
                            'meta_value' => json_encode($imageMap)
                        ];

                        if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                            $result = true;
                        }
                    }
                }

                //Save Banner
                $file = $request->file('files');
                if ($request->hasFile('files')) {
                    $postMeta = $this->postMetaRepository->getMetaValueByCondition([['post_id', '=', $id], ['meta_key', '=', MetaKey::BANNER['VALUE']]]);
                    $bannerMeta = json_decode($postMeta['meta_value']);
                    foreach ($file as $key => $value) {
                        $value->storeAs('public/posts/' . $id . '_' . $post_title . '/banner/', $value->getClientOriginalName());
                        $bannerMeta[$key] = 'storage/posts/' . $id . '_' . $post_title . '/banner/' . $value->getClientOriginalName();
                    }
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::BANNER['VALUE']]];
                    $dataPostMeta = [
                        'meta_value' => json_encode($bannerMeta)
                    ];

                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }

                }

                //Save Room Type
                $types = $request->input('room_types');
                $inventories = $request->input('inventories');

                $typeMap = [];
                if (!empty($types) && !empty($inventories)) {
                    foreach ($types as $key => $value) {
                        $typeMap[] = [
                            'type' => $value,
                            'inven' => $inventories[$key]
                        ];
                    }
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::ROOM_TYPE['VALUE']]];
                    $dataPostMeta = [
                        'meta_value' => json_encode($typeMap),
                    ];

                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }

               //Save Facilities
                $facilities = $request->input('facilities');
                if (!empty($facilities)) {
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::FACILITY['VALUE']]];
                    $dataPostMeta =[
                        'meta_value' => json_encode($facilities)
                    ];
                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }

                // Save term relation
                $taxonomy = $request->input('taxonomy');
                if (!empty($taxonomy)) {
                    $condition = [['object_id','=',$id]];
                    $dataTermRelation = [
                        'term_taxonomy_id' => $request->input('taxonomy')
                    ];
                    if ($this->termRelationRepository->updateByCondition($condition,$dataTermRelation)) {
                        $result = true;
                    }
                }
            }

            if ($result) {
                return redirect()->back()->with('message', 'success|Successfully update  "' . $request->input('post_title') . '" post');
            } else {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }

    public function deleteImage(Request $request) {
        $type = $request->input('type');
        $data = $request->input('data');
        $id = $request->input('id');

        $result = false;
        if ($type != '' && $data != '' && $id != '') {
            $condition = [
                ['post_id' ,'=', $id],
                ['meta_key','=',$type],
            ];
            $postMeta = $this->postMetaRepository->getMetaValueByCondition($condition);
            $metaValue = json_decode($postMeta['meta_value']);

//            $postMeta = json_decode($postMeta['meta_value']);
            $key = array_search($data, $metaValue);
            if ($key !== false) {
                $metaValue[$key] = "";
                if ($this->postMetaRepository->update($postMeta['id'],['meta_value' => json_encode($metaValue)])) {
                    $result = true;
                }
            }
        }
        if ($result) {
            return response(ResponeCode::SUCCESS['CODE']);
        }else {
            return response(ResponeCode::SERVERERROR['CODE']);
        }
    }

    public function deleteMany(Request $request) {
        $data = $request->input('ids');
        if ($data != '') {
            $valid = false;
            $ids = explode(',',$data);
            if ($this->posRepository->deleteMany('id',$ids)) $valid = true;
            if ($this->postMetaRepository->deleteMany('post_id',$ids)) $valid = true;
            if ($this->termRelationRepository->deleteMany('object_id',$ids)) $valid = true;
            if ($valid) {
                return response(ResponeCode::SUCCESS['CODE']);
                Log::info('user '.Auth::id().' has deleted post ['.$data.']');
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
                $this->termRelationRepository->deleteByPostId($id);
            }
            Log::info('user '.Auth::id().' has deleted post '.$id);
            return response(ResponeCode::SUCCESS['CODE']);
        } catch (\Throwable $th) {
            return response(ResponeCode::SERVERERROR['CODE']);
        }
    }
}
