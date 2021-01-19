<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Log\Controllers';
Route::group(
    ['module'=>'Log', 'namespace' => $namespace, 'middleware' => ['web', 'auth', 'ptx.first.login']],
    function() {
        Route::prefix('admin/log')->group(function () {
            Route::get('/','LogController@index')->name('log.index');
        });
    }
);
