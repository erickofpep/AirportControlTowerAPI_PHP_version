<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StateChangeAttempts extends Model
{
    //
    public function call_sign()
    {
        return $this->belongsTo('App\FlightCallSigns');

    }
}
