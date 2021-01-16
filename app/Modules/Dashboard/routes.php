<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Dashboard\Controllers';
Route::group(
    ['module'=>'dashboard', 'namespace' => $namespace, 'middleware' => ['web','auth']],
    function() {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [
                'uses' => 'DashboardController@index'
            ])->name('dashboard');
        });
    }
);

