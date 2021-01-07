<?php


namespace App\Core\Glosary;


class MetaKey extends BasicEnum
{
    const BANNER = ['VALUE' => 0,'NAME' => 'file'];
    const TITLE = ['VALUE' => 1,'NAME' => 'title'];
    const DESCRIPTION = ['VALUE' => 2,'NAME' => 'description'];

    public static function display($value) {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $item) {
            if ($item['VALUE'] == $value) return $item['NAME'];
        }
        return false;
    }
}
