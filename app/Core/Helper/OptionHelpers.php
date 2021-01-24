<?php


namespace App\Core\Helper;


use App\Modules\Setting\Repositories\OptionRepository;
use App\Modules\SystemConfig\Repositories\SystemConfigRepository;

class OptionHelpers
{
    public static function getOptionByKey($key, $langCode = false) {
        $optionRepository = new OptionRepository();
        if($langCode){
            app()->setLocale($langCode);
            $optionRepository->setModel();
        }
        $optionRepository = $optionRepository->getInstantModel();
        $result = $optionRepository->where([['option_key', $key]])->get();
        return ($result && $result->isNotEmpty()) ? $result[0]->option_value : false;
    }

    public static function getSystemConfigByKey($key) {
        $systemConfigRepository = new SystemConfigRepository();
        $result = $systemConfigRepository->filter([['option_key', $key]]);
        return ($result && $result->isNotEmpty()) ? $result[0]->option_value : false;
    }


    public static function getImagePaths($fileArray) {
        $domain = env('APP_URL');
        $paths = [];
        foreach ($fileArray as $value) {
            $paths[] = explode($domain,$value)[1];
        }

        return $paths;
    }

    public static function getImagePath($file) {
        $domain = env('APP_URL');

        return explode($domain,$file)[1];
    }

}
