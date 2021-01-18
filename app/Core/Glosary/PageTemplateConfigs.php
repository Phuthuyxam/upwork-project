<?php


namespace App\Core\Glosary;


class PageTemplateConfigs extends BasicEnum
{
//    const HOME = ['NAME' => 'HOME PAGE' , 'KEY' => 'Page::home', ];
//    const DEFAULT = ['NAME' => 'DEFAULT','VALUE' => '0','BACKEND' => 'Post::add','FRONT' => ''];
    const POST = ['NAME' => 'post','VALUE' => '0','BACKEND' => '','FRONT' => ''];
    const HOTEL = ['NAME' => 'hotel','VALUE' => '1','BACKEND' => '','FRONT' => ''];
    const SERVICE = ['NAME' => 'service','VALUE' => '2','VIEW'=>'Page::elements.service','BACKEND' => '','FRONT' => ''];
    const ABOUT = ['NAME' => 'about','VALUE' => '3','VIEW'=>'Page::elements.about','BACKEND' => '','FRONT' => ''];
    const CONTACT = ['NAME' => 'contact','VALUE' => '4','BACKEND' => '','FRONT' => ''];

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
