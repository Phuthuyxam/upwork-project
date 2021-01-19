<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Page\Controllers';
$prefix = generatePrefixLanguage();
Route::group(
    ['module'=>'page', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission' , 'ptx.first.login'], 'prefix' => $prefix ],
    function() {
        Route::prefix('admin/page')->group(function () {
            Route::match(['get','post'],'/{template}','PageController@add')->name('page.add');
        });
    }
);
