<?php


namespace App\Modules\Post\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OwenIt\Auditing\Contracts\Auditable;

class PostMeta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'post_meta';
    protected $fillable = ['post_id','meta_key','meta_value','created_at','updated_at'];

}
