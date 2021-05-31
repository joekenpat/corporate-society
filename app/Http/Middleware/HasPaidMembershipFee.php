<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPaidMembershipFee
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (Auth::check() && Auth::user()->status == 'pending') {
      $response['status'] = "info";
      $paymentRoute = route('initiate_membership_fee_flutterwave');
      $response['message'] = "You need to pay your membership fee of ₦1,500 to activate your account, <a href='{$paymentRoute}'>Click Here To Pay Now</a>";
      return redirect()->route('dashboard')->with($response['status'], $response['message']);
    }
    return $next($request);
  }
}
