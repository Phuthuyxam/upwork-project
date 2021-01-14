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

    const COMPLETE_ITEM = ['VALUE' => 6,'NAME' => 'item'];

    const PAGE_TEMPLATE = ['VALUE' => 7,'NAME' => 'page_template'];

    const INDEX_COMPLETE_ITEM = ['VALUE' => 8 ,'NAME' => 'index_item'];
    const INDEX_IMAGE_ITEM = ['VALUE' => 9 ,'NAME' => 'index_image'];

    const IMAGE_ITEM = ['VALUE' => 10, 'NAME' => 'images'];

    const RATE = ['VALUE' => 11, 'NAME' => 'rate'];
    const LOCATION = ['VALUE' => 12, 'NAME' => 'location'];

    public static function display($value) {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $item) {
            if ($item['VALUE'] == $value) return $item['NAME'];
        }
        return false;
    }

    public static function pageDeleteAbleField() {
        return [MetaKey::COMPLETE_ITEM['VALUE'],MetaKey::INDEX_COMPLETE_ITEM['VALUE'],MetaKey::IMAGE_ITEM['VALUE'],MetaKey::INDEX_IMAGE_ITEM['VALUE']];
    }
}
