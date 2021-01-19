<?php

namespace App\Modules\Post\Controllers;

use App\Core\Glosary\LocationConfigs;
use App\Core\Glosary\PostStatus;
use App\Core\Glosary\MetaKey;
use App\Core\Glosary\PostType;
use App\Core\Glosary\ResponeCode;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;
use App\Modules\Translations\Repositories\TranslationRelationshipRepository;
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
    protected $translationRelationRepository;

    public function __construct(PostRepository $posRepository, PostMetaRepository $postMetaRepository,
                                TermRepository $termRepository, TermRelationRepository $termRelationRepository,
                                TranslationRelationshipRepository $translationRelationRepository)
    {
        $this->posRepository = $posRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->termRepository = $termRepository;
        $this->termRelationRepository = $termRelationRepository;
        $this->translationRelationRepository = $translationRelationRepository;
    }

    public function index(Request $request)
    {
        $posts = $this->posRepository->getPosts();
        return view('Post::index',compact('posts'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            $currentLanguage = generatePrefixLanguage() ? generatePrefixLanguage() : 'en/' ;
            $taxonomy = $this->termRepository->getAll()->toArray();
            $slugs = $this->posRepository->getAllSlugs();
            return view('Post::add', compact('slugs', 'taxonomy','currentLanguage'));
        } else {
            $validate = $request->validate([
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts',
                'post_content' => 'required'
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
                    'address' => $request->input('map_address') ? $request->input('map_address') : '',
                    'city' => $request->input('map_city') ? $request->input('map_city') : '',
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
                    [
                        'post_id' => $postId,
                        'meta_key' => MetaKey::LOGO['VALUE'],
                        'meta_value' => $request->input('logo') ? json_encode($request->input('logo')) : '',
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                ];

                if ($this->postMetaRepository->insert($dataPostMeta)) {
                    $result = true;
                }

            }

            if ($result) {
                Log::info('user '.Auth::id().' has created hotel '. $postId);
                return redirect(route('post.edit', ['id' => $postId]))->with('message', 'success|Successfully create  "' . $request->input('post_title') . '" hotel');
            } else {
                return redirect()->back()->with('message', 'danger|Something wrong try again!');
            }
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            $currentLanguage = generatePrefixLanguage() ? generatePrefixLanguage() : 'en/' ;
            $post = $this->posRepository->find($id)->toArray();
            $postMeta = $this->postMetaRepository->getByPostId($id)->toArray();
            $postMetaMap = [];
            foreach ($postMeta as $value) {
                $postMetaMap[$value['meta_key']] = json_decode($value['meta_value']);
            }
            $slugs = $this->termRepository->getAllSlug();
            $postRecod = $this->posRepository->find($id);
            if(LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()){
                $translationPost = $postRecod->postFromTranslation;
            }else {
                $translationPost = $postRecod->postToTranslation;
            }

            if(!empty($translationPost) && $translationPost->isNotEmpty()){
                $langCode = (LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()) ?  $translationPost[0]->to_lang : $translationPost[0]->from_lang;
                $langId = (LocationConfigs::getLanguageDefault()['VALUE'] == app()->getLocale()) ?  $translationPost[0]->from_object_id : $translationPost[0]->to_object_id;
                $translationRecord = [ 'url' => renderTranslationUrl(route('page.edit' , $langId), $langCode) , 'lang_code' => $langCode ];
            } else {
                $translationRecord = false;
            }
            return view('Post::edit', compact('post', 'postMetaMap','slugs','translationRecord','currentLanguage'));
        }else {
            $currentLang = app()->getLocale();
            $validateRule = [
                'post_title' => 'required|max:191',
                'post_name' => 'required|unique:posts,post_name,'.$id,
                'post_content' => 'required',
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
                    $transUrl = renderTranslationUrl(route('post.edit', ['id' => $translationMapping[0]->to_object_id]), $request->translation);
                    return redirect()->to($transUrl)->with('message', 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.');
                }

                //
//                $translationMapping = $this->translationRelationRepository->filter([['from_object_id',$id] , ['to_lang', $currentLang] , ['from_lang' , $request->translation], ['type' , 'post']]);
//                if($translationMapping && $translationMapping->isNotEmpty()) {
//                    $transUrl = renderTranslationUrl(route('post.edit', ['id' => $translationMapping[0]->to_object_id]), $request->translation);
//                    return redirect()->to($transUrl)->with('message', 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.');
//                }

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



            $post_title = $request->input('post_title');
            $status = $request->input('status') == 0 ? PostStatus::DRAFT['VALUE'] : PostStatus::PUBLIC['VALUE'];
            $result = false;

            // Save Post
            $dataPost = [
                'post_title' => $post_title,
                'post_name' => $request->input('post_name'),
                'post_author' => Auth::id(),
                'post_status' => $status,
                'post_content' => $request->input('post_content')
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

                // Save logo
                if ($request->input('logo')) {
                    $condition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::LOGO['VALUE']]];
                    $dataPostMeta =[
                        'meta_value' => json_encode($request->input('logo'))
                    ];
                    if ($this->postMetaRepository->updateByCondition($condition,$dataPostMeta)) {
                        $result = true;
                    }
                }

                // Save map
                $mapCondition = [['post_id','=',$id],['meta_key' ,'=', MetaKey::LOCATION['VALUE']]];
                $dataMap = [
                    'address' => $request->input('map_address') ? $request->input('map_address') : '',
                    'city' => $request->input('map_city') ? $request->input('map_city') : '',
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

    public function translationSave(Request $request) {
        app()->setLocale($request->translation);
        $this->posRepository->setModel();
        $this->postMetaRepository->setModel();
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
        $translationRecord = $this->posRepository->filter([['post_name' , $request->input('post_name')]]);

        if($translationRecord && $translationRecord->isNotEmpty()) {
            $transUrl = renderTranslationUrl(route('post.edit', ['id' => $translationRecord[0]->id]), $request->translation);
            return [ 'redirect_url' => $transUrl, 'message' => 'warning|Warning! when creating the translation. A record already exists. Please edit with this one.' ];
        }else {
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
//                $dataTermRelation = [
//                    'object_id' => $postId,
//                    'term_taxonomy_id' => $request->input('taxonomy')
//                ];
//                if ($this->termRelationRepository->create($dataTermRelation)) {
//                    $result = true;
//                }
            }


            if ($result) {
                Log::info('user '.Auth::id().' has created hotel '. $postId);
                $transUrl = renderTranslationUrl(route('post.edit', ['id' => $postId]), $request->translation);
                return [ 'redirect_url' => $transUrl,
                    'message' => 'success|Successfully add a Translation"' . $request->input('post_name') . '" post', 'post_id' => $postId
                ];
            } else {
                return false;
            }
        }

    }
}
