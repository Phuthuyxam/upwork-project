<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\TermTaxonomy;

class TermTaxonomyRepository extends EloquentRepository {

    public function getModel() {
        return TermTaxonomy::class;
    }

}
