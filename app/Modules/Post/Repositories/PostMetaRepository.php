<?php
namespace App\Modules\Post\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Post\Model\PostMeta;
use App\Modules\Post\Model\Translations\Ar\PostMetaAr;


class PostMetaRepository extends EloquentRepository {

    public function getModel() {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return PostMetaAr::class;
        return PostMeta::class;
    }

    public function getByPostId($postId){
        return $this->_model->where('post_id',$postId)->get();
    }

    public function updateMeta($metaKey,$data){
        return $this->_model->where('meta_key',$metaKey)->update($data);
    }

    public function getMetaValueByCondition($condition){
        return $this->_model->where($condition)->first();
    }

    public function updateByCondition($condition,$data) {
        return $this->_model->where($condition)->update($data);
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

    public function deleteByPostId($postId) {
        return $this->_model->where('post_id',$postId)->delete();
    }

    public function deleteFields($post_id,$fields) {
        return $this->_model->where('post_id', $post_id)->whereIn('meta_key',$fields)->delete();
    }

    public function findByPostIds($ids){
        return $this->_model->whereIn('post_id', $ids)->get();
    }
}
