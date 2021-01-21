<?php


namespace App\Core\Glosary;


class EndpointConfig extends BasicEnum
{
    const FRONTEL = ['VALUE' => 0,'NAME' => 'Frontel','LINK' => 'https://frontel.backhotelite.com/en/bookcore/v4/search-dispo.htm'];
    const THE_VENUE = ['VALUE' => 1,'NAME' => 'The Venue','LINK' => 'https://thevenue.backhotelite.com/en/bookcore/v4/search-dispo.htm'];
    const THREE_POINT = ['VALUE' => 2,'NAME' => 'Three Points','LINK' => 'https://three_points.backhotelite.com/en/bookcore/v4/search-dispo.htm'];

    public static function getAll() {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();
        return $constants;
    }
}
