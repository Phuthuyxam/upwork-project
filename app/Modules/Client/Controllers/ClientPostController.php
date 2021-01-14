<?php


namespace App\Modules\Client\Controllers;


use App\Core\Glosary\MetaKey;
use App\Http\Controllers\Controller;
use App\Modules\Post\Repositories\PostMetaRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\Taxonomy\Repositories\TermMetaRepository;
use App\Modules\Taxonomy\Repositories\TermRelationRepository;
use App\Modules\Taxonomy\Repositories\TermRepository;

class ClientPostController extends Controller
{

    protected $postRepository;
    protected $postMetaRepository;
    protected $termRepository;
    protected $termRelationRepository;
    protected $termMetaRepository;

    public function __construct(PostRepository $postRepository, PostMetaRepository $postMetaRepository,
                                TermRepository $termRepository, TermRelationRepository $termRelationRepository,
                                TermMetaRepository $termMetaRepository)
    {
        $this->postRepository = $postRepository;
        $this->postMetaRepository = $postMetaRepository;
        $this->termRepository = $termRepository;
        $this->termRelationRepository = $termRelationRepository;
        $this->termMetaRepository = $termMetaRepository;
    }

    public function detail($slug){
        if ($this->postRepository->getBySlug($slug)) {
            $post = $this->postRepository->getBySlug($slug);
            $postMeta = $this->postMetaRepository->getByPostId($post->id);
            $postMetaMap = [];
            foreach ($postMeta as $value) {
                $postMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
            }
            $termRelation = $this->termRelationRepository->getInstantModel()->where('object_id',$post->id)->first();
            $termMeta = $this->termMetaRepository->getInstantModel()->where('term_id',$termRelation->term_taxonomy_id)->get();
            $termMetaMap = [];
            if ($termMeta) {
                foreach ($termMeta->toArray() as $value){
                    $termMetaMap[MetaKey::display($value['meta_key'])] = json_decode($value['meta_value']);
                }
            }

            $relatePost = $this->termRelationRepository->getInstantModel()->where('term_taxonomy_id',$termRelation->term_taxonomy_id)->get();
            $ids = [];
            if ($relatePost) {
                $relatePost = $relatePost->toArray();
                foreach ($relatePost as $value) {
                    if ($value['object_id'] != $post->id){
                        $ids[] = $value['object_id'];
                    }
                }
            }
            $relatePostMap = $this->postRepository->findByIds($ids);
            $relatePostMeta = $this->postMetaRepository->findByPostIds($ids);
            $relatePostMetaMap = [];
            if ($relatePostMeta) {
                $relatePostMeta = $relatePostMeta->toArray();
                foreach ($relatePostMeta as $value) {
                    $relatePostMetaMap[] = [ MetaKey::display($value['meta_key']) => json_decode($value['meta_value']) ];
                }
            }
            return view('Client::hotel-detail',compact('post','postMetaMap','termMetaMap','relatePostMetaMap','relatePostMap'));
        }else{
            return view('Client::pages.404');
        }
    }
}
