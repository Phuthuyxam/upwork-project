<?php


namespace App\Core\Glosary;


class MetaKey extends BasicEnum
{
    // Common
    const BANNER = ['VALUE' => 0,'NAME' => 'banner'];
    const TITLE = ['VALUE' => 1,'NAME' => 'title'];
    const DESCRIPTION = ['VALUE' => 2,'NAME' => 'description'];

    // Post
    const SLIDE = ['VALUE' => 3, 'NAME' => 'slide' ];
    const ROOM_TYPE = ['VALUE' => 4, 'NAME' => 'room_type'];
    const FACILITY = ['VALUE' => 5, 'NAME' => 'facility'];
    const PAGE_TEMPLATE = ['VALUE' => 7,'NAME' => 'page_template'];

    // Service
    const SERVICE_ITEM = ['VALUE' => 6,'NAME' => 'service_item'];

    // About
    const ABOUT_ITEM = ['VALUE' => 7, 'NAME' => 'about_item'];
    const ABOUT_IMAGE = ['VALUE' => 8, 'NAME' =>'about_image'];

    public static function display($value) {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $item) {
            if ($item['VALUE'] == $value) return $item['NAME'];
        }
        return false;
    }
}
