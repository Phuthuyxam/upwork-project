<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Seo\Controllers';
$prefix = generatePrefixLanguage();
Route::group(
    ['module'=>'Seo', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission', 'ptx.first.login'], 'prefix' => $prefix.'admin/seo-manager' ],
    function() {
        Route::post('/save/{object_id}/{seo_type}','SeoController@add')->name('seo.add');
        Route::get('/data/{object_id}/{seo_type}','SeoController@getData')->name('seo.data');
    }
);
