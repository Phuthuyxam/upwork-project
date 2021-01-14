<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Page\Controllers';
$prefix = generatePrefixLanguage();
Route::group(
    ['module'=>'page', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission'], 'prefix' => $prefix ],
    function() {
        Route::prefix('admin/page')->group(function () {
            Route::get('/','PageController@index')->name('page.index');
            Route::match(['get','post'],'/add','PageController@add')->name('page.add');
            Route::post('/template','PageController@template')->name('page.template');
            Route::match(['get','post'],'/edit/{id}','PageController@edit')->name('page.edit');
            Route::post('/delete/{id}','PageController@edit')->name('page.delete');
            Route::post('/delete-many','PageController@deleteMany')->name('page.delete.many');
        });
    }
);
