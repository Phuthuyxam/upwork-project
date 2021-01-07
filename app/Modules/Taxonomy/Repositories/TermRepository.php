<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\Term;

class TermRepository extends EloquentRepository {

    public function getModel() {
        return Term::class;
    }

    public function getCategories() {
        return $this->_model->join('term_taxonomy','terms.id','=','term_taxonomy.term_id')->orderBy('terms.id','DESC')->paginate(9);
    }

    public function getAllSlug() {
        $slugs = $this->_model->select('slug')->get();
        $slugMap = [];
        foreach ($slugs as $value) {
            $slugMap[] = $value->slug;
        }
        return $slugMap;
    }

}
