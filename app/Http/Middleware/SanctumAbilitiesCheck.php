<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SanctumAbilitiesCheck
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next, ...$abilities)
  {
    foreach ($abilities as $ability) {
      if ($request->user()->tokenCan($ability)) {
        return $next($request);
      }
    }
    return response()->json(["message" => "Access Denied!",], Response::HTTP_FORBIDDEN);
  }
}
