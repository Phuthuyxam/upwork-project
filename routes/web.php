<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/home-edit', 'ClientPostController@index' );
//
//Route::get('/home-del', 'HomeController@delete' );

\Illuminate\Support\Facades\Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@loggedOut')->name('logout');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::group(['prefix'=>'/admin'],function(){
//    Route::get('/dashboard','CommentController@showComment');
//});
//Route::get('/dashboard', function () {
//    return view('backend.dashboard');
//});
