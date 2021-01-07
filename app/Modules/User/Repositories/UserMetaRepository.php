<?php


namespace App\Modules\User\Repositories;


use App\Core\Repositories\EloquentRepository;
use App\Modules\User\Model\UserMeta;

class UserMetaRepository extends EloquentRepository
{

    public function getModel()
    {
        return UserMeta::class;
    }
}
