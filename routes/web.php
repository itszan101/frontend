<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\DashboardController;

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
Route::post('/store', [PostController::class, 'store'])->name('store');
Route::get('/createpost', [PostController::class, 'indexCreate'])->name('createPost');
Route::get('/post', [PostController::class, 'index'])->name('post');
Route::post('/destroy', [PostController::class, 'destroy'])->name('destroy');

Route::get('/', function () {
    return view('auth.login');
});
Route::post('/loginApi', [AuthController::class, 'login'])->name('loginApi');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/add-client', [AdminController::class, 'addClient'])->name('AddClient');
    Route::get('/client', [AdminController::class, 'index'])->name('client');
});

Route::get('/token', [AuthController::class, 'showToken'])->name('token');


