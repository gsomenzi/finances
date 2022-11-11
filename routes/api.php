<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FinancialAccountController;
use App\Http\Controllers\Api\FinancialTransactionController;
use App\Http\Controllers\Api\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/', [AuthController::class, 'authenticate'])->name('api.auth.authenticate');
});

Route::group([
    'prefix' => 'register'
], function () {
    Route::post('/', [RegisterController::class, 'register'])->name('api.auth.register');
});

Route::group([
    'middleware' => 'auth:sanctum'
], function () {

    Route::group([
        'prefix' => 'categories'
    ], function () {
        Route::get('/', [CategoryController::class, 'getAll'])->name('api.categories.getAll');
        Route::post('/', [CategoryController::class, 'create'])->name('api.categories.create');
        Route::get('/{category}', [CategoryController::class, 'getOne'])->name('api.categories.getOne');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('api.categories.update');
        Route::delete('/{category}', [CategoryController::class, 'delete'])->name('api.categories.delete');
    });

    Route::group([
        'prefix' => 'financial-accounts'
    ], function () {
        Route::get('/', [FinancialAccountController::class, 'getAll'])->name('api.financialAccounts.getAll');
        Route::post('/', [FinancialAccountController::class, 'create'])->name('api.financialAccounts.create');
        Route::get('/{financialAccount}', [FinancialAccountController::class, 'getOne'])->name('api.financialAccounts.getOne');
        Route::put('/{financialAccount}', [FinancialAccountController::class, 'update'])->name('api.financialAccounts.update');
        Route::delete('/{financialAccount}', [FinancialAccountController::class, 'delete'])->name('api.financialAccounts.delete');
    });

    Route::group([
        'prefix' => 'financial-transactions'
    ], function () {
        Route::get('/', [FinancialTransactionController::class, 'getAll'])->name('api.financialTransactions.getAll');
        Route::post('/', [FinancialTransactionController::class, 'create'])->name('api.financialTransactions.create');
        Route::get('/{financialTransaction}', [FinancialTransactionController::class, 'getOne'])->name('api.financialTransactions.getOne');
        Route::put('/{financialTransaction}', [FinancialTransactionController::class, 'update'])->name('api.financialTransactions.update');
        Route::delete('/{financialTransaction}', [FinancialTransactionController::class, 'delete'])->name('api.financialTransactions.delete');
    });

    Route::group([
        'prefix' => 'tags'
    ], function () {
        Route::get('/', [TagController::class, 'getAll'])->name('api.tags.getAll');
        Route::post('/', [TagController::class, 'create'])->name('api.tags.create');
        Route::get('/{tag}', [TagController::class, 'getOne'])->name('api.tags.getOne');
        Route::put('/{tag}', [TagController::class, 'update'])->name('api.tags.update');
        Route::delete('/{tag}', [TagController::class, 'delete'])->name('api.tags.delete');
    });
});
