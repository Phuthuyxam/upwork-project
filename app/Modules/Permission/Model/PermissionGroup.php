<?php

namespace App\Modules\Permission\Model;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $table = "permission_group";
    protected $fillable = ['name', 'desc'];

    public function permission() {
        return $this->hasMany(Permissions::class, 'permission_group');
    }

}
