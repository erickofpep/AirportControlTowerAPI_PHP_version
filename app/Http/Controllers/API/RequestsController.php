<?php

namespace App\Http\Controllers\API;

use App\FlightCallSigns;
use App\StateChangeAttempts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;

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

    Artisan::call('migrate:refresh'); //,['--path' => './database/migrations/2024_04_04_132329_create_tasks.php']

    if(FlightCallSigns::all()->count() == 0){

        return response()->json(['response'=>'No Flight Call Sign available']);
        
    }
    
}


/**
* Show all Flight Call Signs
*/
public function flight_callSigns(){

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
    
    //Get flight_id
    $fetchFlightID = FlightCallSigns::where('flight_name',$request->call_sign)->first();

    /* Flight identity recognized, Now Save
    //state change attempts outcome

    //Get Current Date/Time
    $curDateTime = new \DateTime();
    //$saveStateChange->datetime_attempted = $curDateTime->format("Y-m-d H:i:s");
    state_id, state_change, attempted_flight_id, attempted_flight_name, datetime_attempted, outcome
    */
    
    // /*
    $saveStateChange = new StateChangeAttempts();
 
    $saveStateChange->state_change = $request->state;
    $saveStateChange->attempted_flight_id = $fetchFlightID->id;
    $saveStateChange->attempted_flight_name = $request->call_sign;
    $saveStateChange->save();
// */
    return response()->json([ 'response'=>$request->state.' has been requested by Flight '.$request->call_sign ]);
    


    }

}
else{

   return response()->json(['400'=>'Bad Request. Must be POST request']);
}
  
}

/**
* View all State change attempts
*/
public function stateChangeAttempts(){

    if(StateChangeAttempts::all()->count() == 0){

     return response()->json(['response'=>'State change attempts unavailable']);
     
    }
    else{

    $fetchStateChangeAttempts =json_decode(StateChangeAttempts::orderby('id', 'desc')->get());
    return $fetchStateChangeAttempts;

    }
    
}


/**
* Respond to State Change
*/
public function respondToStateChange(Request $request){

    $Expected_outcome = array("ACCEPTED", "REJECTED");

    if(empty($request->state_change_id)){
        return response()->json(['response'=>'state_change_id must not be empty']);
    }
    elseif(StateChangeAttempts::where('id', $request->state_change_id)->count() == 0){
    
      return response()->json(['response'=>'state_change_id not found. Refer list of State Change Attempts']);

    }
    elseif(empty($request->outcome)){
        return response()->json(['response'=>'Outcome of state change must not be empty. ACCEPTED or REJECTED']);
    }
    elseif (!in_array($request->outcome, $Expected_outcome)) {

        return response()->json(['response'=>'Outcome of state must be ACCEPTED or REJECTED']);
    }
    else{

//check state change id
$checkStateChangeID = StateChangeAttempts::where('id', $request->state_change_id)->first();   
    //return response()->json(['response'=>'state_change_id = '.$request->state_change_id.' Outcome of state change '.$request->outcome.' attempted_flight_id= '.$checkStateChangeID->attempted_flight_id.' attempted_flight_name= '.$checkStateChangeID->attempted_flight_name.' state_change=  '.$checkStateChangeID->state_change]);

//Update Outcome in StateChangeAttempts *********
$stateChange = StateChangeAttempts::where('id', $request->state_change_id)->first();
$stateChange->outcome = $request->outcome;
$stateChange->save();

return response()->json(['response'=>$checkStateChangeID->state_change.' has been '.$request->outcome]);


    }

 


}


}
