<?php

use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Auth;
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
//Route::get('/{anypath}', [App\Http\Controllers\HomeController::class, 'index'])->where('path','.*');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 //category
Route::post('/add-category', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
Route::get('/get-category', 
[App\Http\Controllers\Admin\CategoryController::class, 'index']);
Route::get('/get-active-category', 
[App\Http\Controllers\Admin\CategoryController::class, 'indexActive']);
Route::get('/remove-category/{slug}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy']);
Route::get('/show-category/{slug}', [App\Http\Controllers\Admin\CategoryController::class, 'show']);
Route::post('/update-category', [App\Http\Controllers\Admin\CategoryController::class, 'update']);
Route::post('cats/remove-items', [App\Http\Controllers\Admin\CategoryController::class, 'removeItems']);
Route::post('cats/change-status', [App\Http\Controllers\Admin\CategoryController::class, 'changeStatus']);
//post
Route::post('/add-post', [App\Http\Controllers\Admin\PostController::class, 'store']);
Route::get('/get-post', [App\Http\Controllers\Admin\PostController::class, 'index']);
Route::get('/remove-post/{slug}', [App\Http\Controllers\Admin\PostController::class, 'destroy']);
Route::get('/show-post/{slug}', [App\Http\Controllers\Admin\PostController::class, 'show']);
Route::post('/update-post', [App\Http\Controllers\Admin\PostController::class, 'update']);
Route::post('posts/remove-items', [App\Http\Controllers\Admin\PostController::class, 'removeItems']);
Route::post('posts/change-status', [App\Http\Controllers\Admin\PostController::class, 'changeStatus']);
 
