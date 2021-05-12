<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['auth']], function () {

  Route::get('/dashboard', [UserController::class, 'showUserDashboard'])
    ->name('dashboard');

  Route::group(['prefix' => 'withdrawal'], function () {
    Route::get('/create', [WithdrawalController::class, 'userListWithdrawal'])
      ->name('withdrawal_create');
    Route::get('/history', [WithdrawalController::class, 'userListWithdrawal'])
      ->name('withdrawal_history');
  });

  Route::group(['prefix' => 'deposit'], function () {
    Route::get('/create', [DepositController::class, 'userListDeposit'])
      ->name('deposit_create');
    Route::get('/history', [DepositController::class, 'userListDeposit'])
      ->name('deposit_history');
  });
});


require __DIR__ . '/auth.php';
