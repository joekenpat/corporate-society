<?php

namespace App\Models;

use App\Traits\ShortCode;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable, ShortCode;

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
    'state_code',
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
    'column' => 'code',
    'salt' => 'USR',
    'length' => 8,
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
    "full_name", "state_name", "lga_name", "padded_id"
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'dob' => 'datetime',
  ];

  public function getFullNameAttribute()
  {
    return $this->last_name . ' ' . $this->first_name;
  }

  public function getStateNameAttribute()
  {
    return $this->state()->first() ? $this->state()->first()->name : null;
  }

  public function getLgaNameAttribute()
  {
    return $this->lga()->first() ? $this->lga()->first()->name : null;
  }

  // public function getLedgerBalanceAttribute()
  // {
  //   return $this->available_balance + $this->investment_balance;
  // }

  public function investments()
  {
    return $this->hasMany(Investment::class);
  }

  public function activeInvestments()
  {
    return $this->investments()->whereCompletedAt(null);
  }

  public function completedInvestments()
  {
    return $this->investments()->where('completed_at', '<>', null);
  }

  public function withdrawals()
  {
    return $this->hasMany(Withdrawal::class);
  }


  public function pendingWithdrawals()
  {
    return $this->withdrawals()->whereStatus('pending');
  }

  public function completedWithdrawals()
  {
    return $this->withdrawals()->whereStatus('completed');
  }

  public function deposits()
  {
    return $this->hasMany(Deposit::class);
  }

  public function pendingDeposits()
  {
    return $this->deposits()->whereStatus('pending');
  }

  public function completedDeposits()
  {
    return $this->deposits()->whereStatus('completed');
  }

  public function withdrawalBank()
  {
    return $this->hasOne(WithdrawalBank::class, 'user_id');
  }

  public function state()
  {
    return $this->belongsTo(State::class, 'state_code', 'code');
  }

  public function lga()
  {
    return $this->belongsTo(Lga::class, 'lga_id');
  }

  public function getPaddedIdAttribute()
  {
    return str_pad($this->id, 5, '0', STR_PAD_LEFT);
  }
}
