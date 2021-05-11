<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\InvestmentPackage;
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
      'created_at',
      'completed_at',
    ])->whereUserId(auth()->user()->id)
      ->paginate(10);
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
      'created_at',
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,avatar'])
      ->paginate(10);
    $response['status'] = "success";
    $response['investments'] = $packages;
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Store a new investment resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function userStoreInvestment(Request $request)
  {
    $this->validate($request, [
      'investment_package_id' => 'required|integer|exists:investment_packages,id',
      'amount' => 'nullable|integer|min:100000|max:200000',
    ]);

    $investmentPackage = InvestmentPackage::whereId($request->investment_package_id)->firstOrFail();
    Investment::create([
      'user_id' => auth()->user()->id,
      'package_name' => $investmentPackage->name,
      'amount' => $request->amount,
      'roi' => $request->amount * $investmentPackage->roi_percent,
      'completed_at' => now()->addMonths($investmentPackage->duration),
    ]);
    $response['status'] = "success";
    $response['message'] = "Your investment of #{$request->amount} has been placed in {$investmentPackage->name}";
    return response()->json($response, Response::HTTP_OK);
  }
}
