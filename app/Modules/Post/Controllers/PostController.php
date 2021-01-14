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

    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            $taxonomy = $this->termRepository->getAll()->toArray();
            $slugs = $this->posRepository->getAllSlugs();
            return view('Post::add', compact('slugs', 'taxonomy'));
        } else {
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts',
                'post_content' => 'required',
                'taxonomy' => 'required',
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
                'post_type' => PostType::POST['VALUE']
            ];
            $postId = $this->posRepository->create($dataPost)->id;
            if ($postId) {
                $result = true;
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

                $dataMap = [
                    'image' => $request->input('map_image') ? $request->input('map_image') : '',
                    'address' => $request->input('map_address') ? $request->input('map_address') : '',
                    'location' => [
                        'lat' => $request->input('map_lat') ? $request->input('map_lat') : '',
                        'long' => $request->input('map_long') ? $request->input('map_long') : ''
                    ]
                ];

                // Save post meta
                $dataPostMeta = [
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::BANNER['VALUE'],
                        'meta_value' => $request->input('files') ? json_encode($request->input('files')) : '',
                        'created_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::SLIDE['VALUE'],
                        'meta_value' => $request->input('images') ? json_encode($request->input('images')) : '',
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
                        'meta_value' => $request->input('facilities') ? json_encode($request->input('facilities')) : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::LOCATION['VALUE'],
                        'meta_value' => json_encode($dataMap),
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::RATE['VALUE'],
                        'meta_value' => $request->input('rate') ? $request->input('rate') : 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::THUMBNAIL['VALUE'],
                        'meta_value' => $request->input('thumb') ? json_encode($request->input('thumb')) : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::PRICE['VALUE'],
                        'meta_value' => $request->input('price') ? json_encode($request->input('price')) : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                ];

                if ($this->postMetaRepository->insert($dataPostMeta)) {
                    $result = true;
                }

                // Save term relation
                $dataTermRelation = [
                    'object_id' => $postId,
                    'term_taxonomy_id' => $request->input('taxonomy')
                ];
                if ($this->termRelationRepository->create($dataTermRelation)) {
                    $result = true;
                }
            }


            if ($result) {
                Log::info('user '.Auth::id().' has created hotel '. $postId);
                return redirect('admin/hotels/edit/' . $postId)->with('message', 'success|Successfully create  "' . $request->input('post_title') . '" hotel');
            } else {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            $post = $this->posRepository->find($id)->toArray();
            $postMeta = $this->postMetaRepository->getByPostId($id)->toArray();
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
                'post_content' => 'required',
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
                'post_type' => PostType::POST['VALUE']
            ];

            if ($this->posRepository->update($id,$dataPost)) {
                $result = false;

                //Save Slider
                if ($request->input('images')) {
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::SLIDE['VALUE']]];
                    $dataPostMeta = [
                        'meta_value' => json_encode($request->input('images'))
                    ];
                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }else{
                        $result = false;
                    }
                }

                //Save Banner
                if ($request->input('files')) {
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::BANNER['VALUE']]];
                    $dataPostMeta = [
                        'meta_value' => json_encode($request->input('files'))
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
                if ($request->input('facilities')) {
                    $facilities = $request->input('facilities');
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::FACILITY['VALUE']]];
                    $dataPostMeta =[
                        'meta_value' => json_encode($facilities)
                    ];
                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }

                // Save rate
                if ($request->input('rate')) {
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::RATE['VALUE']]];
                    $dataPostMeta =[
                        'meta_value' => $request->input('rate')
                    ];
                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }

                // Save price
                if ($request->input('price')) {
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::PRICE['VALUE']]];
                    $dataPostMeta =[
                        'meta_value' => json_encode($request->input('price'))
                    ];
                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }

                // Save thumbnail
                if ($request->input('thumb')) {
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::THUMBNAIL['VALUE']]];
                    $dataPostMeta =[
                        'meta_value' => json_encode($request->input('thumb'))
                    ];
                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }

                // Save map
                $mapCondition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::LOCATION['VALUE']]];
                $dataMap = [
                    'image' => $request->input('map_image') ? $request->input('map_image') : '',
                    'address' => $request->input('map_address') ? $request->input('map_address') : '',
                    'location' => [
                        'lat' => $request->input('map_lat') ? $request->input('map_lat') : '',
                        'long' =>  $request->input('map_long') ? $request->input('map_long') : ''
                    ]
                ];

                $metaMap = [
                    'meta_value' => json_encode($dataMap)
                ];

                if ($this->postMetaRepository->updateByCondition($mapCondition,$metaMap)) {
                    $result = true;
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
