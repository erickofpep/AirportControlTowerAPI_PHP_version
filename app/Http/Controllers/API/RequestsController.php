<?php

namespace App\Http\Controllers\API;

use App\FlightCallSigns;
use App\StateChangeAttempts;
use App\aircraftLocations;
use App\aircraftCommunications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;

class RequestsController extends Controller
{

/*
Aircraft initiates communication: PUT
*/
public function initiateCommunication(){

    if ($_SERVER['REQUEST_METHOD'] !='PUT') {
        return json_encode(['response'=>'Invalid Request Method. Must be a PUT request'], JSON_PRETTY_PRINT);
        //exit();
    }
    else {
    
    //Generate base_64encoded(sha) authorization_key;
    $authorization_key = base64_encode( hash('sha256', uniqid()) );

    $saveAuthKey = new aircraftCommunications();
    $saveAuthKey->authorization_key = base64_decode($authorization_key);
    $saveAuthKey->save();

    return json_encode([ "authorization_key"=> $authorization_key], JSON_PRETTY_PRINT);

    }
}

/*Aircraft sends communication: PUT
When aircraft is parked, Ground Crew communicates the PARKED state internally with the control tower (not via API).
*/
public function sendCommunication(Request $request){

    $Expected_type = array("AIRLINER", "PRIVATE");
    $Expected_state = array("AIRBORNE", "PARKED", "LANDED", "TAKE-OFF");

    if ($_SERVER['REQUEST_METHOD'] !='PUT') {
        return json_encode(['response'=>'Invalid Request Method. Must be a PUT request'], JSON_PRETTY_PRINT);
        //exit();
    }
    else {
    
    /*$headers=getallheaders();
    if ( !array_key_exists('authorization_key', $headers)) {
        return json_encode([ "response"=> "authorization_code header is missing"], JSON_PRETTY_PRINT);
        exit;
    }*/


//Check if Authorization_key exist 

    if(empty($request->authorization_key)){
   
    return json_encode(['response'=>'authorization_key is required'], JSON_PRETTY_PRINT);

    }
    elseif(aircraftCommunications::where('authorization_key', base64_decode($request->authorization_key))->count() == 0){
     //->where('aircraft_call_sign', $emptyField)->where('type', 'null')->where('outcome', 'null')   
    return json_encode(['response'=>'authorization_key not recognized'], JSON_PRETTY_PRINT);
    
    }
    elseif(empty($request->aircraft_call_sign)){
   
    return json_encode(['response'=>'aircraft_call_sign is required'], JSON_PRETTY_PRINT);
        
    }
    elseif(empty($request->type)){
   
    return json_encode(['response'=>'aircraft type is required'], JSON_PRETTY_PRINT);
            
    }
    elseif (!in_array($request->type, $Expected_type)) {
    return json_encode(['response'=>'aircraft type must be AIRLINER or PRIVATE'], JSON_PRETTY_PRINT);
    }
    elseif(empty($request->state)){
   
    return json_encode(['response'=>'aircraft state is required'], JSON_PRETTY_PRINT);
            
    }
    elseif (!in_array($request->state, $Expected_state)) {

    return json_encode(['response'=>'aircraft state must be AIRBORNE or PARKED or LANDED or TAKE-OFF'], JSON_PRETTY_PRINT);

    }
    elseif(aircraftCommunications::where('authorization_key', base64_decode($request->authorization_key))->where('type', $request->type)->where('state', $request->state)->count() > 0){
        
    return response()->json(['response'=>'Communication already exist']);

    }
    else{

    // return json_encode(['response'=>'authorization_key= '.$request->authorization_key.' callsign= '.$request->aircraft_call_sign.' type= '.$request->type.' state= '.$request->state], JSON_PRETTY_PRINT);
    
    $stateChange = aircraftCommunications::where('authorization_key', base64_decode($request->authorization_key))->first();
    $stateChange->aircraft_call_sign = strtoupper($request->aircraft_call_sign);
    $stateChange->type = $request->type;
    $stateChange->state = $request->state;
    $stateChange->save();

    return json_encode(['response'=>'Communication has been sent'], JSON_PRETTY_PRINT);


    }



    }
}


//Control Tower Views all Communications
public function view_communications(){
    if(aircraftCommunications::all()->count() == 0){

        return json_encode(['response'=>'No Communication available'], JSON_PRETTY_PRINT);

    }
    else{
   
    $FetchCommunications =json_decode(aircraftCommunications::orderby('id', 'desc')->get());
    return $FetchCommunications;
   
    }
}

/*
Control Tower's Answer to a request
*/
public function sendResponse(Request $request){

    $Expected_Answer = array("ACCEPTED", "REJECTED");

    if(empty($request->authorization_key)){
   
    return json_encode(['response'=>'authorization_key must not be empty'], JSON_PRETTY_PRINT);
    }
    elseif(aircraftCommunications::where('authorization_key', $request->authorization_key)->count() == 0){

        return json_encode(['response'=>'authorization_key is not recognized'], JSON_PRETTY_PRINT);

    }
    elseif(empty($request->outcome)){

    return json_encode(['response'=>'Outcome must not be empty'], JSON_PRETTY_PRINT);

    }
    elseif (!in_array($request->outcome, $Expected_Answer)) {
    
    return json_encode(['response'=>'Outcome must be ACCEPTED or REJECTED'], JSON_PRETTY_PRINT);

    }
    else{

    // return json_encode(['response'=>'authorization_key= '.base64_decode($request->authorization_key).' Outcome'.$request->outcome], JSON_PRETTY_PRINT);
    $stateChange = aircraftCommunications::where('authorization_key', $request->authorization_key)->first();
    $stateChange->outcome = $request->outcome;
    $stateChange->save();

    return json_encode(['response'=>'Request answered'], JSON_PRETTY_PRINT);

    }
}

/*
Retrieve response from Control Tower
*/
public function receiveResponse(Request $request){
    if(empty($request->authorization_key)){
   
    return json_encode(['response'=>'authorization_key must not be empty'], JSON_PRETTY_PRINT);
    }
    elseif(aircraftCommunications::where('authorization_key', base64_decode( $request->authorization_key))->count() == 0){
    
    return json_encode(['response'=>'Your authorization_key is not recognized'], JSON_PRETTY_PRINT);
    
    }
    else{

    $fetchAnswer = aircraftCommunications::where('authorization_key', base64_decode( $request->authorization_key))->first();
    
    return json_encode([
        // 'authorization_key'=>$request->authorization_key,
        'state'=>$fetchAnswer->state,
        'outcome'=>$fetchAnswer->outcome
    ], JSON_PRETTY_PRINT);

    }
}




/*
Auto Generate Flight Call Signs
*/
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
    
