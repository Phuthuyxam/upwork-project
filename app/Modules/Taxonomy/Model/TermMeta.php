<?php


namespace App\Modules\Taxonomy\Model;


use Illuminate\Database\Eloquent\Model;

class TermMeta extends Model
{
    protected $table = 'term_meta';
    protected $fillable = ['term_id','meta_key','meta_value','created_at','updated_at'];


}
