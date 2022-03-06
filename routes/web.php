<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\CommentController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::post('/store', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

//Route::get('/test', [BlogController::class, 'test']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //user
    Route::get('/get', [UserController::class, 'get']);
    Route::post('/delete', [UserController::class, 'delete']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/getUser', [UserController::class, 'getUser']);
    Route::post('/updateUser', [UserController::class, 'updateUser']);
    Route::post('/updatePassword', [UserController::class, 'updatePassword']);
    Route::get('/deleteProfilePhoto', [UserController::class, 'deleteProfilePhoto']);

    //blog
    Route::post('/storeBlog', [BlogController::class, 'storeBlog']);
    Route::get('/getBlogs', [BlogController::class, 'getBlogs']);
    Route::get('/getBlog/{id}', [BlogController::class, 'getBlog']);
    Route::post('/updateBlog', [BlogController::class, 'updateBlog']);
    Route::post('/deleteBlog', [BlogController::class, 'deleteBlog']);
    Route::post('/deleteImage', [BlogController::class, 'deleteImage']);
    Route::post('/favorited', [BlogController::class, 'favorited']);
    Route::post('/unfavorited', [BlogController::class, 'unfavorited']);
    Route::get('/getFavorites', [BlogController::class, 'getFavorites']);

    //comment
    Route::post('/setComment', [CommentController::class, 'setComment']);
    Route::post('/upComment', [CommentController::class, 'upComment']);
    Route::post('/deleteComment', [CommentController::class, 'deleteComment']);

    //friends
    Route::get('/getFriends', [FriendController::class, 'getFriends']);
    Route::get('/getRequest', [FriendController::class, 'getRequest']);
    Route::get('/getSent', [FriendController::class, 'getSent']);
    Route::get('/getBlocked', [FriendController::class, 'getBlocked']);
    Route::post('/removeFriend', [FriendController::class, 'removeFriend']);
    Route::post('/acceptFriend', [FriendController::class, 'acceptFriend']);
    Route::post('/blockFriend', [FriendController::class, 'blockFriend']);
    Route::post('/unblockFriend', [FriendController::class, 'unblockFriend']);
    Route::post('/addFriend', [FriendController::class, 'addFriend']);
});
