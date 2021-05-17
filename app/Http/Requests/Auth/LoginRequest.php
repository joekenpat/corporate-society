<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'phone' => 'required|regex:/\d{11}/',
      'password' => 'required|string',
    ];
  }

  /**
   * Get the validation error messages that apply to the request.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'phone.regex' => 'Phone number must be of 11 digit only',
    ];
  }

  /**
   * Attempt to authenticate the request's credentials.
   *
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function authenticate()
  {
    $this->ensureIsNotRateLimited();

    if (!Auth::attempt($this->only('phone', 'password'), $this->filled('remember'))) {
      RateLimiter::hit($this->throttleKey());

      throw ValidationException::withMessages([
        'phone' => 'Phone number or Password is incorrect',
      ]);
    }

    RateLimiter::clear($this->throttleKey());
  }

  /**
   * Ensure the login request is not rate limited.
   *
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function ensureIsNotRateLimited()
  {
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
      return;
    }

    event(new Lockout($this));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
      'phone' => trans('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ]),
    ]);
  }

  /**
   * Get the rate limiting throttle key for the request.
   *
   * @return string
   */
  public function throttleKey()
  {
    return Str::lower($this->input('phone')) . '|' . $this->ip();
  }
}
