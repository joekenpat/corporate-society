<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepositController;
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

Route::group(['prefix' => 'admin'], function () {
  Route::post('login', [AdminController::class, 'login_admin']);
  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('profile', [AdminController::class, 'profile']);
    Route::group(['prefix' => 'deposit'], function () {
      Route::get('{status}', [DepositController::class, 'adminListDeposit'])->where(['status' => 'all|pending|completed|failed']);
    });
  });
});
