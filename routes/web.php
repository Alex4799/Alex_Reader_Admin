<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlayListController;
use App\Http\Controllers\MessageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['authMiddleware'])->group(function () {
    Route::get('/',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
});
Route::get('test',function(){
    return 'testing';
});
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['adminMiddleware'])->group(function () {
        //account
        Route::get('admin/profile',[AdminController::class,'profile'])->name('admin#profile');
        Route::get('admin/profile/edit',[AdminController::class,'profileEdit'])->name('admin#profileEdit');
        Route::post('admin/profile/update',[AdminController::class,'profileUpdate'])->name('admin#profileUpdate');
        Route::get('admin/view/profile/{id}',[AdminController::class,'viewProfile'])->name('admin#viewProfile');
        Route::get('admin/changePassword/page',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
        Route::post('admin/changePassword',[AdminController::class,'changePassword'])->name('admin#changePassword');
        Route::get('admin/list',[AdminController::class,'adminlist'])->name('admin#list');
        Route::get('admin/add/page',[AdminController::class,'addAdminPage'])->name('admin#addPage');
        Route::post('admin/add',[AdminController::class,'addAdmin'])->name('admin#addAdmin');

        Route::get('admin/change/role/{id}/{status}',[AuthController::class,'changeRole'])->name('admin#changeRole');

        //user
        Route::get('admin/user/list',[AdminController::class,'userList'])->name('admin#userList');
        Route::get('admin/user/addPage',[AdminController::class,'addUserPage'])->name('admin#addUserPage');
        Route::post('admin/user/add',[AdminController::class,'addUser'])->name('admin#addUser');
        Route::get('admin/user/delete/account/{id}',[AdminController::class,'deleteUserAccount'])->name('admin#deleteUserAccount');


        //category
        Route::get('admin/category/list',[CategoryController::class,'categoryList'])->name('admin#categoryList');
        Route::get('admin/category/addPage',[CategoryController::class,'categoryAddpage'])->name('admin#categoryAddpage');
        Route::post('admin/category/add',[CategoryController::class,'categoryAdd'])->name('admin#categoryAdd');
        Route::get('admin/category/edit/{id}',[CategoryController::class,'categoryEdit'])->name('admin#categoryEdit');
        Route::get('admin/category/delete/{id}',[CategoryController::class,'categoryDelete'])->name('admin#categoryDelete');
        Route::post('admin/category/update/{id}',[CategoryController::class,'categoryUpdate'])->name('admin#categoryUpdate');

        //playlist
        Route::get('admin/playlist',[PlayListController::class,'playList'])->name('admin#playlist');
        Route::get('admin/playlist/addPage',[PlaylistController::class,'playlistAddpage'])->name('admin#playlistAddpage');
        Route::post('admin/playlist/add',[PlaylistController::class,'playlistAdd'])->name('admin#playlistAdd');
        Route::get('admin/playlist/edit/{id}',[PlayListController::class,'playlistEdit'])->name('admin#playlistEdit');
        Route::post('admin/playlist/update/{id}',[PlayListController::class,'playlistUpdate'])->name('admin#playlistUpdate');
        Route::get('admin/playlist/delete/{id}',[PlayListController::class,'playlistDelete'])->name('admin#playlistDelete');

        Route::get('admin/playlist/item/{id}',[PlayListController::class,'playlistItem'])->name('admin#playlistItem');
        Route::get('admin/playlist/item/add/page/{id}',[PlayListController::class,'addPlaylistItemPage'])->name('admin#addPlaylistItemPage');
        Route::get('admin/playlist/item/add/{post_id}/{playlist_id}',[PlayListController::class,'addPlaylistItem'])->name('admin#addPlaylistItem');
        Route::get('admin/playlist/item/remove/{post_id}',[PlayListController::class,'removePlaylistItem'])->name('admin#removePlaylistItem');


        //post
        Route::get('admin/post/list',[PostController::class,'postList'])->name('admin#postList');
        Route::get('admin/post/addPage',[PostController::class,'addPostPage'])->name('admin#addPostPage');
        Route::post('admin/post/add',[PostController::class,'addPost'])->name('admin#addPost');
        Route::get('admin/post/view/{id}',[PostController::class,'viewPost'])->name('admin#viewPost');
        Route::get('admin/post/edit/{id}',[PostController::class,'editPost'])->name('admin#editPost');
        Route::post('admin/post/update/{id}',[PostController::class,'updatePost'])->name('admin#updatePost');
        Route::get('admin/post/delete/{id}',[PostController::class,'deletePost'])->name('admin#deletePost');

        //like
        Route::get('admin/like/post/{post_id}',[LikeController::class,'setLike'])->name('admin#setLike');

        //comment
        Route::post('admin/comment/send',[CommentController::class,'sendComment'])->name('admin#sendComment');

        //message
        Route::get('admin/message/list/{status}',[MessageController::class,'messageList'])->name('admin#messageList');
        Route::get('admin/message/send/page/{reply_id}',[MessageController::class,'sendMessagePage'])->name('admin#sendMessagePage');
        Route::post('admin/message/send',[MessageController::class,'sendMessage'])->name('admin#sendMessage');
        Route::get('admin/message/view/{id}',[MessageController::class,'viewMessage'])->name('admin#viewMessage');


    });

    // user
    Route::middleware(['userMiddleware'])->group(function () {
        Route::get('user/profile',[UserController::class,'profile'])->name('user#profile');
        Route::get('go/user/page',[UserController::class,'changeUserPage'])->name('user#changeUserPage');
    });

});

require __DIR__.'/auth.php';
