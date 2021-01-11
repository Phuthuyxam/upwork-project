<?php


namespace App\Modules\Seo\Model\Translations\Ar;


use Illuminate\Database\Eloquent\Model;

class SeoAr extends Model
{
    protected $table = 'seo_ar';
    protected $fillable = ['object_id','seo_key','seo_value','seo_type'];
}
