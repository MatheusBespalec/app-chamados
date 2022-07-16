<?php

use App\Http\Controllers\AttackController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PrivateFileController;
use App\Http\Controllers\ProjectController;
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
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(ErrorController::class)->name('errors.')->group(function () {
        Route::get('/erros', 'index')->name('index');
        Route::get('/erros/{error}', 'show')->name('show')->whereNumber('error');
        Route::get('/erros/log/{log}', 'log')->name('log')->whereNumber('log');
        Route::post('/erros/{error}/nota', 'addNote')->name('notes.store')->whereNumber('error');
    });

    Route::controller(CallController::class)->name('calls.')->group(function () {
        Route::get('/chamados', 'index')->name('index');
        Route::get('/chamados/{call}', 'show')->name('show')->whereNumber('call');
        Route::get('/chamados/{call}/historico', 'history')->name('history')->whereNumber('call');
        Route::post('/chamados/{call}/nota', 'addNote')->name('notes.store')->whereNumber('call');
    });

    Route::controller(AttackController::class)->name('attacks.')->group(function () {
        Route::get('/ataques', 'index')->name('index');
        Route::get('/ataques/{attack}', 'show')->name('show')->whereNumber('attack');
        Route::get('/ataques/log/{log}', 'log')->name('log')->whereNumber('log');
        Route::post('/ataques/{attack}/nota', 'addNote')->name('notes.store')->whereNumber('attack');
    });

    Route::controller(ProjectController::class)->name('projects.')->group(function () {
        Route::get('/projetos', 'index')->name('index');
        Route::get('/projetos/{project}', 'show')->name('show')->whereNumber('project');
        Route::get('/projetos/novo', 'create')->name('create');
        Route::post('/projetos/novo', 'store')->name('store');
    });

    Route::controller(CustomerController::class)->name('customers.')->group(function () {
        Route::get('/clientes', 'index')->name('index');
        Route::get('/clientes/{customer}', 'show')->name('show')->whereNumber('customer');
        Route::get('/clientes/novo', 'create')->name('create');
        Route::post('/clientes/novo', 'store')->name('store');
        Route::post('/clientes/{customer}/projeto', 'attachProject')->name('attachProject');
        Route::post('/clientes/{customer}/mensagem', 'addMessage')->name('messages.store')->whereNumber('customer');
    });

    Route::controller(ModuleController::class)->name('modules.')->group(function () {
        Route::post('/modulos/novo', 'store')->name('store');
    });

    Route::get('/storage/{filePath}', PrivateFileController::class)->where('filePath', '.*');
});
