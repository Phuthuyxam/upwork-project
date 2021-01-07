<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\TermTaxonomy;

class TermTaxonomyRepository extends EloquentRepository {

    public function getModel() {
        return TermTaxonomy::class;
    }

    public function deleteByTermId($termId){
        return $this->_model->where('term_id',$termId)->delete();
    }

    public function updateByTermId($termId,$data) {
        return $this->_model->where('term_id','=',$termId)->update($data);
    }
}
