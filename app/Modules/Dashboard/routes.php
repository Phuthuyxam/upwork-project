<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Dashboard\Controllers';
Route::group(
    ['module'=>'dashboard', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::get('/admin', [
            # middle here
            'as' => 'index',
            'uses' => 'DashboardController@index'
        ]);
    }
);

