<?php


namespace App\Modules\SystemConfig\Models;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SystemConfig extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "system_configs";

    protected $fillable = ['option_key','option_value','created_at'];
}
