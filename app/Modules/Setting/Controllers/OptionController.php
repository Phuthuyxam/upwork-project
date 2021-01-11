<?php


namespace App\Modules\Setting\Controllers;


use App\Core\Glosary\OptionMetaKey;
use App\Http\Controllers\Controller;
use App\Modules\Setting\Repositories\OptionRepository;
use Illuminate\Http\Request;


class OptionController extends Controller
{
    public $optionRepository;
    public function __construct( OptionRepository $optionRepository ) {
        $this->optionRepository = $optionRepository;
    }

    public function index($key = null) {
        $allOption = OptionMetaKey::getAll();
        if(is_null($key)) $key = OptionMetaKey::MENU['VALUE'];
        return view('Setting::index', compact('allOption', 'key'));
    }
    public function save($key = null, Request $request) {
        if(is_null($key)) $key = OptionMetaKey::MENU['VALUE'];
        $menuData = [];
        // menu
        if( isset($request->option_menu_title) && !empty($request->option_menu_title)) {
            $menuTitle = $request->option_menu_title;
            $menuUrl = $request->option_menu_url;
            foreach ($menuTitle as $key => $title) {
                $menuData[] = [
                    'title' => $title,
                    'url' => $menuUrl[$key]
                ];
            }
        }

        if(!empty($menuData)){
            $findData = $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::MENU['VALUE'])->get();
            if($findData->isNotEmpty()) {
                $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::MENU['VALUE'])->update(['option_value' => json_encode($menuData)]);
            }else {
                $this->optionRepository->create(['option_key' => OptionMetaKey::MENU['VALUE'], 'option_value' => json_encode($menuData) ]);
            }
        }

        // save footer





//        $allOption = OptionMetaKey::getAll();
//        if(is_null($key)) $key = OptionMetaKey::MENU['VALUE'];
//        return view('Setting::index', compact('allOption', 'key'));
    }

}
