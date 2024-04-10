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

        return response()->json(['response'=>' flight name/id= '.$call_sign]);
    }
}
