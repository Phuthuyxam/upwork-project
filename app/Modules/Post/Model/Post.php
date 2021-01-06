<?php

namespace App\Modules\Post\Model;

use App\Modules\Taxonomy\Model\TermRelationship;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = ['id','name','desc'];

    public function permission() {
        return $this->hasMany(TermRelationship::class,'object_id');
    }
}
