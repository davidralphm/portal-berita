<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsManagementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportManagementController;
use App\Http\Controllers\UserManagementController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', function() {
    return view('auth.login');
})->middleware('guest');

Route::get('/register', function() {
    return view('auth.register');
})->middleware('guest');

Route::controller(DashboardController::class)->middleware('auth')->group(function() {
    Route::get('/dashboard', 'index');
    Route::patch('/dashboard', 'update');
    Route::delete('/dashboard', 'delete');

    Route::get('/dashboard/bookmarks/{page?}', 'bookmarks');
});

Route::controller(CommentController::class)->group(function() {
    Route::post('/comment/reply/{commentID}', 'storeReply')->middleware('auth');
    Route::post('/comment/news/{newsID}', 'storeNews')->middleware('auth');

    Route::get('/comment/{commentID}', 'edit')->middleware('auth');
    Route::patch('/comment/{commentID}', 'update')->middleware('auth');
    Route::delete('/comment/{commentID}', 'delete')->middleware('auth');

    Route::get('/comment/{commentID}/like', 'like')->middleware('auth');
    Route::get('/comment/{commentID}/dislike', 'dislike')->middleware('auth');
    Route::get('/comment/{commentID}/removeVote', 'removeVote')->middleware('auth');
    Route::get('/comment/{commentID}/replies', 'commentReplies');
});

// Reporting functionalities

Route::controller(ReportController::class)->middleware('auth')->group(function() {
    Route::get('/report/user/{id}', 'getReportUser');
    Route::post('/report/user/{id}', 'postReportUser');

    Route::get('/report/news/{id}', 'getReportNews');
    Route::post('/report/news/{id}', 'postReportNews');

    Route::get('/report/comment/{id}', 'getReportComment');
    Route::post('/report/comment/{id}', 'postReportComment');
});

// Report management functionalities

Route::controller(ReportManagementController::class)->group(function() {
    Route::get('/reportManagement/user', 'indexUser');
    Route::get('/reportManagement/user/{userId}/reports', 'showUserReports');
    Route::get('/reportManagement/user/{reportId}', 'showUser');
    Route::delete('/reportManagement/user/{reportId}', 'deleteUser');

    Route::get('/reportManagement/news', 'indexNews');
    Route::get('/reportManagement/news/{newsId}/reports', 'showNewsReports');
    Route::get('/reportManagement/news/{reportId}', 'showNews');
    Route::delete('/reportManagement/news/{reportId}', 'deleteNews');

    Route::get('/reportManagement/comment', 'indexComment');
    Route::get('/reportManagement/comment/{commentId}/reports', 'showCommentReports');
    Route::get('/reportManagement/comment/{reportId}', 'showComment');
    Route::delete('/reportManagement/comment/{reportId}', 'deleteComment');
});

// User management stuff

Route::controller(UserManagementController::class)->group(function() {
    Route::get('/userManagement', 'index');
    Route::post('/userManagement', 'store');

    Route::get('/userManagement/create', 'create');

    Route::get('/userManagement/{id}', 'show');
    Route::patch('/userManagement/{id}', 'update');
});

// Comment management stuff

Route::controller(CommentManagementController::class)->group(function() {
    Route::get('/commentManagement/news/{newsId}', 'indexNews');
    Route::get('/commentManagement/{commentId}', 'show');
    Route::get('/commentManagement/{commentId}/replies', 'indexReplies');
    Route::delete('/commentManagement/{commentId}', 'delete');
});

// News management stuff

Route::controller(NewsManagementController::class)->group(function() {
    Route::get('/newsManagement', 'index');
    Route::post('/newsManagement', 'store');

    Route::get('/newsManagement/create', 'create');

    Route::post('/newsManagement/uploadFile/{newsId}', 'uploadFile');
    Route::get('/newsManagement/deleteUploadedFile/{filename}', 'deleteUploadedFile');

    Route::get('/newsManagement/{id}', 'show');
    Route::patch('/newsManagement/{id}', 'update');
    Route::delete('/newsManagement/{id}', 'delete');
});

// Testing email

Route::get('/testemail', function() {
    Mail::to('admin@test.com')->send(new TestMail());
});

// Authentication stuff

require __DIR__.'/auth.php';

// News routes

Route::controller(NewsController::class)->group(function() {
    Route::get('/', 'index');
    Route::get('/search', 'search');
    Route::get('/bookmarks', 'indexBookmarks')->middleware('auth');
    Route::get('/{slug}', 'get');
    Route::get('/{slug}/like', 'like')->middleware('auth');
    Route::get('/{slug}/dislike', 'dislike')->middleware('auth');
    Route::get('/{slug}/removeVote', 'removeVote')->middleware('auth');
    Route::get('/{slug}/addBookmark', 'addBookmark')->middleware('auth');
    Route::get('/{slug}/removeBookmark', 'removeBookmark')->middleware('auth');
});