<?php


namespace App\Core\Glosary;


class PostStatus extends BasicEnum
{
    const PUBLIC = ['VALUE' => 1, 'NAME' => 'Publish'];
    const DRAFT = ['VALUE' => 0, 'NAME' => 'Draft'];

    public static function display($value) {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        foreach ($constants as $item) {
            if ($item['VALUE'] == $value) return $item['NAME'];
        }
        return false;
    }
}
