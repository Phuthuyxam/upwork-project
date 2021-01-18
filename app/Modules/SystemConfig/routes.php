<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\SystemConfig\Controllers';
Route::group(
    ['module'=>'SystemConfig', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::prefix('admin/general-setting')->group(function () {
            Route::match(['get','post'],'/{action?}','SystemConfigController@index')->name('system.index');
//            Route::match(['get','post'],'/add','ClientPostController@add')->name('post.add');
//            Route::match(['get','post'],'/edit/{id}','ClientPostController@edit')->name('post.edit');
//            Route::post('/deleteImage','ClientPostController@deleteImage')->name('post.delete.image');
//            Route::post('/deleteMany','ClientPostController@deleteMany')->name('post.delete.many');
//            Route::post('/delete','ClientPostController@delete')->name('post.delete');
        });

        Route::match(['get','post'],'admin/booking-type','SystemConfigController@setBookingType')->name('system.booking_type');
    }
);
