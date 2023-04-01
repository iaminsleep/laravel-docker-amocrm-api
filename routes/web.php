<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [MainController::class, 'index'])->name('index');

Route::group(['prefix' => 'register'], function () {
    Route::get('/', [UserController::class, 'registerPage'])->name('register.page');
    Route::post('/', [UserController::class, 'register'])->name('register.perform');
});
Route::group(['prefix' => 'login'], function () {
    Route::get('/', [UserController::class, 'loginPage'])->name('login.page');
    Route::post('/', [UserController::class, 'login'])->name('login.perform');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
