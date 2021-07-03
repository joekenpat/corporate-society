<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestmentPackageController;
use App\Http\Controllers\LgaController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalBankController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });

Route::get('state/list', [StateController::class, 'index']);
Route::get('lga/list', [LgaController::class, 'index']);
Route::post('/verify/bank-account', [WithdrawalBankController::class, 'verifyAccountDetails']);

Route::group(['prefix' => 'admin'], function () {
  Route::post('login', [AdminController::class, 'login_admin']);
  Route::group(['middleware' => ['auth:sanctum', 'sanctum.abilities:super-admin,sub-admin']], function () {
    Route::get('profile', [AdminController::class, 'profile']);
    Route::get('is-super-admin', [AdminController::class, 'isSuperAdmin']);
    Route::get('password-change', [AdminController::class, 'update_password']);
    Route::get('table-stats', [AdminController::class, 'adminDashboardStatus']);

    Route::group(['prefix' => 'deposit'], function () {
      Route::get('list/{status}', [DepositController::class, 'adminListDeposit'])->where(['status' => 'pending|completed|failed']);
    });

    Route::group(['prefix' => 'investment'], function () {
      Route::get('list/{status}', [InvestmentController::class, 'adminListInvestment'])->where(['status' => 'active|completed']);
    });

    Route::group(['prefix' => 'investment-package'], function () {
      Route::get('list', [InvestmentPackageController::class, 'adminListInvestmentPackage']);
      Route::post('new', [InvestmentPackageController::class, 'adminStoreInvestmentPackage']);
      Route::post('update', [InvestmentPackageController::class, 'adminUpdateInvestmentPackage']);
    });

    Route::group(['prefix' => 'withdrawal'], function () {
      Route::get('list/{status}', [WithdrawalController::class, 'adminListWithdrawal'])->where(['status' => 'pending|failed|completed']);
      Route::post('update', [WithdrawalController::class, 'adminUpdateWithdrawalRequest']);
    });

    Route::group(['prefix' => 'member'], function () {
      Route::post('new', [UserController::class, 'adminStoreNewMembershipDetails']);
      Route::post('update', [UserController::class, 'adminUpdateMembershipApplication']);
      Route::get('list/{status}', [UserController::class, 'adminListMember'])->where(['status' => 'pending|declined|approved']);
    });

    Route::group(['prefix' => 'account'], function () {
      Route::get('list', [AdminController::class, 'adminListSubAdmin']);
      Route::post('new', [AdminController::class, 'adminStoreNewAdminDetails']);
      Route::get('/{admin_id}/set-status/{status}', [AdminController::class, 'adminToggleSubAdminStatus'])
        ->withoutMiddleware(['sanctum.abilities:sub-admin']);
    });
  });
});
