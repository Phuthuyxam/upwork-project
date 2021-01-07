<?php


namespace App\Modules\Taxonomy\Model;


use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'terms';
    protected $fillable = ['name','slug'];

    public function termMeta() {
        return $this->hasMany(TermMeta::class, 'term_id');
    }
}
