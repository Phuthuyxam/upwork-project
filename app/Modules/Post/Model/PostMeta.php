<?php


namespace App\Modules\Post\Model;


use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $table = 'post_meta';
    protected $fillable = ['post_id','meta_key','meta_value','created_at','updated_at'];
}
