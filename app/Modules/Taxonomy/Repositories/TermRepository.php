<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\Term;

class TermRepository extends EloquentRepository {

    public function getModel() {
        return Term::class;
    }

    public function getCategories() {
        return $this->_model->join('term_taxonomy','terms.id','=','term_taxonomy.id')->get();
    }
}
