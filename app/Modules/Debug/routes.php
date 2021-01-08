<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Debug\Controllers';

$prefix = generatePrefixLanguage();

Route::group(
    ['module'=>'Debug', 'namespace' => $namespace, 'middleware' => ['web', 'auth','ptx.permission'] , 'prefix' => $prefix.'admin' ],
    function() {
        Route::get('/debug', function () {
            echo "asdasdada";
        });
    }
);
