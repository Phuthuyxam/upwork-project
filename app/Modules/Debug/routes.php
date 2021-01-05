<?php
use Illuminate\Support\Facades\Route;
$namespace = 'App\Modules\Debug\Controllers';
Route::group(
    ['module'=>'Debug', 'namespace' => $namespace, 'middleware' => ['web', 'auth','ptx.permission']],
    function() {
    }
);
