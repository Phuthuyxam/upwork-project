<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Permission\Controllers';
Route::group(
    ['module'=>'Permission', 'namespace' => $namespace, 'middleware' => [ 'web', 'auth' , 'ptx.permission', 'ptx.first.login' ], 'as'=>'permission.', 'prefix' => '/admin' ],
    function() {
        Route::get('/permision-manage', [
            'as' => 'index',
            'uses' => 'PermissionManagerController@index'
        ]);
        Route::post('/add-permision', [
            'as' => 'add',
            'uses' => 'PermissionManagerController@add'
        ]);

        Route::get('/edit-permision/{id}', [
            'as' => 'edit',
            'uses' => 'PermissionManagerController@edit'
        ]);

        Route::post('/save-permision/{id}', [
            'as' => 'save',
            'uses' => 'PermissionManagerController@save'
        ]);

        Route::post('/del-permision/{id}', [
            'as' => 'delete',
            'uses' => 'PermissionManagerController@delete'
        ]);


    }
);
