<?php
namespace App\Modules\Translations\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Translations\Model\TranslationRelationship;

class TranslationRelationshipRepository extends EloquentRepository {

    public function getModel() {
        return TranslationRelationship::class;
    }

}
