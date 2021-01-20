<?php


namespace App\Modules\Setting\Model;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Option extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'options';
    protected $fillable = ['option_key','option_value'];

}
