<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Lga;
use App\Models\State;
use App\Models\User;
use App\Models\WithdrawalBank;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
      "id",
      "code",
      "available_balance",
      "investment_balance",
      'first_name',
      'last_name',
      'middle_name',
      'gender',
      'phone',
      // 'marital_status',
      // 'disability',
      'dob',
      'address1',
      'address2',
      'state_code',
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

    $updateableUser = User::whereCode($request->user_code)
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

  public function userPayMembershipFormFeeViaFlutterwave()
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $data = [
      "tx_ref" => Str::uuid(),
      "amount" => 1500,
      "currency" => "NGN",
      "redirect_url" => route('membership_fee_validate_payment_flutterwave'),
      "payment_options" => ["card"],
      "meta" => [
        "user_code" => $user->code,
      ],
      "customer" => [
        "email" => $user->email,
        "phone_number" => $user->phone,
        "name" => $user->full_name,
      ],
      "customizations" => [
        "title" => "Registration Fee",
        "description" => "One time Member Registration Fee",
        "logo" => asset('images/misc/android-chrome-512x512.png'),
      ],
    ];

    $flutterwave = Http::withToken(config('flutterwave.secretKey'))
      ->post('https://api.flutterwave.com/v3/payments', $data)->json();
    return redirect()->away($flutterwave['data']['link']);
  }



  /**
   * Obtain Flutterwave payment information
   * @return void
   */
  public function handleMembershipFeeFlutterwavePaymentGatewayCallback(Request $request)
  {
    if ($request->has('transaction_id')) {
      $trnx_id = $request->transaction_id;
      $flutterwave_client = Http::withToken(config('flutterwave.secretKey'))
        ->acceptJson()->get("https://api.flutterwave.com/v3/transactions/{$trnx_id}/verify");
      $paymentDetails = $flutterwave_client->json();
      $valid_user = User::where('phone', $paymentDetails['data']['customer']['phone_number'])->firstOrFail();
      if ($paymentDetails['data']['status'] === "successful") {
        if ($paymentDetails['data']['charged_amount'] == 1500) {
          $valid_user->status = 'paid';
          $valid_user->update();
        }
        $response['status'] = 'success';
        $response['message'] = "Your membership fee payment was successfull.";
        return redirect()->route('membership_detail')->with($response['status'], $response['message']);
      } else {
        $response['status'] = 'error';
        $response['message'] = "Your membership fee payment was not successfull.";
        return redirect()->route('dashboard')->with($response['status'], $response['message']);
      }
    } else {
      $response['status'] = 'error';
      $response['message'] = "Your membership fee payment was not successfull.";
      return redirect()->route('dashboard')->with($response['status'], $response['message']);
    }
  }

  public function userPayMembershipFormFeeViaPaystack()
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $paystack = Http::withToken(config('paystack.secretKey'))
      ->post('https://api.paystack.co/transaction/initialize', [
        'email' => $user->email,
        'amount' => 1500 * 100,
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
  public function handleMembershipFeePaystackPaymentGatewayCallback(Request $request)
  {
    $paystack_client = Http::withToken(config('paystack.secretKey'))->get("https://api.paystack.co/transaction/verify/" . $request->query('trxref'));
    $paymentDetails = $paystack_client->json();
    $valid_user = User::where('email', $paymentDetails['data']['customer']['email'])->firstOrFail();
    if ($paymentDetails['data']['status'] === "success") {
      if (($paymentDetails['data']['amount'] / 100) == 1500) {
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
      'userCode' => $user->code,
      'userFirstName' => $user->first_name,
      'userLastName' => $user->last_name,
      'userMiddleName' => $user->middle_name,
      'userGender'=>$user->gender,
      'userEmail' => $user->email,
      'userPhone' => $user->phone,
      'userDOB' => $user->dob ? $user->dob->toDateString() : null,
      'userAddress1' => $user->address1,
      'userAddress2' => $user->address2,
      'userEmploymentType' => $user->employment_type,
      'userIdType' => $user->identification_type,
      'stateList' => $state,
      'lgaList' => $lga,
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
    $withdrawalBank = $user->withdrawalBank ?? new WithdrawalBank();
    return view('profile_setting', [
      'bankList' => $banks,
      'withdrawalBank' => $withdrawalBank
    ]);
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
      'user_active_investment_count' => $investment_count,
      'userCode' => $user->code,
    ]);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function userUpdateMembershipDetails(Request $request)
  {
    $updateableUser = auth()->user();
    if ($updateableUser->status != 'approved') {
      $validator_rules = [
        'first_name' => 'required|alpha|between:3,50',
        'last_name' => 'required|alpha|between:3,50',
        'gender' => 'required|alpha|in:M,F',
        'middle_name' => 'required|alpha|between:3,50',
        'phone' => 'required|regex:/\d{11}/|unique:users,phone,' . $updateableUser->id,
        'dob' => 'required|date|before_or_equal:2015-01-01',
        'address1' => 'required|string|between:5,150',
        'address2' => 'sometimes|nullable|string|between:5,150',
        'state_code' => 'required|alpha_num|exists:states,code',
        'lga_id' => 'required|integer|exists:lgas,id',
        'employment_status' => 'required|alpha_dash|in:unemployed,employee,self-employed,worker',
        'identification_type' => 'required|alpha_dash|in:international-passport,national-id,driver-license,permanent-voter-card',
        'profile_image' => 'required|file|mimes:png,jpg,jpeg|max:5120',
        'identification_image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        'email' => 'required|email|unique:users,email,' . $updateableUser->id,
      ];
    } else {
      $validator_rules = [
        'first_name' => 'sometimes|nullable|alpha|between:3,50',
        'last_name' => 'sometimes|nullable|alpha|between:3,50',
        'middle_name' => 'sometimes|nullable|alpha|between:3,50',
        'gender' => 'sometimes|alpha|in:M,F',
        'phone' => 'sometimes|nullable|regex:/\d{11}/|unique:users,phone,' . $updateableUser->id,
        'dob' => 'sometimes|nullable|date|before_or_equal:2015-01-01',
        'address1' => 'sometimes|nullable|string|between:5,150',
        'address2' => 'sometimes|nullable|string|between:5,150',
        'state_code' => 'sometimes|nullable|alpha_num|exists:states,code',
        'lga_id' => 'sometimes|nullable|integer|exists:lgas,id',
        'employment_status' => 'sometimes|nullable|alpha_dash|in:unemployed,employee,self-employed,worker',
        'identification_type' => 'sometimes|nullable|alpha_dash|in:international-passport,national-id,driver-license,permanent-voter-card',
        'profile_image' => 'sometimes|nullable|file|mimes:png,jpg,jpeg|max:5120',
        'identification_image' => 'sometimes|nullable|image|mimes:png,jpg,jpeg|max:5120',
        'email' => 'sometimes|nullable|email|unique:users,email,' . $updateableUser->id,
      ];
    }
    $this->validate($request, $validator_rules, [
      'phone.regex' => 'Phone number must be of 11 digit only',
      'profile_image.max' => 'Profile Image is more than 5mb',
      'identification_image.max' => 'Identification Image is more than 5mb',
      'gender.in'=>'Gender must either be Male or Female'

    ]);

    $updateableAttributes = [
      'first_name',
      'last_name',
      'middle_name',
      'phone',
      'dob',
      'gender',
      'address1',
      'address2',
      'state_code',
      'lga_id',
      'employment_status',
      'identification_type',
      'email',
    ];

    if ($request->hasFile('profile_image')) {
      $profileImage = $request->file('profile_image');
      $img_ext = $profileImage->getClientOriginalExtension();
      $img_name = sprintf("%s.%s", $updateableUser->code, $img_ext);
      if (File::exists("images/profile/" . $img_name)) {
        File::delete("images/profile/" . $img_name);
      }
      $profileImage->move(public_path("images/profile"), $img_name);
      $updateableUser->profile_image = $img_name;
      $updateableUser->update();
    }
    if ($request->hasFile('identification_image')) {
      $identificationImage = $request->file('identification_image');
      $img_ext = $identificationImage->getClientOriginalExtension();
      $img_name = sprintf("%s.%s", $updateableUser->code, $img_ext);
      if (File::exists("images/identification/" . $img_name)) {
        File::delete("images/identification/" . $img_name);
      }
      $identificationImage->move(public_path("images/identification"), $img_name);
      $updateableUser->identification_image = $img_name;
      $updateableUser->update();
    }
    foreach ($updateableAttributes as $key) {
      if ($request->has($key) && $request->{$key} != (null || "")) {
        $updateableUser->{$key} = $request->{$key};
      }
    }

    // if ($updateableUser->isDirty($updateableAttributes)) {
    $updateableUser->update();
    $response['status'] = "success";
    $response['message'] = "Profile was updated Successfully!";
    if ($updateableUser->status == 'pending') {
      return redirect()->route('initiate_membership_fee_flutterwave');
    } else {
      return redirect()->route('membership_detail')->with($response['status'], $response['message']);
    }
    // } else {
    //   $response['status'] = "success";
    //   $response['message'] = "No changes where made!";
    //   if ($updateableUser->status == 'pending') {
    //     return redirect()->route('initiate_membership_fee');
    //   } else {
    //     return redirect()->route('membership_detail')->with($response['status'], $response['message']);
    //   }
    // }
  }

  /**
   * Store the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function adminStoreNewMembershipDetails(Request $request)
  {
    // return dd($request);
    $this->validate($request, [
      'first_name' => 'required|alpha|between:3,50',
      'last_name' => 'required|alpha|between:3,50',
      'middle_name' => 'required|alpha|between:3,50',
      'phone' => 'required|regex:/\d{11}/|unique:users',
      'dob' => 'required|before_or_equal:2015-01-01',
      'address1' => 'required|string|between:5,150',
      'address2' => 'required|string|between:5,150',
      'state_code' => 'required|alpha_num|exists:states,code',
      'lga_id' => 'required|integer|exists:lgas,id',
      'employment_status' => 'required|alpha_dash|in:unemployed,employee,self-employed,worker',
      'identification_type' => 'required|alpha_dash|in:international-passport,national-id,driver-license,permanent-voter-card',
      'profile_image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
      'identification_image' => 'required|nullable|image|mimes:png,jpg,jpeg|max:5120',
      'email' => 'required|email|unique:users',
      'password' => 'required|string|between:4,25'
    ], [
      'phone.regex' => 'Phone number must be of 11 digit only',
      'profile_image.max' => 'Profile Image is more than 5mb',
      'identification_image.max' => 'Identification Image is more than 5mb'
    ]);
    $updateableAttributes = [
      'first_name',
      'last_name',
      'middle_name',
      'phone',
      'dob',
      'address1',
      'address2',
      'state_code',
      'lga_id',
      'employment_status',
      'identification_type',
      'email',
    ];
    $newUser = new User();
    foreach ($updateableAttributes as $key) {
      if ($request->has($key) && $request->{$key} != (null || "")) {
        $newUser->{$key} = $request->{$key};
      }
    }
    $newUser->password = Hash::make($request->password);
    $newUser->status = 'approved';
    $newUser->save();
    event(new Registered($newUser));

    if ($request->hasFile('profile_image')) {
      $profileImage = $request->file('profile_image');
      $img_ext = $profileImage->getClientOriginalExtension();
      $img_name = sprintf("%s.%s", $newUser->code, $img_ext);
      if (File::exists("images/profile/" . $img_name)) {
        File::delete("images/profile/" . $img_name);
      }
      $profileImage->move(public_path("images/profile"), $img_name);
      $newUser->profile_image = $img_name;
    }
    if ($request->hasFile('identification_image')) {
      $profileImage = $request->file('identification_image');
      $img_ext = $profileImage->getClientOriginalExtension();
      $img_name = sprintf("%s.%s", $newUser->code, $img_ext);
      if (File::exists("images/identification/" . $img_name)) {
        File::delete("images/identification/" . $img_name);
      }
      $profileImage->move(public_path("images/identification"), $img_name);
      $newUser->identification_image = $img_name;
    }

    $newUser->update();
    $response['status'] = "success";
    $response['message'] = "New Member added Successfully!";
    return response()->json($response, Response::HTTP_OK);
  }
}
