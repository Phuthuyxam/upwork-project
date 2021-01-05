<?php
namespace App\Modules\Permission\Model;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {

    protected $table = "roles";

    protected $fillable = ['name' , 'desc'];

    public function getAllPermission() {
        return $this->hasMany(RolePermission::class, 'role');
    }

}
