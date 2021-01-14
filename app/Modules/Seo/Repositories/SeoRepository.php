<?php
namespace App\Modules\Seo\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Seo\Model\Seo;
use App\Modules\Seo\Model\Translations\Ar\SeoAr;

class SeoRepository extends EloquentRepository {

    public function getModel() {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return SeoAr::class;
        return Seo::class;
    }

}
