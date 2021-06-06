<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    return view('auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $request->validate([
      'first_name' => 'required|alpha|max:25|min:2',
      'last_name' => 'required|alpha|max:25|min:2',
      'phone' => 'required|regex:/\d{11}/|unique:users,phone',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'password_confirmation' => 'required|same:password',
      'operating_policy'=>'accepted',
    ], [
      'phone.regex' => 'Phone number must be of 11 digit only',
    ]);

    $user = User::create([
      'last_name' => $request->last_name,
      'first_name' => $request->first_name,
      'phone' => $request->phone,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
  }
}
