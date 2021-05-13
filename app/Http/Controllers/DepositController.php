<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Investment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Unicodeveloper\Paystack\Paystack;

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
  public function adminListDeposit()
  {
    $deposits = Deposit::select([
      'code',
      'amount',
      'status',
      'created_at',
      'completed_at',
    ])->with(['user:id,code,first_name,last_name,email,avatar'])
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
      'amount' => "nullable|integer|min:50000|max:2000000",
    ]);
    $newDeposit = Deposit::create([
      'user_id' => $user->id,
      'amount' => $request->amount,
      'status' => 'pending',
      'completed_at' => null,
    ]);
    $response['status'] = "success";
    $response['message'] = "Your Deposit of #{$request->amount} has been placed.";
    $paystack = Http::withToken(config('paystack.secretKey'))
      ->post('https://api.paystack.co/transaction/initialize', [
        'email' => $user->email,
        'amount' => $request->amount *= 100,
        'quantity' => 1,
        'currency' => 'NGN',
        'channels' => ['card'],
        'reference' => $newDeposit->code,
        'callback_url' => route('deposit_validate_payment'),
        'metadata' => [
          'cancel_action' => route('mark_pending_deposit_as_failed', ['deposit_code' => $newDeposit->code]),
        ]
      ])->json();
    return redirect()->away($paystack['data']['authorization_url']);
    // $paystack = new Paystack();
    // $request->email = $user->email;
    // $request->amount *= 100;
    // $request->quantity = 1;
    // $request->currency = 'NGN';
    // $request->reference = $newDeposit->code;
    // $request->key = config('paystack.secretKey');
    // $request->callback_url = route('deposit_validate_payment');
    // return $paystack->getAuthorizationUrl()->redirectNow();
    // return redirect()->route('deposit_history');
  }

  /**
   * Obtain Paystack payment information
   * @return void
   */
  public function handleDepositPaymentGatewayCallback(Request $request)
  {
    return dd($request);
    $paystack_client = Http::withToken(config('paystack.secretKey'))->get("https://api.paystack.co/transaction/verify/" . $request->query('trxref'));
    $paymentDetails = $paystack_client->json();
    $valid_deposit = Deposit::where('code', $paymentDetails['data']['reference'])->firstOrFail();
    if ($paymentDetails['data']['status'] === "success") {
      if (($paymentDetails['data']['amount'] / 100) == $valid_deposit->amount) {
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
        $valid_deposit->amount = ($paymentDetails['data']['amount'] / 100);
        $valid_deposit->update();
        $user = User::whereId($valid_deposit->user_id)->firstOrFail();
        $user->available_balance += ($paymentDetails['data']['amount'] / 100);
        $user->update();
      }
    } elseif ($paymentDetails['data']['status'] === "failed") {
      $valid_deposit->status = 'failed';
      $valid_deposit->completed_at = now();
      $valid_deposit->update();
    }
    return redirect()->route('deposit_history');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Deposit  $deposit
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Deposit $deposit)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Deposit  $deposit
   * @return \Illuminate\Http\Response
   */
  public function markPendingDepositAsFailed($deposit_code)
  {
    $valid_deposit = Deposit::whereCode($deposit_code)->firstOrFail();
    $valid_deposit->status = 'failed';
    $valid_deposit->completed_at = now();
    $valid_deposit->update();
    return redirect()->route('deposit_history');
  }
}
