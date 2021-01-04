<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Debug\Controllers';
Route::group(
    ['module'=>'Debug', 'namespace' => $namespace, 'middleware' => ['web', 'auth','ptx.permission']],
    function() {
        Route::get('/debug-post', [
            # middle here
            'as' => 'index',
            'uses' => 'DebugController@index'
        ]);

        Route::get('/debug-edit', [
            # middle here
            'as' => 'edit',
            'uses' => 'DebugController@edit'
        ]);

        Route::get('/debug-del', [
            # middle here
            'as' => 'edit',
            'uses' => 'DebugController@delete'
        ]);

        Route::get('/debug-index-2', [
            # middle here
            'as' => 'index',
            'uses' => 'DebugController2@index'
        ]);

        Route::get('/debug-edit2', [
            # middle here
            'as' => 'edit',
            'uses' => 'DebugController2@edit'
        ]);

        Route::get('/debug-del2', [
            # middle here
            'as' => 'edit',
            'uses' => 'DebugController2@delete'
        ]);


    }
);
