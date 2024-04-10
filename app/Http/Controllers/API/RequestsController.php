<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsController extends Controller
{
    /**
     * Flight Call Sign request
     */
    public function intent($call_sign) {

        //check if Flight name/identity is known in system

        //check if Request body has TAKE-OFF or APPROACH
        return response()->json(['response'=>' flight name/id= '.$call_sign]);
    }
}
