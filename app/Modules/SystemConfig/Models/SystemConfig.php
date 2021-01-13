<?php


namespace App\Modules\SystemConfig\Models;


use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    protected $table = "system_configs";

    protected $fillable = ['option_key','option_value','created_at'];
}
