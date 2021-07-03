<?php

namespace App\Models;

use App\Traits\ShortCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
  use HasFactory,ShortCode;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'code',
    'user_id',
    'amount',
    'status',
    'bank_code',
    'account_name',
    'account_number',
    'completed_at',
  ];


  /**
   * The properties for short code generation
   *
   * @var array
   */
  protected $shortCodeConfig = [
    'column'=>'code',
    'salt'=>'WDR',
    'length'=>8,
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    // 'user_id'
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
}
