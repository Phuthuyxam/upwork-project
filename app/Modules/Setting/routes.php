<?php

use Illuminate\Support\Facades\Route;

$namespace = 'App\Modules\Setting\Controllers';

$prefix = generatePrefixLanguage();

Route::group(
    ['module'=>'Setting', 'namespace' => $namespace, 'middleware' => ['web', 'auth','ptx.permission', 'ptx.first.login'] , 'prefix' => $prefix.'admin', 'as' => 'option.' ],
    function() {
        Route::get('/options/{key?}', [
            'as' => 'index',
            'uses' => 'OptionController@index'
        ]);
        Route::post('/options/{key?}', [
            'as' => 'save',
            'uses' => 'OptionController@save'
        ]);

    }
);
