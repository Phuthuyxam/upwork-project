<?php


namespace App\Core\Glosary;


class PageTemplateConfigs extends BasicEnum
{
//    const HOME = ['NAME' => 'HOME PAGE' , 'KEY' => 'Page::home', ];
//    const DEFAULT = ['NAME' => 'DEFAULT','VALUE' => '0','BACKEND' => 'Post::add','FRONT' => ''];
    const POST = ['NAME' => 'post','VALUE' => '0','DISPLAY' => '', 'TAB_TITLE' => 'POST'];
    const HOTEL = ['NAME' => 'hotel','VALUE' => '1','DISPLAY' => 'Our Hotels', 'TAB_TITLE' => ''];
    const SERVICE = ['NAME' => 'service','VALUE' => '2','DISPLAY' => 'Our Services', 'TAB_TITLE' => 'Services setting'];
    const ABOUT = ['NAME' => 'about','VALUE' => '3','DISPLAY'=>'About Us', 'TAB_TITLE' => 'About us setting'];
    const CONTACT = ['NAME' => 'contact','VALUE' => '4','DISPLAY' => 'Contact Us', 'TAB_TITLE' => ''];

    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }

    public static function parse($value) {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $item) {
            if ($item['NAME'] == $value) return $item;
        }
        return false;
    }
}
