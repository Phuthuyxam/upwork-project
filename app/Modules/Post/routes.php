<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Post\Controllers';
Route::group(
    ['module'=>'post', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::prefix('admin/post')->group(function () {
            Route::get('/','PostController@index')->name('post.index');
            Route::match(['get','post'],'/add','PostController@add')->name('post.add');
            Route::match(['get','post'],'/edit/{id}','PostController@edit')->name('post.edit');
        });

    }
);
