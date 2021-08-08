<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
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

Route::get('/', function () {
    return 'OK';
});

Route::post('login', [LoginController::class, 'login']);

Route::post('comments', [CommentController::class, 'all']);

Route::post('comment', [CommentController::class, 'comment']);
