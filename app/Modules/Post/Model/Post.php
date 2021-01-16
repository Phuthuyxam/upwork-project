<?php

namespace App\Modules\Post\Model;

use App\Modules\Taxonomy\Model\TermRelationship;
use App\Modules\Translations\Model\TranslationRelationship;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Post extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "posts";

    protected $fillable = ['id','name','desc','post_author','post_excerpt','post_content','post_title','post_type','post_name','post_status'];

    public function postMeta() {
        return $this->hasMany(PostMeta::class,'post_id');
    }

    public function postTranslation() {
        return $this->hasMany(TranslationRelationship::class, 'to_object_id');
    }
}
