<?php
namespace App\Modules\Permission\Model;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {

    protected $table = "roles";

    protected $fillable = ['name' , 'desc'];

    public function getAllPermission() {
        return $this->hasMany(RolePermission::class, 'role');
    }

    public function permission() {
        return $this->belongsToMany(Permissions::class, 'role_permission','role', 'permission');
    }

    public function permissionGroup() {
        return $this->belongsToMany(Permissions::class, 'role_permission','role', 'permission_group');
    }

}
