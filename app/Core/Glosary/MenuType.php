<?php


namespace App\Core\Glosary;


class MenuType extends BasicEnum
{
    const CURRENT_DOMAIN = ['VALUE' => '0', 'DISPLAY' => 'Current domain'];
    const OTHER_DOMAIN = ['VALUE' => '1', 'DISPLAY' => 'Other domain'];

    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }
}
