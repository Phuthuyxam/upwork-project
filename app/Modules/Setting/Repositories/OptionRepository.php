<?php
namespace App\Modules\Setting\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Setting\Model\Option;
use App\Modules\Setting\Model\Translations\Ar\OptionAr;

class OptionRepository extends EloquentRepository {

    public function getModel() {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return OptionAr::class;
        return Option::class;
    }

    public function getDefaultCategory(){
        return $this->_model->where('option_key','default_category')->first();
    }

    public function getByKey($key){
        return $this->_model->where('option_key',$key)->first();
    }
}
