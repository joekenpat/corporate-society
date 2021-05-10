<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code',
    ];


    public function lgas()
    {
        $this->hasMany(Lga::class, 'code', 'state_code');
    }
}
