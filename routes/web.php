<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommunityLikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityCommentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/posts', 'store')->name('store');
    Route::get('/posts/create', 'create')->name('create');
    Route::get('/posts/{post}', 'show')->name('show');
    Route::put('/posts/{post}', 'update')->name('update');
    Route::delete('/posts/{post}', 'delete')->name('delete');
    Route::get('/posts/{post}/edit', 'edit')->name('edit');
    Route::get('/search', 'search')->name('search');
    Route::get('/posts/search/{post}', 'searchshow')->name('searchshow');
});

Route::get('/following-posts', [PostController::class, 'followingPosts'])->name('following.posts');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/categories/{category}', [CategoryController::class,'index'])->middleware("auth");
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profileoption')->middleware("auth");

Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
Route::get('/is-following/{user}', [FollowController::class, 'isFollowing'])->name('isFollowing');

//フォロワー一覧画面
Route::get('/profile/{user}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
//フォローしたユーザー一覧画面
Route::get('/profile/{user}/following', [ProfileController::class, 'following'])->name('profile.following');
//一覧ページからユーザーのプロフィール表示画面に遷移した画面
Route::get('/user/{user}', [ProfileController::class, 'userProfile'])->name('user.profile');

// // プロフィール表示画面
// Route::get('/profile/show', function () {
//     return view('profiles.profileshow');
// })->name('profileoption');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

// プロフィール編集画面
Route::get('/profile/edit', function () {
    return view('profiles.profileedit');
})->name('profile.edit');

// プロフィール情報の更新
//Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


// 認証が必要なルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/chat/{user}', [ChatController::class, 'openChat'])->name('openChat');
Route::post('/chat', [ChatController::class, 'sendMessage'])->name('endMessage');
Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
Route::delete('/chat/{chat}', [ChatController::class, 'destroy'])->name('chat.destroy');
Route::post('/chat/read', [ChatController::class, 'markAsRead'])->name('message.read');

Route::resource('communities', CommunityController::class);
Route::get('communities/{community}/posts/create', [CommunityPostController::class, 'create'])->name('communities.posts.create');
Route::post('communities/{community}/posts', [CommunityPostController::class, 'store'])->name('communities.posts.store');
Route::post('communities/{community}/join', [CommunityController::class, 'join'])->name('communities.join');
Route::post('communities/{community}/leave', [CommunityController::class, 'leave'])->name('communities.leave');
Route::get('/communities/{community}/select-new-leader', [CommunityController::class, 'selectNewLeader'])->name('communities.selectNewLeader');
Route::get('communities/{community}/members', [CommunityController::class, 'members'])->name('communities.members');
Route::get('/communities/{community}/confirm-delete', [CommunityController::class, 'confirmDelete'])->name('communities.confirmDelete');
Route::post('/communities/{community}/delete', [CommunityController::class, 'delete'])->name('communities.delete');
Route::post('/post/like', [LikeController::class, 'likePost'])->name('likePost');
Route::post('communities/{community}/post/like', [CommunityLikeController::class, 'likePost'])->name('community.likePost');

Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('posts.comments');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('communities/{community}/posts/{post}/comments', [CommunityPostController::class, 'comments'])->name('communities.posts.comments');
Route::post('communities/{community}/posts/{post}/comments', [CommunityCommentController::class, 'store'])->name('communities.posts.comments.store');
require __DIR__.'/auth.php';
