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
   * Create user withdrawal
   *
   * @return \Illuminate\Http\Response
   */
  public function userCreateWithdrawal()
  {
    $maxAmount = auth()->user()->available_balance;
    return view('withdrawal_create', ['maxAmount' => $maxAmount]);
  }


  /**
   * Display a listing of user withdrawals
   *
   * @return \Illuminate\Http\Response
   */
  public function userListWithdrawal()
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $withdrawals = Withdrawal::select([
      'code',
      'amount',
      'status',
      'created_at',
      'completed_at',
    ])->whereUserId($user->id)
      ->paginate(10);
    return view('withdrawal_history', [
      'withdrawals' => $withdrawals
    ]);
  }

  /**
   * Display a listing of withdrawals for admin
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListWithdrawal($status)
  {
    $withdrawals = Withdrawal::select([
      'code',
      'amount',
      'status',
      'created_at',
      "user_id",
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,profileImage'])
      ->where('status', $status)
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
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $minAmount = 10000;
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
    return redirect()->route('withdrawal_history');
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
      'status' => 'required|alpha|in:failed,completed',
    ]);

    $updateableWithdrawal = Withdrawal::whereCode($request->withdrawal_code)
      ->firstOrFail();
    $updateableAttributes = $updateableWithdrawal->getFillable();

    if ($updateableWithdrawal != 'completed') {
      if ($request->status == 'completed') {
        $updateableWithdrawal->status = 'completed';
      } elseif ($request->status == 'failed') {
        $updateableWithdrawal->status = 'failed';
        $investor = User::whereId($updateableWithdrawal->user_id)->firstOrFail();
        $investor->available_balance -= ($updateableWithdrawal->amount);
        $investor->update();
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
}
