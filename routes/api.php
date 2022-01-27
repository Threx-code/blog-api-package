<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use Oluwatosin\Blog\Http\Controllers\Api\{
    BlogController,
    CategoryController,
    CommentController
};

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get("/", [BlogController::class, 'index']);
Route::post("login", [LoginController::class, 'login']);
Route::get("comment", [CommentController::class, 'store']);
Route::post("register", [RegisterController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::get("category", [CategoryController::class, 'index']);
    Route::post("category", [CategoryController::class, 'store']);
    Route::put("category", [CategoryController::class, 'update']);
    Route::delete("category", [CategoryController::class, 'delete']);
    Route::get("category/{name_or_id}", [CategoryController::class, 'read']);


    Route::post("blog", [BlogController::class, 'store']);
    Route::put("blog", [BlogController::class, 'update']);
    Route::delete("blog", [BlogController::class, 'delete']);
    Route::get("blog/{title_or_id}", [BlogController::class, 'read']);
});



// Route::middleware('auth:passport')->group(function(){
//
//});