    $saveStateChange = new StateChangeAttempts();
 
    $saveStateChange->state_change = $request->state;
    $saveStateChange->attempted_flight_id = $fetchFlightID->id;
    $saveStateChange->attempted_flight_name = $request->call_sign;
    $saveStateChange->save();

    return response()->json([ 'response'=>$request->state.' has been requested by Flight'.$request->call_sign ]);
    
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


/**
* transmit the current position
*/
public function sendLocation(Request $request){

    $Expected_type = array("AIRLINER", "PRIVATE");

    $aircraft_name=addslashes(trim($request->aircraft_name));

    $type=addslashes(trim($request->type));

    $latitude=addslashes(trim($request->latitude));

    $longitude=addslashes(trim($request->longitude));

    $altitude=addslashes(trim($request->altitude));
    $heading=addslashes(trim($request->heading));

    if(!$aircraft_name){
        return response()->json(['response'=>'What is Name of Aircraft transmitting current position?']); 
    }
    elseif(!$type){
        return response()->json(['response'=>'What is the type of Aircraft?']); 
    }
    elseif (!in_array($type, $Expected_type)) {
        return response()->json(['response'=>'Aircraft type shoul be AIRLINER or PRIVATE']);
    }
    elseif(!$latitude){
        return response()->json(['response'=>'What is the Latitude geo coordinate?']);  
    }
    elseif(!$longitude){
        return response()->json(['response'=>'What is the Longitude geo coordinate?']); 
    }
    elseif(!$altitude){
        return response()->json(['response'=>'What is your altitude?']); 
    }
    elseif(!$heading){
        return response()->json(['response'=>'What is your heading?']);
    }
    elseif(aircraftLocations::where('aircraft_name', $aircraft_name)->where('type', $type)->where('latitude', $latitude)->where('longitude', $longitude)->where('altitude', $altitude)->where('heading', $heading)->count() > 0){
        
        return response()->json(['response'=>'Location information already exist']);

    }
    else{

    // return response()->json(['response'=>'aircraft_name= '.$aircraft_name.' type= '.$type.' latitude='.$latitude.' longitude='.$longitude.' altitude='.$altitude.' heading='.$heading]);

// /* 
        $saveLocation = new aircraftLocations();
 
        $saveLocation->aircraft_name = $aircraft_name;
        $saveLocation->type = $type;
        $saveLocation->latitude = $latitude;
        $saveLocation->longitude = $longitude;
        $saveLocation->altitude = $altitude;
        $saveLocation->heading = $heading;
        $saveLocation->save();
//  */   
        return response()->json([ 'response'=>'Location has been transmitted']);
       
    }
}

/**
* transmit the current position
*/
public function aircraftLocationsView(){

    if(aircraftLocations::all()->count() == 0){

        return response()->json(['response'=>'No Aircraft locations transmitted']);
        
    }
    else{
   
    $fetchLocations =json_decode(aircraftLocations::orderby('id', 'desc')->get());
    return $fetchLocations;
   
    }  


}



}
