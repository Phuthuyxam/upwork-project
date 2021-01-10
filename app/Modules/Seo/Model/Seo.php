<?php


namespace App\Modules\Seo\Model;


use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';
    protected $fillable = ['object_id','seo_key','seo_value','seo_type'];


}
