<?php


namespace App\Modules\User\Controllers;


use App\Core\Glosary\PaginationConfigs;
use App\Core\Glosary\RoleConfigs;
use App\Core\Glosary\UserMetaKey;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Permission\Repositories\RoleRepository;
use App\Modules\User\Model\UserMeta;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManageController extends Controller
{
    protected $roleRepository;
    protected $userRepository;
    protected $userMetaRepository;

    public function __construct(UserRepository $userRepository , RoleRepository $roleRepository, UserRepository $userMetaRepository){
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userMetaRepository = $userMetaRepository;
    }

    public function index() {
        $roles = $this->roleRepository->filter([['id' , '<>',  RoleConfigs::SUPPERADMIN['VALUE']]], [ 'id' , 'desc' ]);
        $users = $this->userRepository->getAll();
        return view('User::index', compact('roles', 'users'));
    }

    public function add(Request $request) {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255' , 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
        try {
            $saveUser = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);
            $userNewId = $saveUser->id;
            $saveMeta = UserMeta::create([
                'user_id' => $userNewId,
                'meta_key' => UserMetaKey::PHONE['VALUE'],
                'meta_value' => $request->phone
            ]);
            return redirect()->back()->with('message', 'success|Successfully added the user');
        }catch (\Throwable $th) {
            return redirect()->back()->with('message','danger|Something wrong try again!');
        }

    }

    public function edit($id) {
        $user = $this->userRepository->find($id);
        $roles = $this->roleRepository->filter([['id' , '<>',  RoleConfigs::SUPPERADMIN['VALUE']]], [ 'id' , 'desc' ]);
//        $permissionGroup = $this->permissionGroupRepository->getAll();
//        $rolePermission = $this->roleRepository->getPermission($id);
        return view('User::edit',compact('role', 'user'));
    }
    public function save($id, Request $request) {
//        $request->validate(
//            ['role_name' => 'required|unique:roles,name,'.$id]
//        );
//        $permission = [];
//        $permission_group = [];
//        if(!is_null($request->permission_group)) $permission_group = explode(',' , $request->permission_group);
//        if(!is_null($request->permission)) $permission = explode(',' , $request->permission);
//
//        $saveRole = $this->roleRepository->update($id, ['name' => $request->role_name , 'desc' => $request->role_desc ]);
//        $savePermission = $this->roleRepository->savePermission($id, $permission_group  , $permission);
//        if( $saveRole && $savePermission ) return redirect()->back()->with('message', 'success|Successfully edit the role');
//        return redirect()->back()->with('message','danger|Something wrong try again!');
    }


    public function delete($id) {
//        $del = $this->roleRepository->delete($id);
//        if( $del) return redirect()->back()->with('message', 'success|Successfully delete the role');
//        return redirect()->back()->with('message','danger|Something wrong try again!');
    }
}
