<?php
namespace App\Modules\Taxonomy\Repositories;

use App\Core\Glosary\LocationConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Taxonomy\Model\Term;
use App\Modules\Taxonomy\Model\Translations\Ar\TermAr;

class TermRepository extends EloquentRepository {

    public function getModel() {
        $lang = app()->getLocale();
        if($lang == LocationConfigs::ARABIC['VALUE'])
            return TermAr::class;
        return Term::class;
    }

    public function getCategories() {
        return $this->_model->join('term_taxonomy'.$this->_suffixes,'terms'. $this->_suffixes .'.id','=','term_taxonomy'.$this->_suffixes .'.term_id')->orderBy('terms'.$this->_suffixes.'.id','DESC')->paginate(9);
    }

    public function getAllSlug() {
        $slugs = $this->_model->select('slug')->get();
        $slugMap = [];
        foreach ($slugs as $value) {
            $slugMap[] = $value->slug;
        }
        return $slugMap;
    }

}
