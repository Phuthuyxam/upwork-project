<?php


namespace App\Modules\Setting\Controllers;


use App\Core\Glosary\LocationConfigs;
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
        if(is_null($key)) $key = OptionMetaKey::MENU['VALUE'];
        $dataMenu = $this->optionRepository->filter([['option_key', OptionMetaKey::MENU['VALUE']]]);
        $dataFooter = $this->optionRepository->filter([['option_key', OptionMetaKey::FOOTER['VALUE']]]);
        $dataHome = $this->optionRepository->filter([['option_key', OptionMetaKey::HOME['VALUE']]]);
        return view('Setting::index', compact( 'key', 'dataMenu', 'dataFooter','dataHome'));
    }

    public function save($key = null, Request $request) {
        $translation = false;
        if(isset($request->translation) && !empty($request->translation) && LocationConfigs::checkLanguageCode($request->translation)){
            app()->setLocale($request->translation);
            $this->optionRepository->setModel();
            $transUrl = renderTranslationUrl(url()->current(), $request->translation);
            $translation = true;
        }

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
                if($translation)
                    return redirect()->to($transUrl)->with('message', 'success|Menu save success.');
                return redirect()->back()->with('message', 'success|Menu save success.');
            } catch (\Throwable $th) {
                if($translation)
                    return redirect()->to($transUrl)->with('message', 'danger|Menu save something wrong try again!');
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
                if($translation)
                    return redirect()->to($transUrl)->with('message', 'success|Menu save success.');
                return redirect()->back()->with('message', 'success|Menu save success.');
            } catch (\Throwable $th) {
                if($translation)
                    return redirect()->to($transUrl)->with('message', 'danger|Menu save something wrong try again!');
                return redirect()->back()->with('message', 'danger|Menu save something wrong try again!');
            }

        }

        $homeData = [];
        if(isset($request->option_home_slider_desc) && !empty($request->option_home_slider_desc)) {
            $slider_desc = $request->option_home_slider_desc;
            $slider_url = $request->option_home_slider_url;
            $slider_logo = $request->option_home_slider_logo;
            $slider_banner_desktop = $request->option_home_slider_banner_desktop;
            $slider_banner_tablet = $request->option_home_slider_banner_tablet;
            $slider_banner_mobile = $request->option_home_slider_banner_mobile;

            foreach ($slider_desc as $key => $slider) {
                $homeData['slider'][] = [
                    'desc' => $slider_desc[$key],
                    'url' => $slider_url[$key],
                    'logo' => $slider_logo[$key],
                    'banner_desktop' => $slider_banner_desktop[$key],
                    'banner_tablet'  => $slider_banner_tablet[$key],
                    'banner_mobile'  => $slider_banner_mobile[$key]
                ];
            }
        }

        $homeData['our_service'] = [
            'background' => $request->option_our_service_bg,
            'title' => $request->option_our_service_title,
            'heading' => $request->option_our_service_heading,
            'paragraph' => $request->option_our_service_paragraph,
            'url'   => $request->option_our_service_url
        ];
        $homeData['our_hotel'] = [
            'title' => $request->option_our_hotel_title,
            'heading' => $request->option_our_hotel_heading,
            'url'   => $request->option_our_hotel_url,
        ];
        if(isset($request->option_home_hotel_banner) && !empty($request->option_home_hotel_banner) ) {
            $hotel_banner = $request->option_home_hotel_banner;
            $hotel_logo = $request->option_home_hotel_logo;
            foreach ($hotel_banner as $key => $h_banner) {
                $homeData['our_hotel']['hotels'][] = [
                    'banner' => $h_banner,
                    'logo'  => $hotel_logo[$key]
                ];
            }
        }

        $homeData['message'] = [
            'background' => $request->option_our_message_bg,
            'title' => $request->option_our_message_title,
            'paragraph' => $request->option_our_message_paragraph,
            'author'    => $request->option_our_message_auth,
            'avatar'    => $request->option_our_avatar_image,
            'sign'      => $request->option_our_message_sign,
        ];

        $homeData['our_brand'] = [
            'title' => $request->option_our_brand_title,
            'heading' => $request->option_our_brand_heading,
        ];
        if(isset($request->option_home_brand_banner) && !empty($request->option_home_brand_banner)) {
            $brand_banner = $request->option_home_brand_banner;
            $brand_url = $request->option_home_brand_url;
            foreach ($brand_banner as $key => $b_banner) {
                $homeData['our_brand']['brands'][] = [
                    'banner' => $b_banner,
                    'url'  => $brand_url[$key]
                ];
            }
        }

        if(isset($request->option_type) && $request->option_type == 'homepage_setting') {
            try {
                $findData = $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::HOME['VALUE'])->get();
                if($findData->isNotEmpty()) {
                    $this->optionRepository->getInstantModel()->where('option_key', OptionMetaKey::HOME['VALUE'])->update(['option_value' => json_encode($homeData)]);
                }else {
                    $this->optionRepository->create(['option_key' => OptionMetaKey::HOME['VALUE'], 'option_value' => json_encode($homeData) ]);
                }
                if($translation)
                    return redirect()->to($transUrl)->with('message', 'success|Home option save success.');
                return redirect()->back()->with('message', 'success|Home option save success.');
            } catch (\Throwable $th) {
                if($translation)
                    return redirect()->to($transUrl)->with('message', 'danger|Home option save something wrong try again!');
                return redirect()->back()->with('message', 'danger|Home option save something wrong try again!');
            }
        }

        return redirect()->back();
    }

}
