<?php


namespace App\Modules\User\Model;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserMeta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'user_meta';
    protected $fillable = ['user_id', 'meta_key', 'meta_value'];
}
