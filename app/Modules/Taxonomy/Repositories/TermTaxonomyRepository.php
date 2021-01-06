<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Repositories\EloquentRespository;
use App\Modules\Taxonomy\Model\TermTaxonomy;

class TermTaxonomyRepository extends EloquentRespository {

    public function getModel() {
        return TermTaxonomy::class;
    }

}
