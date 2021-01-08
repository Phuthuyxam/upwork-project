<?php


namespace App\Modules\Taxonomy\Model\Translations\Ar;


use Illuminate\Database\Eloquent\Model;

class TermTaxonomyAr extends Model
{
    protected $table = 'term_taxonomy_ar';
    protected $fillable = ['term_id','taxonomy','description','parent'];
}
