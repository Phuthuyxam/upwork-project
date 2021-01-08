<?php
namespace App\Modules\Post\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Post\Model\post;

class PostRepository extends EloquentRepository {

    public function getModel() {
        return Post::class;
    }

    public function getAllSlugs() {
        return $this->_model->select('post_name')->get()->toArray();
    }
}
