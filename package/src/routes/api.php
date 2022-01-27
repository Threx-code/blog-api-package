<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Oluwatosin\Blog\Http\Controllers\Api\BlogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:passport')->group(function(){
//
//});


Route::group(['prefix' => 'api'], function () {
    Route::get("/", [BlogController::class, 'index']);
});
