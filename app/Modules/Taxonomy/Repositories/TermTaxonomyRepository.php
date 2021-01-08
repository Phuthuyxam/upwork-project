<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\TermTaxonomy;
use App\Modules\Taxonomy\Model\Translations\Ar\TermTaxonomyAr;

class TermTaxonomyRepository extends EloquentRepository {

    public function getModel() {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return TermTaxonomyAr::class;
        return TermTaxonomy::class;
    }

    public function deleteByTermId($termId){
        return $this->_model->where('term_id',$termId)->delete();
    }

    public function updateByTermId($termId,$data) {
        return $this->_model->where('term_id','=',$termId)->update($data);
    }
}
