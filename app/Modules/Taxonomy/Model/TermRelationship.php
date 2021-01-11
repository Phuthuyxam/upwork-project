<?php


namespace App\Modules\Taxonomy\Model;


use App\Modules\Post\Model\Post;
use Illuminate\Database\Eloquent\Model;

class TermRelationship extends Model
{
    protected $table = 'term_relationships';
    protected $fillable = ['object_id','term_taxonomy_id','term_order'];

    public function termRelation() {
        return $this->hasMany(Post::class);
    }
}
