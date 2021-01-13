<?php


namespace App\Modules\SystemConfig\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\SystemConfig\Repositories\SystemConfigRepository;
use Illuminate\Http\Request;


class SystemConfigController extends Controller
{
    public $systemRepository;
    public function __construct( SystemConfigRepository $systemRepository ) {
        $this->systemRepository = $systemRepository;
    }
    public function index(Request $request){
        if ($request->isMethod('get')) {
            $result = json_decode($this->systemRepository->findByCondition([['option_key' ,'=', 'general']])->toArray()['option_value']);
            return view('SystemConfig::index',compact('result'));
        }else {
            $data = [
                'logo' => $request->input('logo') ,
                'phone' => $request->input('phone'),
                'email' => $request->input('email_'),
                'address' => $request->input('address'),
                'social_link' => $request->input('social_links')
            ];

            $option = [
                'option_key' => 'general',
                'option_value' => json_encode($data)
            ];
            $condition = [['option_key' ,'=', 'general']];
            $record = $this->systemRepository->findByCondition($condition);
            if ($record == null) {
                if ($this->systemRepository->create($option)) {
                    return redirect()->back()->with('message', 'success|Save success.');
                }else{
                    return redirect()->back()->with('message', 'danger|Save fail.');
                }
            }else{
                $id = $this->systemRepository->findByCondition($condition)->id;
                if ($this->systemRepository->update($id,$option)) {
                    return redirect()->back()->with('message', 'success|Save success.');
                }else{
                    return redirect()->back()->with('message', 'danger|Save fail.');
                }

            }
        }


    }

}
