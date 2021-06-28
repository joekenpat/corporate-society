<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\InvestmentPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvestmentController extends Controller
{

  /**
   * Create user investments
   *
   * @return \Illuminate\Http\Response
   */
  public function userCreateInvestment()
  {
    $maxAmount = auth()->user()->available_balance;
    $investmentPackages = InvestmentPackage::select([
      'id', 'name', 'min_amount', 'max_amount', 'duration', 'roi_percent'
    ])->whereActive(true)->get();
    $minAmount = $investmentPackages->min('min_amount');
    return view('investment_create', [
      'investmentPackages' => $investmentPackages,
      'maxAmount' => $maxAmount,
      'minAmount'=>$minAmount,
    ]);
  }


  /**
   * Display a listing of user investment.
   *
   * @return \Illuminate\Http\Response
   */
  public function userListInvestment()
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $investments = Investment::select([
      'code',
      'package_name',
      'amount',
      'roi',
      'created_at',
      'ends_at',
      'completed_at',
    ])->whereUserId($user->id)
      ->latest()
      ->paginate(10);
    $response['status'] = "success";
    $response['investments'] = $investments;
    return view('investment_history', [
      'investments' => $investments
    ]);
  }

  /**
   * Display a listing of investment for admin.
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListInvestment($status)
  {
    $packages = Investment::select([
      'code',
      'package_name',
      'amount',
      'roi',
      'created_at',
      'user_id',
      'ends_at',
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,profile_image'])
      ->when($status, function ($query) use ($status) {
        if ($status == 'completed') {
          return $query->where('completed_at', '<>', null);
        } else {
          return $query->where('completed_at', null);
        }
      })
      ->latest()
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
    $maxAmount = auth()->user()->available_balance;
    $this->validate($request, [
      'investment_package_id' => 'required|integer|exists:investment_packages,id',
      'amount' => 'nullable|integer|min:50000|max:' . $maxAmount,
    ]);

    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $investmentPackage = InvestmentPackage::whereId($request->investment_package_id)->firstOrFail();
    Investment::create([
      'user_id' => $user->id,
      'package_name' => $investmentPackage->name,
      'amount' => $request->amount,
      'roi' => $request->amount * ($investmentPackage->roi_percent/100),
      'ends_at' => now()->addMonths($investmentPackage->duration),
    ]);
    $user->available_balance -= $request->amount;
    $user->investment_balance += $request->amount;
    $user->update();
    $response['status'] = "success";
    $response['message'] = "Your investment of ₦{$request->amount} has been placed in {$investmentPackage->name}";
    return redirect()->route('investment_history')->with($response['status'], $response['message']);
  }
}
