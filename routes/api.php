<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::group(['prefix'=>'/auth'],function(){

    Route::post('/register',[AuthController::class,'register']);

    Route::post('/login',[AuthController::class,'login']);

});

Route::group(['middleware'=>['auth:sanctum']],function(){

    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/tasks/byName',[TaskController::class,'searchByName']);
    Route::resource('/tasks',TaskController::class)->except(['create','edit']);
});
