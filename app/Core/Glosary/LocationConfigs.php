<?php


namespace App\Core\Glosary;


class LocationConfigs extends BasicEnum
{
    const ENGLISH = ['VALUE' => 'en' , 'DISPLAY' => 'english'];
    const ARABIC = ['VALUE' => 'ar', 'DISPLAY' => 'arabic'];
    public static function checkLanguageCode($code) {
        $allLang = parent::getConstants();
        $result = false;
        if(!empty($allLang))
            foreach ($allLang as $lang) {
                if($code == $lang['VALUE']) {
                    $result = true;
                    break;
                }
            }
        return $result;
    }
}
