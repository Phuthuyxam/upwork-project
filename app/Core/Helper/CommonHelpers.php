<?php

use App\Core\Glosary\LocationConfigs;

if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
if (!function_exists('displayAlert')) {
    function displayAlert($messageFull)
    {
        if (!$messageFull) return '';
        list($type, $message) = explode('|', $messageFull);
        return sprintf('<div class="alert alert-%s" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>%s</div>', $type, $message);
    }
}

if(!function_exists('generatePrefixLanguage')) {
    function generatePrefixLanguage() {
        if(!isset($_SERVER['REQUEST_URI']) || empty($_SERVER['REQUEST_URI'])) return false;
        $serverPath = explode('/', $_SERVER['REQUEST_URI']);
        $firstLevel = $serverPath[1];
        if((LocationConfigs::checkLanguageCode($firstLevel))){
            app()->setLocale($firstLevel);
            return  app()->getLocale().'/';
        }else {
            return '';
        }


    }
}
