<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

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

Route::get('/', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'showArticles'])->where('id', '[0-9]+');


Route::get('/publish', function () {
    Redis::publish('channel', json_decode(['foo' => 'bar']));
});