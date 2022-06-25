<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Public Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'signIn'])->name('signIn');
});

// Private Routes
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // AuthController Routes
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Error Controller Routes
    Route::controller(ErrorController::class)->name('errors.')->group(function () {
        Route::get('/erros', 'index')->name('index');
        Route::get('/erros/{error}', 'show')->name('show');
    });
});
