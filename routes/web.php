<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttackController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BancoDigitalController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PrivateFileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhitelistController;

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

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('validar-acesso', [AuthController::class, 'releaseAccess'])->name('releaseAccess');
    Route::post('login', [AuthController::class, 'signIn'])->name('signIn');
});

Route::middleware(['auth', 'whitelist'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(UserController::class)->name('users.')->group(function () {
        Route::get('perfil', 'profile')->name('profile');
        Route::get('usuarios', 'index')->name('index');
        Route::get('usuarios/novo', 'create')->name('create');
        Route::post('usuarios/novo', 'store')->name('store');
        Route::post('usuarios/{user}/editar', 'update')->name('update')->whereNumber('user');
    });

    Route::controller(ErrorController::class)->name('errors.')->group(function () {
        Route::get('/erros', 'index')->name('index');
        Route::get('/erros/{error}', 'show')->name('show')->whereNumber('error');
        Route::get('/erros/log/{log}', 'log')->name('log')->whereNumber('log');
        Route::post('/erros/{error}/mensagem', 'storeMessage')->name('messages.store')->whereNumber('error');
    });

    Route::controller(CallController::class)->name('calls.')->group(function () {
        Route::get('/chamados', 'index')->name('index');
        Route::get('/chamados/{call}', 'show')->name('show')->whereNumber('call');
        Route::patch('/chamados/{call}/finalizar', 'finish')->name('finish')->whereNumber('call');
        Route::get('/chamados/{call}/historico', 'history')->name('history')->whereNumber('call');
        Route::post('/chamados/{call}/mensagem', 'storeMessage')->name('messages.store')->whereNumber('call');
        Route::post('/chamados/{call}/enviar-mensagem', 'sendMessage')->name('messages.send')->whereNumber('call');
    });

    Route::controller(AttackController::class)->name('attacks.')->group(function () {
        Route::get('/ataques', 'index')->name('index');
        Route::get('/ataques/{attack}', 'show')->name('show')->whereNumber('attack');
        Route::get('/ataques/log/{log}', 'log')->name('log')->whereNumber('log');
        Route::post('/ataques/{attack}/mensagem', 'storeMessage')->name('messages.store')->whereNumber('attack');
    });

    Route::controller(ProjectController::class)->name('projects.')->group(function () {
        Route::get('/projetos', 'index')->name('index');
        Route::get('/projetos/{project}', 'show')->name('show')->whereNumber('project');
        Route::get('/projetos/novo', 'create')->name('create');
        Route::post('/projetos/novo', 'store')->name('store');
    });

    Route::controller(BancoDigitalController::class)->name('banco-digital.')->group(function () {
        Route::get('/banco-digital', 'index')->name('index');
        Route::get('/banco-digital/{customer}', 'show')->name('show');
        Route::patch('/banco-digital/{customer}/editar-webhook', 'updateWebhook')->name('updateWebhook');
        Route::patch('/banco-digital/{customer}/editar-lambda', 'updateLambda')->name('updateLambda');
        Route::post('/banco-digital/{customer}/habilitar-ip-debug', 'enableIpDebug')->name('enableIpDebug');
        Route::post('/banco-digital/habilitar-ip-debugs', 'enableIpDebugs')->name('enableIpDebugs');
        Route::post('/banco-digital/desabilitar-ip-debugs', 'disableDebugs')->name('disableDebugs');
        Route::post('/banco-digital/{customer}/habilitar-debug', 'enableDebug')->name('enableDebug');
        Route::post('/banco-digital/{customer}/desabilitar-debug', 'disableDebug')->name('disableDebug');
        Route::post('/banco-digital/{customer}/desabilitar-van', 'disableVan')->name('disableVan');
        Route::post('/banco-digital/desabilitar-vans', 'disableVans')->name('disableVans');
    });

    Route::controller(CustomerController::class)->name('customers.')->group(function () {
        Route::get('/clientes', 'index')->name('index');
        Route::get('/clientes/{customer}', 'show')->name('show')->whereNumber('customer');
        Route::get('/clientes/novo', 'create')->name('create');
        Route::post('/clientes/novo', 'store')->name('store');
        Route::post('/clientes/{customer}/projeto', 'attachProject')->name('attachProject')->whereNumber('customer');
        Route::post('/clientes/{customer}/mensagem', 'storeMessage')->name('messages.store')->whereNumber('customer');
    });

    Route::controller(MessageController::class)->name('messages.')->group(function () {
        Route::delete('/mensagems/{message}', 'destroy')->name('destroy');
    });

    Route::controller(LogController::class)->name('logs.')->group(function () {
        Route::get('/logs', 'index')->name('index');
        Route::get('/logs/{log}', 'show')->name('show');
    });

    Route::controller(WhitelistController::class)->name('whitelist.')->group(function () {
        Route::post('/whitelist', 'store')->name('store');
        Route::delete('/whitelist/{ip}', 'destroy')->name('destroy');
    });

    Route::get('/storage/{filePath?}', PrivateFileController::class)->where('filePath', '.*')->name('storage');
});
