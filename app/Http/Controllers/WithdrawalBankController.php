<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\WithdrawalBank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class WithdrawalBankController extends Controller
{
  /**
   * Display a listing of user investment.
   *
   * @return \Illuminate\Http\Response
   */
  public function useBankDetails()
  {
    $bankDetails = WithdrawalBank::select([
      'bank_code',
      'account_name',
      'account_number',
    ])->whereUserId(auth()->user()->id)->first();
    $response['status'] = "success";
    $response['bank_details'] = $bankDetails;
    return response()->json($response, Response::HTTP_OK);
  }

  public function verifyAccountDetails(Request $request)
  {
    $this->validate($request, [
      'bank' => 'required|string|exists:banks,code',
      'account_number' => "required|string|digits:10",
    ]);

    $flutterwave = Http::withToken(config('flutterwave.secretKey'))
      ->post('https://api.flutterwave.com/v3/accounts/resolve', [
        'account_number' => $request->account_number,
        'account_bank' => $request->bank,
      ])->json();
    return $flutterwave;
  }

  /**
   * Display a listing of investment for admin.
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListBankDetails()
  {
    $userBankDetails = WithdrawalBank::with(['user:id,code,first_name,last_name,email,avatar'])
      ->whereUserId(auth()->user()->id)
      ->paginate(10);
    $response['status'] = "success";
    $response['user_bank_details'] = $userBankDetails;
    return response()->json($response, Response::HTTP_OK);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function userStoreBankDetails(Request $request)
  {
    $this->validate($request, [
      'bank' => 'required|string|exists:banks,code',
      'account_number' => "required|digits:10",
    ]);

    $flutterwave = Http::withToken(config('flutterwave.secretKey'))
      ->post('https://api.flutterwave.com/v3/accounts/resolve', [
        'account_number' => $request->account_number,
        'account_bank' => $request->bank,
      ])->json();
    if ($flutterwave['status'] == 'success') {
      WithdrawalBank::updateOrCreate(
        [
          'user_id' => auth()->user()->id,
        ],
        [
          'bank_code' => $request->bank,
          'account_name' => $flutterwave['data']['account_name'],
          'account_number' => $request->account_number,
        ]
      );
      $response['status'] = "success";
      $response['message'] = "Bank Details Added Successfully!";
      return redirect()->route('profile_general')->with($response['status'], $response['message']);
    } else {
      throw ValidationException::withMessages(['account_number' => 'Account Number is invalid']);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function userUpdateBankDetails(Request $request)
  {
    $this->validate($request, [
      'bank_code' => 'sometimes|nullable|alpha|exists:banks,code',
      'account_name' => 'sometimes|nullable|string|between:5,200',
      'account_number' => "sometimes|nullable|numeric|size:10",
    ]);

    $updateableWithdrawalBank = WithdrawalBank::whereUserId(auth()->user()->id)->firstOrFail();
    $updateableAttributes = $updateableWithdrawalBank->getFillable();

    foreach ($updateableAttributes as $attribute) {
      if ($request->has($attribute) && $request->{$attribute} != (null || "")) {
        $updateableWithdrawalBank->{$attribute} = $request->{$attribute};
      }
    }

    if ($updateableWithdrawalBank->isDirty($updateableAttributes)) {
      $updateableWithdrawalBank->update();
      $response['status'] = "success";
      $response['message'] = "Bank Details was updated Successfully!";
      return response()->json($response, Response::HTTP_OK);
    } else {
      $response['status'] = "success";
      $response['message'] = "No changes where made!";
      return response()->json($response, Response::HTTP_OK);
    }
  }
}
