<?php


namespace App\Modules\Post\Model\Translations\Ar;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Audit;
use OwenIt\Auditing\Contracts\Auditable;

class PostMetaAr extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'post_meta_ar';
    protected $fillable = ['post_id','meta_key','meta_value','created_at','updated_at'];
}
