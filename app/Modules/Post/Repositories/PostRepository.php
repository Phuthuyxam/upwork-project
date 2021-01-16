<?php

namespace App\Modules\Post\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Glosary\PaginationConfigs;
use App\Core\Glosary\PostType;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Post\Model\post;
use App\Modules\Post\Model\Translations\Ar\PostAr;


class PostRepository extends EloquentRepository
{

    public function getModel()
    {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return PostAr::class;
        return Post::class;
    }

    public function getAllSlugs()
    {
        return $this->_model->select('post_name')->get()->toArray();
    }

    public function getPosts()
    {
//        return $this->_model->join('users', 'users.id', '=', 'posts'. $this->_suffixes .'.post_author')
//            ->join('term_relationships'. $this->_suffixes, 'posts'. $this->_suffixes .'.id', '=', 'term_relationships'. $this->_suffixes .'.object_id')
//            ->join('terms'. $this->_suffixes, 'terms'. $this->_suffixes .'.id', '=', 'term_relationships'. $this->_suffixes .'.term_taxonomy_id')
//            ->where('posts'. $this->_suffixes .'.post_type',PostType::POST['VALUE'])
//            ->select('posts'. $this->_suffixes .'.id as postId', 'posts'. $this->_suffixes .'.post_title as postTitle', 'users.name as userName',
//                'users.id as userId', 'terms'. $this->_suffixes .'.name as termName', 'terms'. $this->_suffixes .'.id as termId', 'posts'. $this->_suffixes .'.post_status as postStatus',
//                'posts'. $this->_suffixes .'.created_at as createdAt', 'posts'. $this->_suffixes .'.updated_at as updatedAt')
//            ->orderBy('posts'. $this->_suffixes .'.id', 'DESC')->paginate(PaginationConfigs::DEFAULT['VALUE']);


        return $this->_model->join('users', 'users.id', '=', 'posts'. $this->_suffixes .'.post_author')
//            ->join('term_relationships'. $this->_suffixes, 'posts'. $this->_suffixes .'.id', '=', 'term_relationships'. $this->_suffixes .'.object_id')
//            ->join('terms'. $this->_suffixes, 'terms'. $this->_suffixes .'.id', '=', 'term_relationships'. $this->_suffixes .'.term_taxonomy_id')
            ->where('posts'. $this->_suffixes .'.post_type',PostType::POST['VALUE'])
            ->select('posts'. $this->_suffixes .'.id as postId', 'posts'. $this->_suffixes .'.post_title as postTitle', 'users.name as userName',
                'users.id as userId', 'posts'. $this->_suffixes .'.post_status as postStatus',
                'posts'. $this->_suffixes .'.created_at as createdAt', 'posts'. $this->_suffixes .'.updated_at as updatedAt')
            ->orderBy('posts'. $this->_suffixes .'.id', 'DESC')->paginate(PaginationConfigs::DEFAULT['VALUE']);

    }

    public function deleteMany($field,$conditions) {
        try {
            $query = $this->_model;
            return $query->whereIn($field,$conditions)->delete();
        }catch ( \Exception $e ){
            Log::error("Delete error in " . $this->_model);
            return false;
        }
    }

    public function getPages(){
        return $this->_model->leftJoin('users','users.id','=','posts'. $this->_suffixes .'.post_author')
            ->where('post_type',PostType::PAGE['VALUE'])
            ->select('posts'. $this->_suffixes .'.id as postId', 'posts'. $this->_suffixes .'.post_title as postTitle', 'users.name as postAuthor',
                'posts'. $this->_suffixes .'.post_name as slug', 'users.id as userId', 'posts'. $this->_suffixes .'.post_status as postStatus',
                'posts'. $this->_suffixes .'.created_at as createdAt', 'posts'. $this->_suffixes .'.updated_at as updatedAt')
            ->get();
    }

    public function getBySlug($slug) {
        return $this->_model->where('post_name',$slug)->first();
    }

    public function findByIds($ids) {
        return $this->_model->whereIn('id',$ids)->get();
    }
}
