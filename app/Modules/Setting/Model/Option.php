<?php


namespace App\Modules\Setting\Model;


use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';
    protected $fillable = ['option_key','option_value'];


}
