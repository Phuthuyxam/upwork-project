<?php

namespace App\Models;

use App\Modules\Permission\Model\Permissions;
use App\Modules\Permission\Model\Roles;
use App\Modules\User\Model\UserMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPermission($role) {
        if( !Roles::find($role) ) return null ;
        $roleRelationship =  Roles::find($role)->getAllPermission;
        $result = [];
        foreach ($roleRelationship as $roleRela) {
            if($roleRela->permission_group != 0) {
                $permissions = Permissions::where('permission_group', $roleRela->permission_group)->get();
                if($permissions)
                    $result = array_merge($result, $permissions->toArray());
            }

            if($roleRela->permission != 0) {
                $permisson = Permissions::find($roleRela->permission);
                if($permisson) $result[] = $permisson->toArray();
            }

        }
        return $result;
    }

    public function userMeta() {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    public function roleInfo() {
        return $this->belongsTo(Roles::class, 'role', 'id');
    }
}
