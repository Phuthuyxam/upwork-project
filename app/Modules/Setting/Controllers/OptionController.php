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
        $dataMenu = $this->optionRepository->filter([['option_key', OptionMetaKey::MENU['VALUE']]]);
        $dataFooter = $this->optionRepository->filter([['option_key', OptionMetaKey::FOOTER['VALUE']]]);
        return view('Setting::index', compact('allOption', 'key', 'dataMenu', 'dataFooter'));
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
            try {
                $findData = $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::MENU['VALUE'])->get();
                if($findData->isNotEmpty()) {
                    $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::MENU['VALUE'])->update(['option_value' => json_encode($menuData)]);
                }else {
                    $this->optionRepository->create(['option_key' => OptionMetaKey::MENU['VALUE'], 'option_value' => json_encode($menuData) ]);
                }
                return redirect()->back()->with('message', 'success|Menu save success.');
            } catch (\Throwable $th) {
                return redirect()->back()->with('message', 'danger|Menu save something wrong try again!');
            }

        }

        // save footer

        $footerData = [];
        if(isset($request->copyright_text) && !empty($request->copyright_text)){
            $footerData['copyright_text'] = $request->copyright_text;
        }
        if(isset($request->develop_text) && !empty($request->develop_text)){
            $footerData['develop_text'] = $request->develop_text;
        }

        if(!empty($footerData)){
            try {
                $findData = $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::FOOTER['VALUE'])->get();
                if($findData->isNotEmpty()) {
                    $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::FOOTER['VALUE'])->update(['option_value' => json_encode($footerData)]);
                }else {
                    $this->optionRepository->create(['option_key' => OptionMetaKey::FOOTER['VALUE'], 'option_value' => json_encode($footerData) ]);
                }
                return redirect()->back()->with('message', 'success|Menu save success.');
            } catch (\Throwable $th) {
                return redirect()->back()->with('message', 'danger|Menu save something wrong try again!');
            }

        }

        return redirect()->back();
    }

}
