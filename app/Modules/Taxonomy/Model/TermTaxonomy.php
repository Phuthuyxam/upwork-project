<?php


namespace App\Modules\Taxonomy\Model;


use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    protected $table = 'term_taxonomy';
    protected $fillable = ['term_id','taxonomy','description','parent'];
}
