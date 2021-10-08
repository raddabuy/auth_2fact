<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/token', [App\Http\Controllers\Auth\AuthTokenController::class, 'getToken']);
Route::post('/auth/token', [App\Http\Controllers\Auth\AuthTokenController::class, 'postToken']);

Route::group(['middleware' => 'auth'], function(){
   Route::get('/settings/twofactor','App\Http\Controllers\TwoFactorSettingsController@index');
   Route::put('/settings/twofactor','App\Http\Controllers\TwoFactorSettingsController@update');
});
