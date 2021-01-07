<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Post\Controllers';
Route::group(
    ['module'=>'taxonomy', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::prefix('admin/post')->group(function () {
            Route::get('/','PostController@index')->name('post.index');
        });
    }
);
