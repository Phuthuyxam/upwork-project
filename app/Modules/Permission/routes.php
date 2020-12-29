<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Post\Controllers';
Route::group(
    ['module'=>'Post', 'namespace' => $namespace],
    function() {
        Route::get('permision-manage', [
            # middle here
            'as' => 'index',
            'uses' => 'PostController@index'
        ]);
    }
);
