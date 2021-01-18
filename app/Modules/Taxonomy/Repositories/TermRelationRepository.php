<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\TermRelationship;
use App\Modules\Taxonomy\Model\Translations\Ar\TermRelationshipAr;

class TermRelationRepository extends EloquentRepository {

    public function getModel() {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return TermRelationshipAr::class;
        return TermRelationship::class;
    }

    public function getByObjectId($objecId){
        if($this->_model->where('object_id',$objecId)->select('term_taxonomy_id')->first() == null)
            return [];
        return $this->_model->where('object_id',$objecId)->select('term_taxonomy_id')->first()->toArray();
    }

    public function updateByCondition($condition,$data){
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
        return $this->_model->where('object_id',$postId)->delete();
    }

    public function getByTermId($termId) {
        return $this->_model->where('term_taxonomy_id',$termId)->get();
    }
}
