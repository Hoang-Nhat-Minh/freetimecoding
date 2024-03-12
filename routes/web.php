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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/chat', [App\Http\Controllers\HomeController::class, 'chat'])->name('chat');
Route::get('/alpine', [App\Http\Controllers\HomeController::class, 'alpine'])->name('alpine');
Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
