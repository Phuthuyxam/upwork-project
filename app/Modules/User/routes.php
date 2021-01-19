<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\User\Controllers';
Route::group(
    ['module'=>'User', 'namespace' => $namespace , 'middleware' => [ 'web', 'auth' , 'ptx.permission', 'ptx.first.login' ], 'as'=>'user.manager.', 'prefix' => '/admin/user-manage' ],
    function() {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'UserManageController@index'
        ]);
        Route::post('/add', [
            'as' => 'add',
            'uses' => 'UserManageController@add'
        ]);

        Route::get('/edit/{id}', [
            'as' => 'edit',
            'uses' => 'UserManageController@edit'
        ]);

        Route::post('/save/{id}', [
            'as' => 'save',
            'uses' => 'UserManageController@save'
        ]);

        Route::post('/del/{id}', [
            'as' => 'delete',
            'uses' => 'UserManageController@delete'
        ]);
    }
);

Route::group(
    ['module'=>'User', 'namespace' => $namespace , 'middleware' => [ 'web', 'auth' ], 'as'=>'user.verify.', 'prefix' => '/admin/first-login' ],
    function() {
        Route::match(['get' , 'post'],'/', [
            'as' => 'index',
            'uses' => 'UserManageController@verifyPassWord'
        ]);

    }
);
