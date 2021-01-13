<?php


namespace App\Modules\SystemConfig\Repositories;


use App\Core\Repositories\EloquentRepository;
use App\Modules\SystemConfig\Models\SystemConfig;

class SystemConfigRepository extends EloquentRepository
{

    public function getModel()
    {
        return SystemConfig::class;
    }

    public function findByCondition($condition) {
        return $this->_model->where($condition)->first();
    }
}
