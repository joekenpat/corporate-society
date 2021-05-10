<?php

namespace App\Http\Controllers;

use App\Models\InvestmentPackage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvestmentPackageController extends Controller
{
  /**
   * Display a listing of investment packages for users.
   *
   * @return \Illuminate\Http\Response
   */
  public function userListInvestmentPackage()
  {
    $packages = InvestmentPackage::select([
      'id',
      'name',
      'min_amount',
      'max_amount',
      'duration',
    ])
      ->whereActive(true)
      ->get();
    $response['status'] = "success";
    $response['investment_packages'] = $packages;
    return response()->json($response, Response::HTTP_OK);
  }


  /**
   * Display a listing of investment packages for admin.
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListInvestmentPackage()
  {
    $packages = InvestmentPackage::all();
    $response['status'] = "success";
    $response['investment_packages'] = $packages;
    return response()->json($response, Response::HTTP_OK);
  }



  /**
   * Store a newly created investment packages in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function adminStoreInvestmentPackage(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string|between:5,200',
      'min_amount' => 'required|integer|min:100000|max:200000',
      'max_amount' => 'required|integer|min:100000|max:200000',
      'duration' => 'required|integer|between:7,360'
    ]);

    InvestmentPackage::create([
      'name' => $request->name,
      'min_amount' => $request->min_amount,
      'max_amount' => $request->max_amount,
      'duration' => $request->duration,
      'active' => true
    ]);
    $response['status'] = "success";
    $response['message'] = "Invesment Package Created Successfully!";
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function adminUpdateInvestmentPackage(Request $request)
  {
    $this->validate($request, [
      'investment_package_id' => 'required|integer|exists:investment_packages,id',
      'name' => 'required|string|between:5,200',
      'min_amount' => 'nullable|integer|min:100000|max:200000',
      'max_amount' => 'nullable|integer|min:100000|max:200000',
      'duration' => 'nullable|integer|between:7,360',
      'active' => 'required|boolean',
    ]);

    $updateableInvestmentPackage = InvestmentPackage::whereId($request->investment_package_id)->firstOrFail();
    $updateableAttributes = $updateableInvestmentPackage->getFillable();

    foreach ($updateableAttributes as $attribute) {
      if ($request->has($attribute) && $request->{$attribute} != (null || "")) {
        $updateableInvestmentPackage->{$attribute} = $request->{$attribute};
      }
    }

    if ($updateableInvestmentPackage->isDirty($updateableAttributes)) {
      $updateableInvestmentPackage->update();
      $response['status'] = "success";
      $response['message'] = "Invesment Package was updated Successfully!";
      return response()->json($response, Response::HTTP_OK);
    } else {
      $response['status'] = "success";
      $response['message'] = "No changes where made!";
      return response()->json($response, Response::HTTP_OK);
    }
  }
}
