<?php

namespace App\Modules\Post\Model;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $table = "post";

    protected $fillable = ['id','name','desc'];

}
