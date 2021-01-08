<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\TermMeta;
use App\Modules\Taxonomy\Model\Translations\Ar\TermMetaAr;

class TermMetaRepository extends EloquentRepository {

    public function getModel() {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return TermMetaAr::class;
        return TermMeta::class;
    }

    public function deleteByTermId($termId) {
        return $this->_model->where('term_id','=',$termId)->delete();
    }

    public function updateByTermId($termId,$data) {
        return $this->_model->where([['term_id','=',$termId],['meta_key', '=', $data['meta_key']]])->update(['meta_value' => $data['meta_value']]);
    }

    public function removeTermByCondition($condition) {
        return $this->_model->where($condition)->insert(['meta_value' => '']);
    }
}

