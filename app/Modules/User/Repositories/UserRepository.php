<?php


namespace App\Modules\User\Repositories;


use App\Core\Glosary\PaginationConfigs;
use App\Core\Glosary\RoleConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Models\User;

class UserRepository extends EloquentRepository
{


    public function getModel()
    {
        return User::class;
    }

    public function getAll()
    {
        return $this->_model->where('role', '<>', RoleConfigs::SUPPERADMIN['VALUE'])->paginate(PaginationConfigs::DEFAULT['VALUE']);
    }
}
