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
        return $this->_model->where('object_id',$objecId)->select('term_taxonomy_id')->first()->toArray();
    }

    public function updateByCondition($condition,$data){
        return $this->_model->where($condition)->update($data);
    }
}
