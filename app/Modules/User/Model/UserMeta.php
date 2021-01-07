<?php


namespace App\Modules\User\Model;


use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_meta';
    protected $fillable = ['user_id', 'meta_key', 'meta_value'];
}
