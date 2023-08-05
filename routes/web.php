<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TestController;

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


Route::middleware('guest')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/', function () {
        return to_route('dashboard.index');
    });
});

Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::resource('transaction', TransactionController::class);
    Route::post('transaction/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transaction.cancel');
    Route::post('transaction/{transaction}/withdrawal', [TransactionController::class, 'withdrawal'])->name('transaction.withdrawal');
    Route::get('transaction/{transaction}/print', [TransactionController::class, 'print'])->name('transaction.print');

    Route::resource('user', UserController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('/dashboard/transactionStats', [DashboardController::class, 'getTransactionStats'])->name('dashboard.transactionStats');
    Route::get('/dashboard/userStats', [DashboardController::class, 'getUserStats'])->name('dashboard.userStats');
    Route::get('/dashboard/combinedStats', [DashboardController::class, 'getCombinedStats'])->name('dashboard.combinedStats');


});
