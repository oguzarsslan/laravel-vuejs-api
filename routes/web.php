<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::post('/store', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/get', [UserController::class, 'get']);
    Route::post('/delete', [UserController::class, 'delete']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/getUser', [UserController::class, 'getUser']);
    Route::post('/updateUser', [UserController::class, 'updateUser']);
    Route::post('/storeBlog', [BlogController::class, 'storeBlog']);
});
