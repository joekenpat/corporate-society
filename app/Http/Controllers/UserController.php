<?php

namespace App\Http\Controllers;

use App\Models\Lga;
use App\Models\State;
use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function showMembershipApplicationForm()
  {
    $user = auth()->user();
    $state = State::all();
    $lga = Lga::all();
    return view('membership_form', [
      'userFirstName' => $user->first_name,
      'userLastName' => $user->last_name,
      'userMiddleName' => $user->middle_name,
      'userEmail' => $user->email,
      'userPhone' => $user->phone,
      'userDOB' => $user->dob->toDateString(),
      'userAddress1' => $user->address1,
      'userAddress2' => $user->address2,
      'stateList'=>$state,
      'lgaList'=>$lga
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }


  public function showUserDashboard()
  {
    $user = auth()->user();
    $available_balance = number_format($user->available_balance, 2);
    $investment_balance = number_format($user->investment_balance, 2);
    $investment_count = $user->activeInvestments()->count();
    return view('dashboard', [
      'user_available_balance' => $available_balance,
      'user_investment_balance' => $investment_balance,
      'user_active_investment_count' => $investment_count
    ]);
  }
}
