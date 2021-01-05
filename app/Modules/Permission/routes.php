<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Permission\Controllers';
Route::group(
    ['module'=>'Permission', 'namespace' => $namespace],
    function() {
        Route::get('/permision-manage', [
            'as' => 'index',
            'uses' => 'DashboardController@index'
        ]);
    }
);
