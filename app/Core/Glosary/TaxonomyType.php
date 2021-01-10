<?php


namespace App\Core\Glosary;


class TaxonomyType extends BasicEnum
{
    const HOTEL = ['VALUE' => '0','NAME' => 'Hotel'];
    const SERVICE = ['VALUE' => '1','NAME' => 'Service'];

    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }
}
