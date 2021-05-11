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
    'password',
    'status',
  ];

  /**
   * The properties for short code generation
   *
   * @var array
   */
  protected $shortCodeConfig = [
    'column'=>'code',
    'salt'=>'USR',
    'length'=>8,
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
   * The computed attributes that should be appended to results
   *
   * @var array
   */
  protected $appends = [
    "ledger_balance",
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function ledger_balance()
  {
    return $this->available_balance + $this->investment_balance;
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
