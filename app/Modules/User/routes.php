<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\User\Controllers';
Route::group(
    ['module'=>'User', 'namespace' => $namespace , 'middleware' => [ 'web', 'auth' , 'ptx.permission' ], 'as'=>'user.manager.', 'prefix' => '/admin/user-manage' ],
    function() {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'PermissionManagerController@index'
        ]);
        Route::post('/add', [
            'as' => 'add',
            'uses' => 'PermissionManagerController@add'
        ]);

        Route::get('/edit/{id}', [
            'as' => 'edit',
            'uses' => 'PermissionManagerController@edit'
        ]);

        Route::post('/save/{id}', [
            'as' => 'save',
            'uses' => 'PermissionManagerController@save'
        ]);

        Route::post('/del/{id}', [
            'as' => 'delete',
            'uses' => 'PermissionManagerController@delete'
        ]);
    }
);
