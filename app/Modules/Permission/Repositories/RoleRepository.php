<?php
namespace App\Modules\Permission\Repositories;

use App\Core\Repositories\EloquentRespository;
use App\Modules\Permission\Model\Roles;

class RoleRepository extends EloquentRespository {

    public function getModel() {
        return Roles::class;
    }
}
