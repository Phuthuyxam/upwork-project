<?php


namespace App\Modules\Post\Model\Translations\Ar;


use Illuminate\Database\Eloquent\Model;

class PostMetaAr extends Model
{
    protected $table = 'post_meta_ar';
    protected $fillable = ['post_id','meta_key','meta_value','created_at','updated_at'];
}
