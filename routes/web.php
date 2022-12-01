<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\FinancialAccountController;
use App\Http\Controllers\Web\FinancialTransactionController;

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

Route::group([
    'prefix' => 'login'
], function () {
    Route::get('/', [AuthController::class, 'login'])->name('web.auth.view');
    Route::post('/', [AuthController::class, 'authenticate'])->name('web.auth.authenticate');
});

Route::group([
    'prefix' => 'logout'
], function () {
    Route::get('/', [AuthController::class, 'logout'])->name('web.auth.logout');
});

Route::group([
    'prefix' => 'cadastro'
], function () {
    Route::get('/', [RegisterController::class, 'view'])->name('web.register.view');
    Route::post('/', [RegisterController::class, 'register'])->name('web.register.register');
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/', [DashboardController::class, 'home'])->name('web.home');
    Route::group([
        'prefix' => 'contas'
    ], function () {
        Route::get('/', [FinancialAccountController::class, 'listView'])->name('web.financial-account.listView');
        Route::get('/adicionar', [FinancialAccountController::class, 'add'])->name('web.financial-account.add');
        Route::post('/', [FinancialAccountController::class, 'save'])->name('web.financial-account.save');
        Route::get('/editar/{financialAccount}', [FinancialAccountController::class, 'edit'])->name('web.financial-account.edit');
        Route::get('/favoritar/{financialAccount}', [FinancialAccountController::class, 'setAsDefault'])->name('web.financial-account.setAsDefault');
        Route::get('/remover/{financialAccount}', [FinancialAccountController::class, 'remove'])->name('web.financial-account.remove');
    });
    Route::group([
        'prefix' => 'transacoes'
    ], function () {
        Route::get('/', [FinancialTransactionController::class, 'listView'])->name('web.financial-transaction.listView');
        Route::get('/adicionar', [FinancialTransactionController::class, 'add'])->name('web.financial-transaction.add');
        Route::post('/', [FinancialTransactionController::class, 'save'])->name('web.financial-transaction.save');
        Route::get('/remover/{financialTransaction}', [FinancialTransactionController::class, 'remove'])->name('web.financial-transaction.remove');
    });
});