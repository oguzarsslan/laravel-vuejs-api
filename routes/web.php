<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FriendController;

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
    Route::get('/getBlogs', [BlogController::class, 'getBlogs']);
    Route::get('/getBlog/{id}', [BlogController::class, 'getBlog']);

    //friends
    Route::post('/addFriend', [FriendController::class, 'addFriend']);
    Route::post('/acceptFriend', [FriendController::class, 'acceptFriend']);
    Route::post('/denyFriend', [FriendController::class, 'denyFriend']);
    Route::post('/removeFriend', [FriendController::class, 'removeFriend']);
    Route::post('/blockFriend', [FriendController::class, 'blockFriend']);
    Route::post('/unblockFriend', [FriendController::class, 'unblockFriend']);
    Route::get('/getFriends', [FriendController::class, 'getFriends']);

});
