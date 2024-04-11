<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightCallSigns extends Model
{

    public function stateChangeAttempt()
    {
        return $this->hasMany('App\StateChangeAttempts');
        
    }
}
