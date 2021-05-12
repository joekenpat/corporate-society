<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait ShortCode
{
  /**
   * Boot the Set Slug Attribute trait for the model.
   *
   * @return void
   */
  public static function bootShortCode()
  {
    static::creating(function ($model) {
      $column = $model->shortCodeConfig['column'];
      $salt = $model->shortCodeConfig['salt'];
      $len = intval($model->shortCodeConfig['length']);
      $code = strtoupper($salt . Str::random($len - strlen($salt)));
      if (static::getSoftDeletingAttribute()) {
        if (!static::where('id', '!=', $model->id)->where($column, $code)->withTrashed()->exists()) {
          $model->{$column} = $code;
        } else {
          while (static::where('id', '!=', $model->id)->where($column, $code)->withTrashed()->exists()) {
            $code = strtoupper($salt . Str::random($len - strlen($salt)));
          }
          $model->{$column} = $code;
        }
      } else {
        if (!static::where('id', '!=', $model->id)->where($column, $code)->exists()) {
          $model->{$column} = $code;
        } else {
          while (static::where('id', '!=', $model->id)->where($column, $code)->exists()) {
            $code = strtoupper($salt . Str::random($len - strlen($salt)));
          }
          $model->{$column} = $code;
        }
      }
    });
  }

  public static function getSoftDeletingAttribute()
  {
    // ... check if 'this' model uses the soft deletes trait
    return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(static::class));
  }
}
