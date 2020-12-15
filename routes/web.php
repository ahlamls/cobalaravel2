<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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


Route::get('/', [HomeController::class , 'index']);
Route::get('/login', [HomeController::class , 'login']);
Route::post('/login', [HomeController::class , 'handlelogin']);
Route::get('/register', [HomeController::class , 'register']);
Route::post('/register', [HomeController::class , 'handleregister']);
Route::get('/upload', [HomeController::class , 'upload']);
Route::post('/upload', [HomeController::class , 'handleupload']);
Route::get('/logout', [HomeController::class , 'logout']);
Route::get('/u/{id}', [HomeController::class , 'profile']);
Route::get('/p/{id}', [HomeController::class , 'post']);
Route::post('/vote', [HomeController::class , 'vote']);
Route::post('/getcomment', [HomeController::class , 'getcomment']);
Route::post('/docomment', [HomeController::class , 'docomment']);
Route::get('/setting', [HomeController::class , 'setting']);
Route::post('/setting', [HomeController::class , 'handlesetting']);
Route::get('/setcookie/{id}', [HomeController::class , 'setCookie']);
Route::get('/search', [HomeController::class , 'search']);