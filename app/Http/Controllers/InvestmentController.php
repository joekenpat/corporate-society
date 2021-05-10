<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvestmentController extends Controller
{
  /**
   * Display a listing of user investment.
   *
   * @return \Illuminate\Http\Response
   */
  public function userListInvestment()
  {
    $packages = Investment::select([
      'code',
      'package_name',
      'amount',
      'roi',
      'completed_at',
    ])->whereUserId(auth()->user()->id)->paginate(10);
    $response['status'] = "success";
    $response['investments'] = $packages;
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Display a listing of investment for admin.
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListInvestment()
  {
    $packages = Investment::select([
      'code',
      'package_name',
      'amount',
      'roi',
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,avatar'])
      ->whereUserId(auth()->user()->id)
      ->paginate(10);
    $response['status'] = "success";
    $response['investments'] = $packages;
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function userStoreInvestment(Request $request)
  {
    $this->validate($request, [
      'investment_package_id' => 'required|integer|exists:investment_packages,id',
      'amount' => 'nullable|integer|min:100000|max:200000',
      'duration' => 'nullable|integer|between:7,360',
    ]);

    
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Investment  $investment
   * @return \Illuminate\Http\Response
   */
  public function show(Investment $investment)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Investment  $investment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Investment $investment)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Investment  $investment
   * @return \Illuminate\Http\Response
   */
  public function destroy(Investment $investment)
  {
    //
  }
}
