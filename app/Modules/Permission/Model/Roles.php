<?php
namespace App\Modules\Permission\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Roles extends Model implements Auditable {

    use \OwenIt\Auditing\Auditable;
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

    public function users() {
        return $this->hasMany(User::class, 'role');
    }

}
