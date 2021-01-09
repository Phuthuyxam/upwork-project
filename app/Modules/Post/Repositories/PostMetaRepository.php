<?php
namespace App\Modules\Post\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Post\Model\PostMeta;

class PostMetaRepository extends EloquentRepository {

    public function getModel() {
        return PostMeta::class;
    }

    public function getByPostId($postId){
        return $this->_model->where('post_id',$postId)->get()->toArray();
    }

    public function updateMeta($metaKey,$data){
        return $this->_model->where('meta_key',$metaKey)->update($data);
    }

    public function getMetaValueByCondition($condition){
        return $this->_model->where($condition)->first()->toArray();
    }

    public function updateByCondition($condition,$data) {
        return $this->_model->where($condition)->update($data);
    }
}
