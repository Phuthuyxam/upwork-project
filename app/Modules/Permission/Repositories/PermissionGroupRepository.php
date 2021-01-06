<?php
namespace App\Modules\Permission\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Permission\Model\PermissionGroup;

class PermissionGroupRepository extends EloquentRepository {

    public function getModel() {
        return PermissionGroup::class;
    }
}
