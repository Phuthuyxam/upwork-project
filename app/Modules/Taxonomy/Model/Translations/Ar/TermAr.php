<?php


namespace App\Modules\Taxonomy\Model\Translations\Ar;


use Illuminate\Database\Eloquent\Model;

class TermAr extends Model
{
    protected $table = 'terms_ar';
    protected $fillable = ['name','slug'];

    public function termMeta() {
        return $this->hasMany(TermMetaAr::class, 'term_id');
    }
}
