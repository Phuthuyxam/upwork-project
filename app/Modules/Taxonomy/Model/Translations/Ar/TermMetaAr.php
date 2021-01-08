<?php


namespace App\Modules\Taxonomy\Model\Translations\Ar;


use Illuminate\Database\Eloquent\Model;

class TermMetaAr extends Model
{
    protected $table = 'term_meta_ar';
    protected $fillable = ['term_id','meta_key','meta_value','created_at','updated_at'];


}
