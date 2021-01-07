<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Taxonomy\Controllers';
Route::group(
    ['module'=>'taxonomy', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::prefix('admin/taxonomy')->group(function () {
            Route::get('/','TaxonomyController@index')->name('taxonomy.index');
            Route::post('/add','TaxonomyController@add')->name('taxonomy.add');
            Route::post('/delete','TaxonomyController@delete')->name('taxonomy.delete');
            Route::match(['get','post'],'/edit/{id}','TaxonomyController@edit')->name('taxonomy.edit');
            Route::post('/delete-image','TaxonomyController@deleteImage')->name('taxonomy.delete.image');
        });
    }
);
