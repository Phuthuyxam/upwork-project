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
                'phone' => ['required', 'regex:/(0)[0-9]/', 'not_regex:/[a-z]/', 'min:9'],
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
        $phone = $user->userMeta()->where('meta_key', UserMetaKey::PHONE['VALUE'])->first();
        return view('User::edit',compact('roles', 'user', 'phone'));
    }
    public function save($id, Request $request) {

        $validateArray = [
            'name' => ['required', 'string', 'max:255' , 'unique:users,name,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'phone' => ['required', 'regex:/(0)[0-9]/', 'not_regex:/[a-z]/', 'min:9'],
        ];

        if(!empty($request->password)) $validateArray['password'] = ['string', 'min:8', 'confirmed'];

        $request->validate( $validateArray );
        try {
            $dataSave = [
                            'name' => $request->name,
                            'email' => $request->email,
                            'role' => $request->role
                        ];
            if($request->password) $dataSave[] = Hash::make($request->password);

            $metaSave = [
                'meta_value' => $request->phone
            ];

            $this->userRepository->update($id, $dataSave);
            $this->userRepository->find($id)->userMeta()->where('meta_key','user_phone')->first()->update($metaSave);
            return redirect()->back()->with('message', 'success|Successfully edit the user');

        } catch (\Throwable $th) {
            return redirect()->back()->with('message','danger|Something wrong try again!');
        }
    }


    public function delete($id) {
        $del = $this->userRepository->delete($id);
        if( $del) return redirect()->back()->with('message', 'success|Successfully delete the user');
        return redirect()->back()->with('message','danger|Something wrong try again!');
    }
}
