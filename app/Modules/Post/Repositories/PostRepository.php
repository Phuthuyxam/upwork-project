<?php

namespace App\Modules\Post\Repositories;

use App\Core\Glosary\PaginationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Post\Model\post;

class PostRepository extends EloquentRepository
{

    public function getModel()
    {
        return Post::class;
    }

    public function getAllSlugs()
    {
        return $this->_model->select('post_name')->get()->toArray();
    }

    public function getPosts()
    {
        return $this->_model->join('users', 'users.id', '=', 'posts.post_author')
            ->join('term_relationships', 'posts.id', '=', 'term_relationships.object_id')
            ->join('terms', 'terms.id', '=', 'term_relationships.term_taxonomy_id')
            ->select('posts.id as postId', 'posts.post_title as postTitle', 'users.name as userName',
                'users.id as userId', 'terms.name as termName', 'terms.id as termId', 'posts.post_status as postStatus',
                'posts.created_at as createdAt', 'posts.updated_at as updatedAt')
            ->orderBy('posts.id', 'DESC')->paginate(PaginationConfigs::DEFAULT['VALUE']);
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
}
