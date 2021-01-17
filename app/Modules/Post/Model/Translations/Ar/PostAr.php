<?php

namespace App\Modules\Post\Model\Translations\Ar;

use App\Modules\Taxonomy\Model\TermRelationship;
use App\Modules\Translations\Model\TranslationRelationship;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PostAr extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "posts_ar";

    protected $fillable = ['id','name','desc','post_author','post_excerpt','post_content','post_title','post_type','post_name','post_status'];

    public function postMeta() {
        return $this->hasMany(PostMetaAr::class,'post_id');
    }

    public function postToTranslation() {
        return $this->hasMany(TranslationRelationship::class, 'to_object_id');
    }

    public function postFromTranslation() {
        return $this->hasMany(TranslationRelationship::class, 'from_object_id');
    }
}
