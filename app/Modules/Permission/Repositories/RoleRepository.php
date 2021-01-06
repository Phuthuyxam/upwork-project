<?php
namespace App\Modules\Permission\Repositories;

use App\Core\Glosary\RoleConfigs;
use App\Core\Repositories\EloquentRepository;
use App\Modules\Permission\Model\Roles;
use Illuminate\Support\Facades\DB;

class RoleRepository extends EloquentRepository {

    public function getModel() {
        return Roles::class;
    }

    public function getPermission($role) {
        if( !$this->_model->find($role) ) return null ;
        $roleRelationship =  $this->_model->find($role)->getAllPermission;
        $result['group'] = [];
        $result['permission'] = [];
        foreach ($roleRelationship as $roleRela) {
            if($roleRela->permission_group != 0) {
                $result['group'][] = $roleRela->permission_group;
            }
            if($roleRela->permission != 0) {
                $result['permission'][] = $roleRela->permission;
            }
        }
        return $result;
    }

    public function savePermission($roleId, $groupId, $permissionId) {
        $syncGroup = [];
        $syncPermission = [];
        if(!empty($groupId))
            foreach ($groupId as $group) {
                $syncGroup[$group] = ['role' => $roleId];
            }
        if(!empty($permissionId))
            foreach ($permissionId as $per) {
                $syncPermission[$per] = ['role' => $roleId];
            }
        DB::beginTransaction();
        try {
            $this->_model->find($roleId)->getAllPermission()->delete();
            $this->_model->find($roleId)->permission()->syncWithoutDetaching($syncPermission);
            $this->_model->find($roleId)->permissionGroup()->syncWithoutDetaching($syncGroup);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }

    }

    public function delete($id, $trash = false)
    {
        DB::beginTransaction();
        try {
            // update user
            $this->_model->find($id)->users()->update(['role' => RoleConfigs::GUEST['VALUE']]);
            // delete role - permission
            $deleteRelationship = $this->_model->find($id)->getAllPermission()->delete();
            $deleteRole = parent::delete($id, $trash);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
}
