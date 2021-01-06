<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Taxonomy\Controllers';
Route::group(
    ['module'=>'taxonomy', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::prefix('admin/taxonomy')->group(function () {
            Route::get('/','TaxonomyController@index')->name('taxonomy.index');
            Route::post('/add','TaxonomyController@add')->name('taxonomy.add');
        });
    }
);
