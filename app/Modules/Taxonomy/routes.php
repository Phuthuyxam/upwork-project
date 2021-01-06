<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Taxonomy\Controllers';
Route::group(
    ['module'=>'taxonomy', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::prefix('admin/taxonomy')->group(function () {
            Route::get('/','TaxonomyController@index')->name('taxonomy.index');
            Route::match(['get','post'],'/add','TaxonomyController@add')->name('taxonomy.add');
            Route::post('/delete','TaxonomyController@delete')->name('taxonomy.delete');
        });
    }
);
