<?php
namespace App\Modules\Permission\Controllers;

use App\Core\Glosary\RoleConfig;
use App\Http\Controllers\Controller;
use App\Modules\Permission\Repositories\PermissionGroupRepository;
use App\Modules\Permission\Repositories\RoleRepository;
use Illuminate\Http\Request;


class PermissionManagerController extends Controller{

    protected $roleRepository;
    protected $permissionGroupRepository;

    public function __construct(RoleRepository $roleRepository, PermissionGroupRepository $permissionGroupRepository){
        $this->roleRepository = $roleRepository;
        $this->permissionGroupRepository = $permissionGroupRepository;
    }

    public function index() {
        $roles = $this->roleRepository->filter([['id' , '<>',  RoleConfig::SUPPERADMIN['VALUE']]], [ 'id' , 'desc' ]);
        return view('Permission::index' , compact('roles') );
    }

    public function add(Request $request) {
        $request->validate(['role_name' => 'required|unique:roles,name']);
        $dataSave = [
            'name' => $request->role_name,
            'desc' => $request->role_desc
        ];
        try {
            $this->roleRepository->create($dataSave);
            return redirect()->back()->with('message', 'success|Successfully added the role');
        }catch (\Throwable $th) {
            return redirect()->back()->with('message','danger|Something wrong try again!');
        }

    }

    public function edit($id) {
        $role = $this->roleRepository->find($id);
        $permissionGroup = $this->permissionGroupRepository->getAll();
        $rolePermission = $this->roleRepository->getPermission($id);
        return view('Permission::edit',compact('role', 'permissionGroup', 'rolePermission'));
    }
    public function save($id, Request $request) {
        $request->validate(
            ['role_name' => 'required|unique:roles,name,'.$id]
        );
        $permission = [];
        $permission_group = [];
        if(!is_null($request->permission_group)) $permission_group = explode(',' , $request->permission_group);
        if(!is_null($request->permission)) $permission = explode(',' , $request->permission);

        $saveRole = $this->roleRepository->update($id, ['name' => $request->role_name , 'desc' => $request->role_desc ]);
        $savePermission = $this->roleRepository->savePermission($id, $permission_group  , $permission);
        if( $saveRole && $savePermission ) return redirect()->back()->with('message', 'success|Successfully edit the role');
        return redirect()->back()->with('message','danger|Something wrong try again!');
    }


    public function delete($id) {
        $del = $this->roleRepository->delete($id);
        if( $del) return redirect()->back()->with('message', 'success|Successfully delete the role');
        return redirect()->back()->with('message','danger|Something wrong try again!');
    }

}
