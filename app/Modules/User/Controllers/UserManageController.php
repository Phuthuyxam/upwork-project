<?php


namespace App\Modules\User\Controllers;


use App\Core\Glosary\RoleConfigs;
use App\Core\Glosary\UserMetaKey;
use App\Core\Helper\OptionHelpers;
use App\Http\Controllers\Controller;
use App\Modules\Permission\Repositories\RoleRepository;
use App\Modules\User\Model\UserMeta;
use App\Modules\User\Repositories\UserMetaRepository;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserManageController extends Controller
{
    protected $roleRepository;
    protected $userRepository;
    protected $userMetaRepository;

    public function __construct(UserRepository $userRepository , RoleRepository $roleRepository, UserMetaRepository $userMetaRepository){
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
//                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone' => ['required', 'regex:/(0)[0-9]/', 'not_regex:/[a-z]/', 'min:9'],
            ]
        );
        try {
            $randomPass = $this->generatePassword();
            $saveUser = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($randomPass),
                'role' => $request->role
            ]);
            $userNewId = $saveUser->id;
            $saveMeta = UserMeta::create([
                'user_id' => $userNewId,
                'meta_key' => UserMetaKey::PHONE['VALUE'],
                'meta_value' => $request->phone
            ]);
            // send mail
            $systemConfig = OptionHelpers::getSystemConfigByKey('general');
            if($systemConfig && json_decode($systemConfig,true))
                $systemConfig = json_decode($systemConfig, true);
            Mail::send('mail_template.register_user', ['new_password' => $randomPass, 'login_url' => url()->to('/login') ], function ($message) use ($systemConfig, $request) {
                $message->from($systemConfig['site_admin_mail']);
                $message->to($request->email, 'Employee')
                    ->subject('Successfully activated the account on the system' . url()->to('/'));
            });
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
            if($request->password) $dataSave['password'] = Hash::make($request->password);

            $metaSave = [
                'meta_value' => $request->phone
            ];

            $this->userRepository->update($id, $dataSave);
            $userMeta = $this->userRepository->find($id)->userMeta()->where('meta_key','user_phone')->first();
            if(is_null($userMeta)){
                $this->userMetaRepository->create(['user_id' => $id, 'meta_key' => 'user_phone','meta_value' => $request->phone ]);
            } else{
                $userMeta->update($metaSave);
            }

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

    public function generatePassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function verifyPassWord(Request $request) {
        if($request->isMethod('post')){
            $request->validate(['password' => 'required|string|min:8|confirmed']);
            $this->userRepository->update(Auth::id(), ['password' => Hash::make($request->password), 'first_login' => 0]);
            Auth::logout();
            return redirect('/login');
        }
        if(Auth::user()->first_login != 1) return view('Client::pages.404');
        return view('User::firstlogin');
    }
}
