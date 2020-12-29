<?php
namespace App\Modules\Post\Repositories;

use App\Core\Repositories\EloquentRespository;
use App\Modules\Post\Model\post;

class PostRepository extends EloquentRespository {

    public function getModel() {
        return Post::class;
    }

}
