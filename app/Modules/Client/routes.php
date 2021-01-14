<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Client\Controllers';

$prefix = generatePrefixLanguage();

Route::group(
    ['module'=>'Client', 'namespace' => $namespace, 'middleware' => ['web', 'auth'] , 'prefix' => $prefix ],
    function() {
        Route::get('/',['uses' => 'ClientHomeController@index']);
    }
);
