<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Post\Controllers';
Route::group(
    ['module'=>'Post', 'namespace' => $namespace],
    function() {
        Route::get('post', [
            # middle here
            'as' => 'index',
            'uses' => 'DashboardController@index'
        ]);
    }
);
