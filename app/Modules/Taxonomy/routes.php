<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Taxonomy\Controllers';
Route::group(
    ['module'=>'taxonomy', 'namespace' => $namespace, 'middleware' => ['web','auth','ptx.permission']],
    function() {
        Route::prefix('admin')->group(function () {
            Route::get('/taxonomy/add', [
                'uses' => 'TaxonomyController@add'
            ])->name('taxonomy.add');
        });
    }
);
