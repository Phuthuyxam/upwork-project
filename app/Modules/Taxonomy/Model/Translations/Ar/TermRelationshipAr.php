<?php


namespace App\Modules\Taxonomy\Model\Translations\Ar;


use App\Modules\Post\Model\Post;
use Illuminate\Database\Eloquent\Model;

class TermRelationshipAr extends Model
{
    protected $table = 'term_relationships_ar';
    protected $fillable = ['object_id','term_taxonomy_id','term_order'];

    public function permission() {
        return $this->hasMany(Post::class);
    }
}
