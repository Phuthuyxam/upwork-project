<?php


namespace App\Modules\Client\Controllers;


use App\Core\Helper\OptionHelpers;
use App\Http\Controllers\Controller;

class ClientHomeController extends Controller
{

    public function index() {
        $systemConfig = OptionHelpers::getSystemConfigByKey('general');
        if($systemConfig && json_decode($systemConfig, true)){
            $systemConfig = json_decode($systemConfig, true);
        }

//        dd($systemConfig);
        $seoDefault = [
            'SEO' => [
                'TITLE' => $systemConfig['site_title'],
//                'DESC' => $systemConfig['']

            ]
        ];
        return view('Client::homepage',compact('seoDefault'));
    }

}
