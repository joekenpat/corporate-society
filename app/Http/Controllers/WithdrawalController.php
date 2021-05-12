<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WithdrawalController extends Controller
{
  /**
   * Display a listing of user withdrawals
   *
   * @return \Illuminate\Http\Response
   */
  public function userListWithdrawal()
  {
    $user = User::whereId(auth()->user())->firstOrFail();
    $withdrawals = Investment::select([
      'code',
      'amount',
      'status',
      'created_at',
      'completed_at',
    ])->whereUserId($user->id)
      ->paginate(10);
    $response['status'] = "success";
    $response['withdrawals'] = $withdrawals;
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Display a listing of withdrawals for admin
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListWithdrawal()
  {
    $withdrawals = Investment::select([
      'code',
      'amount',
      'status',
      'created_at',
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,avatar'])
      ->paginate(10);
    $response['status'] = "success";
    $response['withdrawals'] = $withdrawals;
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Store a new withdrawal resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function userStoreWithdrawal(Request $request)
  {
    $user = User::whereId(auth()->user())->firstOrFail();
    $minAmount = 100000;
    $maxAmount = $user->available_balance;
    $this->validate($request, [
      'amount' => "nullable|integer|min:{$minAmount}|max:{$maxAmount}",
    ]);

    Withdrawal::create([
      'user_id' => $user->id,
      'amount' => $request->amount,
      'status' => 'pending',
      'completed_at' => null,
    ]);
    $user->available_balance -= $request->amount;
    $user->update();
    $response['status'] = "success";
    $response['message'] = "Your Withdrawal of #{$request->amount} has been placed.";
    return response()->json($response, Response::HTTP_OK);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Withdrawal  $withdrawal
   * @return \Illuminate\Http\Response
   */
  public function adminUpdateWithdrawalRequest(Request $request, Withdrawal $withdrawal)
  {
    $this->validate($request, [
      'withdrawal_code' => 'required|alpha_num|exists:withdrawals,code',
      'status' => 'required|alpha|in:cancelled,approved',
    ]);

    $updateableWithdrawal = Withdrawal::whereCode($request->withdrawal_code)
      ->firstOrFail();
    $updateableAttributes = $updateableWithdrawal->getFillable();

    if ($updateableWithdrawal != 'approved'){
      if($request->status == 'approved') {
      $updateableWithdrawal->status = 'approved';
    }elseif($request->status == 'cancelled') {
      $updateableWithdrawal->status = 'cancelled';
    }

    if ($updateableWithdrawal->isDirty($updateableAttributes)) {
      $updateableWithdrawal->update();
      $response['status'] = "success";
      $response['message'] = "Withdrawal Request was updated Successfully!";
      return response()->json($response, Response::HTTP_OK);
    } else {
      $response['status'] = "success";
      $response['message'] = "No changes where made!";
      return response()->json($response, Response::HTTP_OK);
    }
  }
}
