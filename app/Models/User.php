<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "code",
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
    'membership_package_id',
    'email',
    'password',
    'status',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getAvailableBalanceAttribute()
  {
    # code...
  }

  public function getInvestmentBalanceAttribute()
  {
    # code...
  }

  public function getLedgerBalanceAttribute()
  {
    # code...
  }

  public function investments()
  {
    # code...
  }

  public function activeInvestments()
  {
    # code...
  }

  public function completedInvestments()
  {
    # code...
  }

  public function withdrawals()
  {
    # code...
  }

  public function pendingWithdrawals()
  {
    # code...
  }

  public function completedWithdrawals()
  {
    # code...
  }

  public function deposits()
  {
    # code...
  }

  public function pendingDeposits()
  {
    # code...
  }

  public function completedDeposits()
  {
    # code...
  }
}
