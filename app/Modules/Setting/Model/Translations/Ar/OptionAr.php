<?php


namespace App\Modules\Setting\Model\Translations\Ar;


use Illuminate\Database\Eloquent\Model;

class OptionAr extends Model
{
    protected $table = 'options_ar';
    protected $fillable = ['option_key','option_value'];
}
