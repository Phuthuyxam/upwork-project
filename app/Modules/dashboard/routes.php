<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\dashboard\Controllers';
Route::group(
    ['module'=>'dashboard', 'namespace' => $namespace],
    function() {
        Route::get('/admin', [
            # middle here
            'as' => 'index',
            'uses' => 'DashboardController@index'
        ]);
    }
);

