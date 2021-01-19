<?php


namespace App\Core\Glosary;


class LocationConfigs extends BasicEnum
{
    const ENGLISH = ['VALUE' => 'en' , 'DISPLAY' => 'english', 'DEFAULT' => true, 'LOCALE_CODE' => 'en_US', 'FRONTEND' => 'EN'];
    const ARABIC = ['VALUE' => 'ar', 'DISPLAY' => 'arabic', 'DEFAULT' => false, 'LOCALE_CODE' => 'ar_AE', 'FRONTEND' => 'عربي'];
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

    public static function getLanguageByCode($code) {
        $allLang = parent::getConstants();
        $result = false;
        if(!empty($allLang))
            foreach ($allLang as $lang) {
                if($code == $lang['VALUE']) {
                    $result = $lang;
                    break;
                }
            }
        return $result;
    }

    public static function getLanguageDefault() {
        $allLang = parent::getConstants();
        $result = false;
        if(!empty($allLang))
            foreach ($allLang as $lang) {
                if(true == $lang['DEFAULT']) {
                    $result = $lang;
                    break;
                }
            }
        return $result;
    }

    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }
}
