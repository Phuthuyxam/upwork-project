<?php


namespace App\Core\Glosary;


class OptionMetaKey extends BasicEnum
{
    const MENU = ['VALUE' => 'menu','DISPLAY' => 'Menu setting'];
    const FOOTER = ['VALUE' => 'footer','DISPLAY' => 'Footer setting'];
    const HOME = ['VALUE' => 'home','DISPLAY' => 'Home page setting'];
    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }
}
