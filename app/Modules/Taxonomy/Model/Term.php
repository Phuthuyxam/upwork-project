<?php


namespace App\Modules\Taxonomy\Model;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Term extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'terms';
    protected $fillable = ['name','slug'];

    public function termMeta() {
        return $this->hasMany(TermMeta::class, 'term_id');
    }
}
