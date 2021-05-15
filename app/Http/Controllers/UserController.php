<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Lga;
use App\Models\State;
use App\Models\User;
use App\Models\WithdrawalBank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

  /**
   * Display a listing of investment for admin.
   *
   * @return \Illuminate\Http\Response
   */
  public function adminListMember($status)
  {
    $members = User::select([
      "code",
      "available_balance",
      "investment_balance",
      'first_name',
      'last_name',
      'middle_name',
      'gender',
      'phone',
      'marital_status',
      'disability',
      'dob',
      'address1',
      'address2',
      'state_id',
      'lga_id',
      'employment_status',
      'identification_type',
      'profile_image',
      'identification_image',
      'email',
      'status',
    ])->when($status, function ($query) use ($status) {
      if ($status == 'pending') {
        return $query->where('status', 'paid');
      } else {
        return $query->where('status', $status);
      }
    })
      ->latest()
      ->paginate(10);
    $response['status'] = "success";
    $response['members'] = $members;
    return response()->json($response, Response::HTTP_OK);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function adminUpdateMembershipApplication(Request $request)
  {
    $this->validate($request, [
      'user_code' => 'required|alpha_num|exists:users,code',
      'status' => 'required|alpha|in:declined,approved',
    ]);

    $updateableUser = User::whereCode($request->withdrawal_code)
      ->firstOrFail();
    $updateableAttributes = $updateableUser->getFillable();

    if ($request->status == 'approved') {
      $updateableUser->status = 'approved';
    } elseif ($request->status == 'declined') {
      $updateableUser->status = 'declined';
    }

    if ($updateableUser->isDirty($updateableAttributes)) {
      $updateableUser->update();
      $response['status'] = "success";
      $response['message'] = "User {$request->status} Successfully!";
      return response()->json($response, Response::HTTP_OK);
    } else {
      $response['status'] = "success";
      $response['message'] = "No changes where made!";
      return response()->json($response, Response::HTTP_OK);
    }
  }

  public function userPayMembershipFormFee()
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $paystack = Http::withToken(config('paystack.secretKey'))
      ->post('https://api.paystack.co/transaction/initialize', [
        'email' => $user->email,
        'amount' => 2000 * 100,
        'quantity' => 1,
        'currency' => 'NGN',
        'channels' => ['card'],
        // 'reference' => Paystack::getTrnxref(),
        'callback_url' => route('membership_fee_validate_payment'),
        'metadata' => [
          'cancel_action' => route('membership_fee_payment_failed'),
        ]
      ])->json();
    return redirect()->away($paystack['data']['authorization_url']);
  }


  /**
   * Obtain Paystack payment information
   * @return void
   */
  public function handleMembershipFeePaymentGatewayCallback(Request $request)
  {
    $paystack_client = Http::withToken(config('paystack.secretKey'))->get("https://api.paystack.co/transaction/verify/" . $request->query('trxref'));
    $paymentDetails = $paystack_client->json();
    $valid_user = User::where('email', $paymentDetails['data']['customer']['email'])->firstOrFail();
    if ($paymentDetails['data']['status'] === "success") {
      if (($paymentDetails['data']['amount'] / 100) == 2000) {
        $valid_user->status = 'paid';
        $valid_user->update();
      }
      $response['status'] = 'success';
      $response['message'] = "Your membership fee payment was successfull.";
      return redirect()->route('membership_detail')->with($response['status'], $response['message']);
    } elseif ($paymentDetails['data']['status'] === "failed") {
      $response['status'] = 'error';
      $response['message'] = "Your membership fee payment was not successfull.";
      return redirect()->route('dashboard')->with($response['status'], $response['message']);
    }
  }

  public function handleMembershipFeePaymentFailed()
  {
    $response['status'] = 'error';
    $response['message'] = "Your membership fee payment was not successfull.";
    return redirect()->route('dashboard')->with($response['status'], $response['message']);
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
      'stateList' => $state,
      'lgaList' => $lga
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function showProfileSettingForm()
  {
    $user = auth()->user();
    $banks = Bank::all();
    $withdrawalBank = $user->withdrawalBank;
    return view('profile_setting', [
      'bankList' => $banks,
      'withdrawalBank' => $withdrawalBank
    ]);
  }

  public function userUpdateWithdrawalBank(Request $request)
  {
    $this->validate($request, [
      'bank_code' => 'sometimes|nullable|alpha_num|max:10|exists:banks,code',
      'account_name' => 'sometimes|nullable|string',
      'account_number' => 'sometimes|nullable|digits:10',
    ]);

    WithdrawalBank::updateOrCreate(
      ['user_id' => auth()->user()->id],
      [
        'bank_code' => $request->bank_code,
        'account_name' => $request->account_name,
        'account_number' => $request->account_number,
      ]
    );

    return redirect()->route('profile_general');
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
