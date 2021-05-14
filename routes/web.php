<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RoutweServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});


Route::group(['middleware' => ['auth']], function () {

  Route::get('/dashboard', [UserController::class, 'showUserDashboard'])
    ->name('dashboard');

  Route::group(['prefix' => 'profile','middleware'=>['hasPaidMembershipFee']], function () {
    Route::get('general', [UserController::class, 'showProfileSettingForm'])
      ->name('profile_general');

    Route::post('update/withdrawal-bank', [UserController::class, 'userUpdateWithdrawalBank'])
      ->name('update_profile_withdrawal_bank');
  });


  Route::group(['prefix' => 'membership'], function () {
    Route::get('/detail', [UserController::class, 'showMembershipApplicationForm'])
      ->name('membership_detail')->middleware('hasPaidMembershipFee');

    Route::get('/pay-fee', [UserController::class, 'userPayMembershipFormFee'])
      ->name('initiate_membership_fee');

    Route::get('/validate-payment', [UserController::class, 'handleMembershipFeePaymentGatewayCallback'])
      ->name('membership_fee_validate_payment');

    Route::get('/payment-failed', [UserController::class, 'handleMembershipFeePaymentFailed'])
      ->name('membership_fee_payment_failed');
  });


  Route::group(['prefix' => 'withdrawal','middleware'=>['hasPaidMembershipFee']], function () {
    Route::get('/create', [WithdrawalController::class, 'userCreateWithdrawal'])
      ->name('withdrawal_create');
    Route::post('/initiate', [WithdrawalController::class, 'userStoreWithdrawal'])
      ->name('withdrawal_initiate');
    Route::get('/history', [WithdrawalController::class, 'userListWithdrawal'])
      ->name('withdrawal_history');
  });

  Route::group(['prefix' => 'investment','middleware'=>['hasPaidMembershipFee']], function () {
    Route::get('/create', [InvestmentController::class, 'userCreateInvestment'])
      ->name('investment_create');
    Route::post('/initiate', [InvestmentController::class, 'userStoreInvestment'])
      ->name('investment_initiate');
    Route::get('/history', [InvestmentController::class, 'userListInvestment'])
      ->name('investment_history');
  });

  Route::group(['prefix' => 'deposit','middleware'=>['hasPaidMembershipFee']], function () {
    Route::get('/create', [DepositController::class, 'userCreateDeposit'])
      ->name('deposit_create');
    Route::post('/initiate', [DepositController::class, 'userStoreDeposit'])
      ->name('deposit_initiate');
    Route::get('/validate-payment', [DepositController::class, 'handleDepositPaymentGatewayCallback'])
      ->name('deposit_validate_payment');
    Route::get('/mark_failed_deposit/{deposit_code}', [DepositController::class, 'markPendingDepositAsFailed'])
      ->name('mark_pending_deposit_as_failed')->whereAlphaNumeric('deposit_code');
    Route::get('/history', [DepositController::class, 'userListDeposit'])
      ->name('deposit_history');
  });
});


require __DIR__ . '/auth.php';
