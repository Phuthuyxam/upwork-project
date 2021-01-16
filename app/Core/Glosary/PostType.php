<?php


namespace App\Core\Glosary;


class PostType extends BasicEnum
{
    const POST = ['VALUE' => 0, 'NAME' => 'post'];
    const PAGE = ['VALUE' => 1,'NAME' => 'page'];

    public static function display($value) {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $item) {
            if ($item['VALUE'] == $value) return $item['NAME'];
        }
        return false;
    }
}
