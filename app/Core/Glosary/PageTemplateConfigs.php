<?php


namespace App\Core\Glosary;


class PageTemplateConfigs extends BasicEnum
{
//    const HOME = ['NAME' => 'HOME PAGE' , 'KEY' => 'Page::home', ];
//    const DETAIL_HOTEL = ['NAME' => 'DETAIL HOTEL','VALUE' => '0','BACKEND' => 'Post::add','FRONT' => ''];
    const HOTEL = ['NAME' => 'HOTEL','VALUE' => '1','BACKEND' => '','FRONT' => ''];
    const SERVICE = ['NAME' => 'SERVICE','VALUE' => '2','VIEW'=>'Page::elements.service','BACKEND' => '','FRONT' => ''];
    const ABOUT = ['NAME' => 'ABOUT','VALUE' => '3','VIEW'=>'Page::elements.about','BACKEND' => '','FRONT' => ''];
    const CONTACT = ['NAME' => 'CONTACT','VALUE' => '4','BACKEND' => '','FRONT' => ''];

    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }
}
