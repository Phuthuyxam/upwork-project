<?php


namespace App\Modules\User\Model;


use Illuminate\Database\Eloquent\Model;
use App\Modules\Permission\Model\RolePermission;

class User extends Model
{
    protected $table = 'users';

    public function getPermission() {
        $this->belongsTo(RolePermission::class);
    }
}
