<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'state_code',
    ];

    public function state()
    {
        $this->belongsTo(State::class, 'state_code', 'code');
    }
}
