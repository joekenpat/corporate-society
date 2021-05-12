<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Investment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepositController extends Controller
{
  /**
   * Display a listing of user deposits
   *
   * @return \Illuminate\Http\Response
   */
  public function userListDeposit()
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $deposits = Investment::select([
      'code',
      'amount',
      'status',
      'created_at',
      'completed_at',
    ])->whereUserId($user->id)
      ->paginate(10);
    return view('deposit_history', [
      'deposits' => $deposits
    ]);
  }


  /**
   * Display a listing of deposits for admin
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListDeposit()
  {
    $deposits = Investment::select([
      'code',
      'amount',
      'status',
      'created_at',
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,avatar'])
      ->paginate(10);
    $response['status'] = "success";
    $response['deposits'] = $deposits;
    return response()->json($response, Response::HTTP_OK);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Deposit  $deposit
   * @return \Illuminate\Http\Response
   */
  public function show(Deposit $deposit)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Deposit  $deposit
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Deposit $deposit)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Deposit  $deposit
   * @return \Illuminate\Http\Response
   */
  public function destroy(Deposit $deposit)
  {
    //
  }
}
