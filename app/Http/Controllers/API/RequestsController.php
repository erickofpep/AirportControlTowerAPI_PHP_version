<?php

namespace App\Http\Controllers\API;

use App\FlightCallSigns;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class RequestsController extends Controller
{

//Auto Generate Flight Call Signs
public function addcallSigns(){

Artisan::call('db:seed');
    // return $someCmnd;
$FetchAllCallSigns =json_decode(FlightCallSigns::orderby('id', 'desc')->get());
return $FetchAllCallSigns;

/*
Artisan::call('db:seed');
   // get output
  Artisan::output();
*/

}

//Auto clear Generated Flight Call Signs
public function autoclearCallSigns(){

    Artisan::call('migrate:refresh');
    
    if(FlightCallSigns::all()->count() == 0){

        return response()->json(['response'=>'No Flight Call Sign available']);
        
    }
    
}


/**
* Show all Flight Call Signs
*/
public function flight_callSigns() {

    if(FlightCallSigns::all()->count() == 0){

     return response()->json(['response'=>'No Flight Call Sign available']);
     
    }
    else{

    $FetchAllCallSigns =json_decode(FlightCallSigns::orderby('id', 'desc')->get());
    return $FetchAllCallSigns;

    }
    
}

/**
* Flight Call Sign request
*/
public function intent(Request $request) {

//Check if request is POST
if( $_SERVER['REQUEST_METHOD'] === 'POST'){

    $Expected_States = array("APPROACH", "TAKE-OFF");

    //check if Flight name/identity is known in system
    // if(count($checkCallSignExistence) == 0){
    if(FlightCallSigns::where('flight_name', $request->call_sign)->count() == 0){
        
        return response()->json(['204'=>'Flight Call Sign: '.strtoupper($request->call_sign).' not recognized']);

    }
    //Check if "state" is not empty
    elseif(empty($request->state)){
        return response()->json(['response'=>'Flight State must not be empty']);
    }
    elseif(empty($request->call_sign)){
        return response()->json(['response'=>'Flight Call Sign must not be empty']);
    }
    elseif (!in_array($request->state, $Expected_States)) {
        return response()->json(['response'=>'Flight State must be APPROACH or TAKE-OFF']);
    }
    else{
    
        //Flight identity is found, then What ?
        return response()->json(['response'=>'Flight Call '.$request->call_sign.' Recognized']);
    }

}
else{

   return response()->json(['400'=>'Bad Request. Must be POST request']);

}

    
    
}




}
