<?php
//use Illuminate\Support\Facades\Route;
//$namespace = 'App\Modules\Taxonomy\Controllers';
//$prefix = generatePrefixLanguage();
//Route::group(
//    ['module'=>'taxonomy', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission'], 'prefix' => $prefix ],
//    function() {
//        Route::prefix('admin/brands')->group(function () {
//            Route::get('/','TaxonomyController@index')->name('taxonomy.index');
//            Route::post('/add','TaxonomyController@add')->name('taxonomy.add');
//            Route::post('/delete','TaxonomyController@delete')->name('taxonomy.delete');
//            Route::match(['get','post'],'/edit/{id}','TaxonomyController@edit')->name('taxonomy.edit');
//            Route::post('/delete-image','TaxonomyController@deleteImage')->name('taxonomy.delete.image');
//            Route::post('/delete-many','TaxonomyController@deleteMany')->name('taxonomy.delete.many');
//            Route::post('/change-default','TaxonomyController@changeDefault')->name('taxonomy.change.default');
//        });
//    }
//);
