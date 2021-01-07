<?php


namespace App\Core\Glosary;


class RoleConfigs extends BasicEnum
{
    const SUPPERADMIN = ['VALUE' => 1, 'DISPLAY' => 'Supperadmin'];
    const GUEST = ['VALUE' => -99 , 'DISPLAY' => 'Guest'];
}
