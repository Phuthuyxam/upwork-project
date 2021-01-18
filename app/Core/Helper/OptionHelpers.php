<?php


namespace App\Core\Helper;


use App\Modules\Setting\Repositories\OptionRepository;
use App\Modules\SystemConfig\Repositories\SystemConfigRepository;

class OptionHelpers
{
    public static function getOptionByKey($key) {
        $optionRepository = new OptionRepository();
        $result = $optionRepository->filter([['option_key', $key]]);
        return ($result && $result->isNotEmpty()) ? $result[0]->option_value : false;
    }

    public static function getSystemConfigByKey($key) {
        $systemConfigRepository = new SystemConfigRepository();
        $result = $systemConfigRepository->filter([['option_key', $key]]);
        return ($result && $result->isNotEmpty()) ? $result[0]->option_value : false;
    }
}