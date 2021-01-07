<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\TermMeta;

class TermMetaRepository extends EloquentRepository {

    public function getModel() {
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

