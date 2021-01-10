<?php


namespace App\Core\Glosary;


class MetaKey extends BasicEnum
{
    const BANNER = ['VALUE' => 0,'NAME' => 'file'];
    const TITLE = ['VALUE' => 1,'NAME' => 'title'];
    const DESCRIPTION = ['VALUE' => 2,'NAME' => 'description'];

    const SLIDE = ['VALUE' => 3, 'NAME' => 'slide' ];
    const ROOM_TYPE = ['VALUE' => 4, 'NAME' => 'room type'];
    const FACILITY = ['VALUE' => 5, 'NAME' => 'facility'];


    public static function display($value) {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $item) {
            if ($item['VALUE'] == $value) return $item['NAME'];
        }
        return false;
    }
}
