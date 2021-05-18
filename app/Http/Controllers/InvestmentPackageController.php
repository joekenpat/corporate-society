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
      'roi_percent'
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
      'min_amount' => 'required|integer|min:50000|max:2000000',
      'max_amount' => 'required|integer|min:50000|max:2000000',
      'duration' => 'required|integer|between:1,36',
      'roi_percent' => 'required|numeric|between:1,99',
    ]);

    $newInvestmentPackage = new InvestmentPackage([
      'name' => $request->name,
      'min_amount' => $request->min_amount,
      'max_amount' => $request->max_amount,
      'duration' => $request->duration,
      'roi_percent' => $request->roi_percent,
      'active' => true
    ]);
    $newInvestmentPackage->save();
    $response['status'] = "success";
    $response['message'] = "Investment Package Created Successfully!";
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
      'name' => 'sometimes|nullable|string|between:5,200',
      'min_amount' => 'sometimes|nullable|integer|min:50000|max:2000000',
      'max_amount' => 'sometimes|nullable|integer|min:50000|max:2000000',
      'duration' => 'sometimes|nullable|integer|between:1,36',
      'roi_percent' => 'sometimes|nullable|numeric|between:1,99',
      'active' => 'sometimes|in:true,false,1,0',
    ]);

    $updateableInvestmentPackage = InvestmentPackage::whereId($request->investment_package_id)->firstOrFail();
    $updateableAttributes = $updateableInvestmentPackage->getFillable();

    foreach ($updateableAttributes as $attribute) {
      if ($request->has($attribute) && $request->{$attribute} != (null || "")) {
        if ($attribute == 'active') {
          $updateableInvestmentPackage->active = filter_var($request->active, FILTER_VALIDATE_BOOL);
        } else {
          $updateableInvestmentPackage->{$attribute} = $request->{$attribute};
        }
      }
    }

    if ($updateableInvestmentPackage->isDirty($updateableAttributes)) {
      $updateableInvestmentPackage->update();
      $response['status'] = "success";
      $response['message'] = "Investment Package was updated Successfully!";
      return response()->json($response, Response::HTTP_OK);
    } else {
      $response['status'] = "success";
      $response['message'] = "No changes where made!";
      return response()->json($response, Response::HTTP_OK);
    }
  }
}
