<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalBankController;
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
})->name('welcome');

Route::get('/about', function () {
  return view('about');
})->name('about');

Route::get('/operating-policy', function () {
  return view('operating_policy');
})->name('operating_policy');

Route::match(['POST', 'GET'], '/flutterwave-payout/callback/{code}')->name('withdrawal_payout_callback')->whereAlphaNumeric(['code']);

Route::group(['middleware' => ['auth']], function () {

  Route::get('/dashboard', [UserController::class, 'showUserDashboard'])
    ->name('dashboard');

  Route::group(['prefix' => 'profile', 'middleware' => ['hasPaidMembershipFee', 'hasMembershipApproved']], function () {
    Route::get('general', [UserController::class, 'showProfileSettingForm'])
      ->name('profile_general');

    Route::post('general/update', [UserController::class, 'userUpdateProfileDetails'])
      ->name('update_profile_general');

    Route::post('update/withdrawal-bank', [WithdrawalBankController::class, 'userStoreBankDetails'])
      ->name('update_profile_withdrawal_bank');
  });


  Route::group(['prefix' => 'membership'], function () {
    Route::get('/detail', [UserController::class, 'showMembershipApplicationForm'])
      ->name('membership_detail');

    Route::post('/update', [UserController::class, 'userUpdateMembershipDetails'])
      ->name('update_membership_details');

    Route::get('/pay-fee/paystack', [UserController::class, 'userPayMembershipFormFeeViaPaystack'])
      ->name('initiate_membership_fee_paystack');

    Route::get('/pay-fee/flutterwave', [UserController::class, 'userPayMembershipFormFeeViaFlutterwave'])
      ->name('initiate_membership_fee_flutterwave');

    Route::get('/validate-payment/paystack', [UserController::class, 'handleMembershipFeePaystackPaymentGatewayCallback'])
      ->name('membership_fee_validate_payment_paystack');

    Route::get('/validate-payment/flutterwave', [UserController::class, 'handleMembershipFeeFlutterwavePaymentGatewayCallback'])
      ->name('membership_fee_validate_payment_flutterwave');

    Route::get('/payment-failed', [UserController::class, 'handleMembershipFeePaymentFailed'])
      ->name('membership_fee_payment_failed');
  });


  Route::group(['prefix' => 'withdrawal', 'middleware' => ['hasPaidMembershipFee', 'hasMembershipApproved']], function () {
    Route::get('/create', [WithdrawalController::class, 'userCreateWithdrawal'])
      ->name('withdrawal_create');
    Route::post('/initiate', [WithdrawalController::class, 'userStoreWithdrawal'])
      ->name('withdrawal_initiate');
    Route::get('/history', [WithdrawalController::class, 'userListWithdrawal'])
      ->name('withdrawal_history');
  });

  Route::group(['prefix' => 'investment', 'middleware' => ['hasPaidMembershipFee', 'hasMembershipApproved']], function () {
    Route::get('/create', [InvestmentController::class, 'userCreateInvestment'])
      ->name('investment_create');
    Route::post('/initiate', [InvestmentController::class, 'userStoreInvestment'])
      ->name('investment_initiate');
    Route::get('/history', [InvestmentController::class, 'userListInvestment'])
      ->name('investment_history');
  });

  Route::group(['prefix' => 'deposit', 'middleware' => ['hasPaidMembershipFee', 'hasMembershipApproved']], function () {
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
