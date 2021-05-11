<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
  use HasFactory;
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
  protected $hidden = [];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'completed_at' => 'datetime',
  ];
}
