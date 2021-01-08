<?php
namespace App\Modules\Post\Controllers;

use App\Core\Glosary\PostStatus;
use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PostType;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller{

    protected $posRepository;
    protected $postMetaRepository;

    public function __construct(PostRepository $posRepository, PostMetaRepository $postMetaRepository){
        $this->posRepository = $posRepository;
        $this->postMetaRepository = $postMetaRepository;
    }

    public function index(Request $request){
//        $get = $this->posRepository->getAll();
//        dump($get);
        dump("asdad");
    }

    public function add(Request $request){
        if ($request->isMethod('get')) {
            $slugs = $this->posRepository->getAllSlugs();
            return view('Post::add',compact('slugs'));
        }else{
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts',
                'file' => 'required|mimes:jpg,png,gif',
                'post_content' => 'required',
                'images.*' =>'mimes:jpg,png,gif',
            ]);
            $post_title = $request->input('post_title');
            $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['value'];
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
                        $value->storeAs('public/posts/'.$postId.'_'.$post_title.'/slides', $value->getClientOriginalName());
                        $imageMap[] = 'public/posts/'.$postId.'_'.$post_title.'/slides/'.$value->getClientOriginalName();
                    }
                }

                // Banner
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $file->storeAs('public/posts/'.$postId.'_'.$post_title.'/banner', $fileName);

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

                $dataPostMeta = [
                    [
                        'post_id' =>  $postId,
                        'meta_key' => MetaKey::BANNER['VALUE'],
                        'meta_value' => 'public/posts/'.$postId.'_'.$post_title.'/banner/'.$fileName,
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
                return redirect('admin/post/edit/'.$postId)->with('message', 'success|Successfully create  "' . $request->input('post_title') . '" post');
            }else{
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }

    public function edit(Request $request,$id) {
        if ($request->isMethod('get')) {
            $post = $this->posRepository->find($id)->toArray();
            $postMeta = $this->postMetaRepository->getByPostId($id);
            return view('Post::edit',compact('post','postMeta'));
        }
    }

}
