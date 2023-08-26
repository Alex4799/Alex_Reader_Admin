<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlayListController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login',[AuthController::class,'login_user']);
Route::post('user/register',[AuthController::class,'register_user']);

Route::middleware(['auth:sanctum'])->group(function () {
    // account
    Route::get('user/get/{id}',[UserController::class,'getUser']);
    Route::post('user/update/{id}',[UserController::class,'updateUser']);
    Route::post('user/change/password',[UserController::class,'changePassword']);

    //post
    Route::get('user/post/get',[PostController::class,'getPost_user']);
    Route::get('user/post/get/category/{id}',[PostController::class,'getPostCategory_user']);
    Route::get('user/post/get/search/{search_key}',[PostController::class,'getPostSearch_user']);
    Route::get('user/mypost/get/{id}',[PostController::class,'getMyPost']);
    Route::post('user/post/add',[PostController::class,'addPost_user']);
    Route::get('user/post/view/{id}',[PostController::class,'viewPost_user'])->name('user#viewPost');
    Route::get('user/post/edit/{id}',[PostController::class,'editPost_user'])->name('user#edit');
    Route::post('user/post/update',[PostController::class,'updatePost_user'])->name('user#update');

    //playlist
    Route::get('user/playlist/get/{id}',[PlayListController::class,'getMyPlaylist_user'])->name('user#getMyPlaylist');
    Route::post('user/playlist/get/search',[PlayListController::class,'getSearchPlaylist_user']);
    Route::get('user/playlist/postCount/{id}',[PlayListController::class,'getPlaylistPost']);
    Route::post('user/playlist/add/playlist',[PlaylistController::class,'addPlaylist_user']);
    Route::get('user/playlist/edit/{playlist_id}',[PlaylistController::class,'editPlaylist_user']);
    Route::post('user/playlist/update',[PlayListController::class,'updatePlaylist_user']);
    Route::get('user/playlist/item/{id}',[PlayListController::class,'getPlaylistItem_user']);
    Route::get('user/playlist/item/remove/{post_id}/{playlist_id}',[PlayListController::class,'removePlaylistItem_user']);
    Route::get('user/playlist/item/add/getData/{playlist_id}',[PlayListController::class,'addPlayListItemGetData_user'])->name('user#addPlayListItemGetData');
    Route::get('user/playlist/item/add/{post_id}/{playlist_id}',[PlayListController::class,'addPlaylistItem_user']);
    Route::get('user/playlist/delete/{id}',[PlayListController::class,'deletePlaylist']);

    //category
    Route::get('user/category/get',[CategoryController::class,'getCategory_user']);
    Route::post('user/category/add',[CategoryController::class,'addCategory_user']);
    Route::post('user/category/update',[CategoryController::class,'updateCategory_user']);
    Route::get('user/category/getItem/{id}',[CategoryController::class,'getCategoryItem_user']);
    Route::get('user/category/delete/{id}',[CategoryController::class,'deleteCategory_user']);
    Route::get('user/category/search/{search_key}',[CategoryController::class,'searchCategory_user']);

    //users
    Route::get('users/list/get',[UserController::class,'getUsersList']);
    Route::get('users/list/search/{search_key}',[UserController::class,'getSearchUsersList']);

    //like
    Route::get('user/like/set/{post_id}',[LikeController::class,'setLike_user']);

    //comment
    Route::post('user/send/comment',[CommentController::class,'sendComment_user']);

    //message
    Route::get('user/message/list/{email}/{status}',[MessageController::class,'messageList_user']);
    Route::post('user/message/list/search',[MessageController::class,'searchMessageList_user']);
    Route::get('user/message/reply/email/{reply_id}',[MessageController::class,'getReplyEmail_user']);
    Route::post('user/message/send',[MessageController::class,'sendMessage_user']);
    Route::get('user/message/view/{id}',[MessageController::class,'viewMessage_user']);
});
