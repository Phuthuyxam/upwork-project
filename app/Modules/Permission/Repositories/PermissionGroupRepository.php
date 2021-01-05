<?php
namespace App\Modules\Permission\Repositories;

use App\Core\Repositories\EloquentRespository;
use App\Modules\Permission\Model\PermissionGroup;

class PermissionGroupRepository extends EloquentRespository {

    public function getModel() {
        return PermissionGroup::class;
    }
}
