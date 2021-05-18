<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalBank extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id',
    'bank_code',
    'account_name',
    'account_number',
  ];


  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'user_id'
  ];

  /**
   * The attributes that should be appended to arrays.
   *
   * @var array
   */
  protected $appends = [
    'bank_name'
  ];


  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'completed_at' => 'datetime',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function bank()
  {
    return $this->belongsTo(Bank::class, 'bank_code', 'code');
  }

  public function getBankNameAttribute()
  {
    return $this->bank()->first() ? $this->bank()->first()->name : null;
  }
}
