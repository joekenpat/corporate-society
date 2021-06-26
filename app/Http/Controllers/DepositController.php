<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Investment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DepositController extends Controller
{

  /**
   * Create user deposits
   *
   * @return \Illuminate\Http\Response
   */
  public function userCreateDeposit()
  {
    return view('deposit_create');
  }

  /**
   * Display a listing of user deposits
   *
   * @return \Illuminate\Http\Response
   */
  public function userListDeposit()
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $deposits = Deposit::select([
      'code',
      'amount',
      'status',
      'created_at',
      'completed_at',
    ])->whereUserId($user->id)
      ->latest()
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
  public function adminListDeposit($status)
  {
    $deposits = Deposit::select([
      'code',
      'amount',
      'status',
      'created_at',
      'user_id',
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,profile_image'])
      ->where('status', $status)
      ->latest()
      ->paginate(10);
    $response['status'] = "success";
    $response['deposits'] = $deposits;
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Store a new withdrawal resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function userStoreDeposit(Request $request)
  {
    $user = User::whereId(auth()->user()->id)->firstOrFail();
    $this->validate($request, [
      'amount' => "nullable|integer|min:50|max:50000000",
    ]);
    $newDeposit = Deposit::create([
      'user_id' => $user->id,
      'amount' => $request->amount,
      'status' => 'pending',
      'completed_at' => null,
    ]);
    $response['status'] = "success";
    $response['message'] = "Your Deposit of #{$request->amount} has been placed.";
    $data = [
      "tx_ref" => $newDeposit->code,
      "amount" => $request->amount,
      "currency" => "NGN",
      "redirect_url" => route('deposit_validate_payment'),
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
        "title" => "N{$request->amount} Deposit",
        "description" => "N{$request->amount} Account Deposit",
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
  public function handleDepositPaymentGatewayCallback(Request $request)
  {
    if ($request->has('transaction_id')) {
      $trnx_id = $request->transaction_id;
      $flutterwave_client = Http::withToken(config('flutterwave.secretKey'))
        ->acceptJson()->get("https://api.flutterwave.com/v3/transactions/{$trnx_id}/verify");
      $paymentDetails = $flutterwave_client->json();
      return dd($paymentDetails);
      $valid_deposit = Deposit::where('code', $paymentDetails['data']['reference'])->firstOrFail();
      if ($paymentDetails['data']['status'] === "success") {
        if (($paymentDetails['data']['charged_amount']) == $valid_deposit->amount) {
          if ($valid_deposit->status == 'pending' && $valid_deposit->completed_at == null) {
            $valid_deposit->status = 'completed';
            $valid_deposit->completed_at = now();
            $valid_deposit->update();
            $user = User::whereId($valid_deposit->user_id)->firstOrFail();
            $user->available_balance += $valid_deposit->amount;
            $user->update();
          }
        } else {
          $valid_deposit->status = 'completed';
          $valid_deposit->completed_at = now();
          $valid_deposit->amount = ($paymentDetails['data']['charged_amount']);
          $valid_deposit->update();
          $user = User::whereId($valid_deposit->user_id)->firstOrFail();
          $user->available_balance += ($paymentDetails['data']['charged_amount']);
          $user->update();
        }
        $response['status'] = 'success';
        $response['message'] = "Your deposit of ₦{$valid_deposit->amount} was successfull.";
      } else {
        $valid_deposit->status = 'failed';
        $valid_deposit->completed_at = now();
        $valid_deposit->update();
        $response['status'] = 'error';
        $response['message'] = "Your deposit of ₦{$valid_deposit->amount} failed.";
      }
    } else {
      $valid_deposit = Deposit::where('code', $request->tx_ref)->firstOrFail();
      $valid_deposit->status = 'failed';
      $valid_deposit->completed_at = now();
      $valid_deposit->update();
      $response['status'] = 'error';
      $response['message'] = "Your deposit of ₦{$valid_deposit->amount} failed.";
    }
    return redirect()->route('deposit_history')->with($response['status'], $response['message']);
  }

  public function markPendingDepositAsFailed($deposit_code)
  {
    $valid_deposit = Deposit::whereCode($deposit_code)->firstOrFail();
    $valid_deposit->status = 'failed';
    $valid_deposit->completed_at = now();
    $valid_deposit->update();
    $response['status'] = 'error';
    $response['message'] = "Your deposit has failed.";
    return redirect()->route('deposit_history')->with($response['status'], $response['message']);
  }
}
