<?php

namespace App\Modules\Permission\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PermissionGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "permission_group";
    protected $fillable = ['name', 'desc'];

    public function permission() {
        return $this->hasMany(Permissions::class, 'permission_group');
    }

}
