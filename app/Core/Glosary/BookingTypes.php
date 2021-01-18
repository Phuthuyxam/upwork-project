<?php


namespace App\Core\Glosary;


class BookingTypes extends BasicEnum
{
    const LINK = ['VALUE' => '0', 'DISPLAY' => 'External Link', 'ID' => 'link' ,'PLACE_HOLDER' => 'Add url*'];
    const FORM = ['VALUE' => '1', 'DISPLAY' => 'Form',  'ID' => 'form', 'PLACE_HOLDER' => 'Add email address to submit*'];
    const INTEGRATION = ['VALUE' => '2', 'DISPLAY' => 'Integration with Red Tiger', 'ID' => 'integration','PLACE_HOLDER' => 'Add destination url*'];

    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }
}
