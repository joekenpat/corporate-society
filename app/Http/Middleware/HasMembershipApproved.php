<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasMembershipApproved
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
    if (Auth::check() && Auth::user()->status == 'paid') {
      $response['status'] = "info";
      $response['message'] = "Your membership application has not yet been approved";
      return redirect()->route('dashboard')->with($response['status'], $response['message']);
    } elseif (Auth::check() && Auth::user()->status == 'declined') {
      $response['status'] = "info";
      $response['message'] = "Your membership application has been rejected";
      return redirect()->route('dashboard')->with($response['status'], $response['message']);
    }
    return $next($request);
  }
}
