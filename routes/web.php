<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PostController;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
});


Route::post('/loginApi', [AuthController::class, 'login'])->name('loginApi');
Route::get('/token', [AuthController::class, 'showToken'])->name('token');
Route::get('/post', [PostController::class, 'index'])->name('post');
Route::get('/addNew', [PostController::class, 'addNew'])->name('addNew');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/clear-cookies', function () {
    return view('components.clear-cookies');
})->name('clear-cookies');

