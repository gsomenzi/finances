<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;

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
    Route::get('/', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('/', [AuthController::class, 'authenticate'])->name('api.auth.authenticate');
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/', [HomeController::class, 'home'])->name('api.home');
});