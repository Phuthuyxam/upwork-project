<?php

namespace App\Modules\Post\Model;

use App\Modules\Taxonomy\Model\TermRelationship;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = ['id','name','desc','post_author','post_content','post_title','post_type','post_name','post_status'];

    public function permission() {
        return $this->hasMany(TermRelationship::class,'object_id');
    }
}
