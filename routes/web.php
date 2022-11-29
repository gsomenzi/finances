<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
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
    'prefix' => 'auth'
], function () {
    Route::get('/', [AuthController::class, 'login'])->name('web.auth.login');
    Route::post('/', [AuthController::class, 'authenticate'])->name('web.auth.authenticate');
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/', [DashboardController::class, 'home'])->name('web.home');
    Route::group([
        'prefix' => 'contas'
    ], function () {
        Route::get('/', [FinancialAccountController::class, 'list'])->name('web.financial-account.list');
    });
    Route::group([
        'prefix' => 'transacoes'
    ], function () {
        Route::get('/', [FinancialTransactionController::class, 'list'])->name('web.financial-transaction.list');
    });
});