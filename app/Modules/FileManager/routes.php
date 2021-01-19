<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\FileManager\Controllers';
Route::group(
    ['module'=>'FileManager', 'namespace' => $namespace, 'middleware' => [ 'web', 'auth' , 'ptx.permission' , 'ptx.first.login' ], 'as'=>'filemanager.', 'prefix' => '/admin' ],
    function() {
        Route::get('/file-manager', [
            'as' => 'index',
            'uses' => 'FileManagerController@index'
        ]);

        Route::get('/file-manager-ckeditor', [
            'as' => 'test-ck-editor',
            'uses' => 'FileManagerController@cktest'
        ]);


    }
);
