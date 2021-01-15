<?php


namespace App\Modules\Client\Controllers;


use App\Core\Helper\OptionHelpers;
use App\Http\Controllers\Controller;
use App\Modules\Setting\Repositories\OptionRepository;

class ClientHomeController extends Controller
{

    protected $optionRepository;
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }
    public function index() {
        $systemConfig = OptionHelpers::getSystemConfigByKey('general');
        if($systemConfig && json_decode($systemConfig, true)){
            $systemConfig = json_decode($systemConfig, true);
        }

//        dd($systemConfig);
//        $seoDefault = [
//            'SEO' => [
//                'TITLE' => $systemConfig['site_title'],
//                'DESC' => $systemConfig['']
//
//            ]
//        ];

        $page = json_decode($this->optionRepository->getByKey('home')->option_value);
//        return view('Client::homepage',compact('seoDefault'));
        return view('Client::homepage',compact('page'));
    }

}
