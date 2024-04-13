<?php

namespace App\Http\Controllers\API;

use App\FlightCallSigns;
use App\StateChangeAttempts;
use App\aircraftLocations;
use App\aircraftCommunications;
use App\weatherinfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;

class RequestsController extends Controller
{

/*
1.
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

/* 2.
Aircraft sends communication: PUT
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

    if(empty($request->authorization_key)){
   
    return json_encode(['response'=>'authorization_key is required'], JSON_PRETTY_PRINT);

    }
    elseif(aircraftCommunications::where('authorization_key', base64_decode($request->authorization_key))->count() == 0){

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


/* 3.
Control Tower Views all Communications
*/
public function view_communications(){
    if(aircraftCommunications::all()->count() == 0){

    return json_encode(['response'=>'No Communication available'], JSON_PRETTY_PRINT);

    }
    else{
   
    $FetchCommunications =json_decode(aircraftCommunications::orderby('id', 'desc')->get());
    return $FetchCommunications;
   
    }
}

/* 4.
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

/* 5.
Aircraft Retrieves response from Control Tower
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

/* 6.
Aircraft initiate communication on location
*/
public function initiateLocation(){

//Generate base_64encoded(sha) authorization_key;
$authorization_key = base64_encode( hash('sha256', uniqid()) );

$saveAuthKey = new aircraftLocations();
$saveAuthKey->authorization_key = base64_decode($authorization_key);
$saveAuthKey->save();

return json_encode([ 
    "required authorization"=> $authorization_key
], JSON_PRETTY_PRINT);

}

/*7.
Aircraft sends location: PUT
*/
public function location_send(Request $request){
 
    $Expected_Aircraft_type = array("AIRLINER", "PRIVATE");

    if(empty($request->aircraft_name)){

    return json_encode(['response'=>'What is the Aircraft name?'], JSON_PRETTY_PRINT);

    }
    elseif(empty($request->type)){
        return json_encode(['response'=>'What is the type of Aircraft?'], JSON_PRETTY_PRINT);
    }
    elseif (!in_array($request->type, $Expected_Aircraft_type)) {
        return json_encode(['response'=>'Aircraft type shoul be AIRLINER or PRIVATE'], JSON_PRETTY_PRINT);

    }
    elseif(empty($request->authorization_key)){
   
        return json_encode(['response'=>'authorization_key must not be empty'], JSON_PRETTY_PRINT);
    }
   elseif(aircraftLocations::where('authorization_key', base64_decode( $request->authorization_key))->count() == 0){
        
        return json_encode(['response'=>'Your authorization_key is not recognized'], JSON_PRETTY_PRINT);
        
    }
    elseif(empty($request->latitude)){
        return json_encode(['response'=>'What is the Latitude geo coordinate?'], JSON_PRETTY_PRINT); 
    }
    elseif(empty($request->longitude)){
        return json_encode(['response'=>'What is the Longitude geo coordinate?'], JSON_PRETTY_PRINT); 
    }
    elseif(!$request->altitude){
        return json_encode(['response'=>'What is your altitude?'], JSON_PRETTY_PRINT);
    }
    elseif(!$request->heading){

        return json_encode(['response'=>'What is your heading?'], JSON_PRETTY_PRINT);

    }
    elseif(aircraftLocations::where('authorization_key', base64_decode( $request->authorization_key))->where('aircraft_name', $request->aircraft_name)->where('type', $request->type)->where('latitude', $request->latitude)->where('longitude', $request->longitude)->where('altitude', $request->altitude)->where('heading', $request->heading)->count() > 0){
        
        return json_encode(['response'=>'Location information already exist'],JSON_PRETTY_PRINT);
    }
    else{

    // return response()->json(['response'=>'aircraft_name= '.$aircraft_name.' type= '.$type.' latitude='.$latitude.' longitude='.$longitude.' altitude='.$altitude.' heading='.$heading]);

    $addLocation = aircraftLocations::where('authorization_key', base64_decode($request->authorization_key))->first();
    $addLocation->aircraft_name = strtoupper($request->aircraft_name);
    $addLocation->type = $request->type;
    $addLocation->latitude = $request->latitude;
    $addLocation->longitude = $request->longitude;
    $addLocation->altitude = $request->altitude;
    $addLocation->heading = $request->heading;
    $addLocation->save();

    return json_encode(['response'=>'Location has been transmitted'], JSON_PRETTY_PRINT);
       
    }
}

/* 8.
Control Tower Views all transmitted Locations: GET
*/
public function location_view(){

    if(aircraftLocations::all()->count() == 0){

return json_encode(['response'=>'No Locations available'], JSON_PRETTY_PRINT);
  
    }
    else{

    $FetchAllLocations =json_decode(aircraftLocations::orderby('id', 'desc')->get());
    return $FetchAllLocations;

    }
}


/* 9.
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

/* 10.
Auto clear Generated Flight Call Signs
*/
public function autoclearCallSigns(){

    Artisan::call('migrate:refresh'); //,['--path' => './database/migrations/2024_04_04_132329_create_tasks.php']

    if(FlightCallSigns::all()->count() == 0){

        return response()->json(['response'=>'No Flight Call Sign available']);
        
    }
    
}


/*11.
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

/*12.
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

/*13.
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


/*14.
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


/*15.
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

        $saveLocation = new aircraftLocations();
 
        $saveLocation->aircraft_name = $aircraft_name;
        $saveLocation->type = $type;
        $saveLocation->latitude = $latitude;
        $saveLocation->longitude = $longitude;
        $saveLocation->altitude = $altitude;
        $saveLocation->heading = $heading;
        $saveLocation->save();
 
        return response()->json([ 'response'=>'Location has been transmitted']);
       
    }
}

/*16.
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

/*17.
Ground Crew checks for LANDED aircraft
*/
public function landed_aircrafts(){

    if(aircraftCommunications::where('state', 'LANDED')->count() == 0){

return json_encode(['response'=>'No Landed Aircrafts available'], JSON_PRETTY_PRINT);
  
    }
    else{

    $FetchAllLocations =json_decode(aircraftCommunications::where('state', 'LANDED')->orderby('id', 'desc')->get());
    return $FetchAllLocations;

    }
}

/*18.
Ground Crew PARKs a LANDED aircraft: POST
*/
public function park_landed_aircrafts(Request $request){

    $Expected_spots = array("large", "small");

    if(!$request->aircraft_call_sign){
        return json_encode(['response'=>'Enter Aircraft call sign'], JSON_PRETTY_PRINT);
    }
    elseif(!$request->parking_spot){
        return json_encode(['response'=>'parking spot is required'], JSON_PRETTY_PRINT);
    }
    elseif (!in_array($request->parking_spot, $Expected_spots)) {

        return json_encode(['response'=>'parking spot should be large or small'], JSON_PRETTY_PRINT);

    }
    elseif(aircraftCommunications::where('aircraft_call_sign', $request->aircraft_call_sign)->where('state', 'LANDED')->count() == 0){
//check chosen Aircraft has LANDED

        return json_encode(['response'=>$request->aircraft_call_sign.' has not landed'], JSON_PRETTY_PRINT);
    
        }
    elseif ($request->parking_spot =='large' && (aircraftCommunications::where('parking_spot', 'large')->count() == 5) ) {
//if large, check if large spots are not upto 5, if small, check if spots are not upto 10

    return json_encode(['response'=>'Large parking spots are occupied.'], JSON_PRETTY_PRINT);

    }
    elseif ($request->parking_spot =='small' && (aircraftCommunications::where('parking_spot', 'small')->count() == 5) ) {

        return json_encode(['response'=>'Small parking spots are occupied.'], JSON_PRETTY_PRINT);
    
    }
    else{

    // return json_encode(['response'=>$request->aircraft_call_sign.' is PARKED'], JSON_PRETTY_PRINT);

    $updateToParked = aircraftCommunications::where('aircraft_call_sign', $request->aircraft_call_sign)->first();
    $updateToParked->state = 'PARKED';
    $updateToParked->parking_spot = $request->parking_spot;
    $updateToParked->save();

    return json_encode(['response'=>$request->aircraft_call_sign.' is PARKED'], JSON_PRETTY_PRINT);
    

    }
}


/*19.
Ground Crew checks for LANDED aircraft
*/
public function weatherdata(Request $request){

    if(!$request->city){
        return json_encode(['response'=>'Enter City to get weather data'], JSON_PRETTY_PRINT);
    }
    elseif(!ctype_alpha($request->city)){

     return json_encode(['response'=>'City must be alphabets'], JSON_PRETTY_PRINT);

    }
    else{

//'.$request->city.'
    $getLonLat =file_get_contents('http://api.openweathermap.org/geo/1.0/direct?q='.$request->city.'&limit=5&appid=1a1f91e2241e9056cf2dd4f9cf66e8da');
    $decoded_response=json_decode($getLonLat, true);
    // return $decoded_response[0]['name'].' '.$decoded_response[0]['lat'];
    
    $getWeatherData =file_get_contents('https://api.openweathermap.org/data/2.5/weather?lat='.$decoded_response[0]['lat'].'&lon='.$decoded_response[0]['lon'].'&appid=1a1f91e2241e9056cf2dd4f9cf66e8da');
    $decoded_WeatherData=json_decode($getWeatherData, true);


// return $decoded_WeatherData['weather'][0]['description'] .'  Temperature= '.$decoded_WeatherData['main']['temp'].'  visibility= '.$decoded_WeatherData['visibility'].'  wind_speed='.$decoded_WeatherData['wind']['speed'].'  wind_deg='.$decoded_WeatherData['wind']['deg'].'  last_update=';


    //Add Weather Data into Table
    $saveWeatherData = new weatherinfo();
    $saveWeatherData->city = $request->city;
    $saveWeatherData->description = $decoded_WeatherData['weather'][0]['description'];
    $saveWeatherData->temperature = $decoded_WeatherData['main']['temp'];
    $saveWeatherData->visibility = $decoded_WeatherData['visibility'];
    $saveWeatherData->wind_speed = $decoded_WeatherData['wind']['speed'];
    $saveWeatherData->wind_deg = $decoded_WeatherData['wind']['deg'];
    $saveWeatherData->save();


return json_encode([
    'description'=>$decoded_WeatherData['weather'][0]['description'],
    'temperature'=>$decoded_WeatherData['main']['temp'],
    'visibility'=>$decoded_WeatherData['visibility'],
    'wind'=>[
        'speed'=>$decoded_WeatherData['wind']['speed'],
        'deg'=>$decoded_WeatherData['wind']['deg'],
    ]
    //,"last_update"=>''
], JSON_PRETTY_PRINT);


/*
    $url = "http://api.openweathermap.org/geo/1.0/direct?q=Accra&limit=5&appid=1a1f91e2241e9056cf2dd4f9cf66e8da";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_POST, 0);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $response = curl_exec ($ch);
     $err = curl_error($ch);  //if you need
     curl_close ($ch);

    //  $decoded_response=json_decode($response, true);
    //  return $decoded_response[0]['lat'];
    */
  }

}

/*20
view fetched weather data: GET
*/
public function viewweatherdata(){
    if(weatherinfo::all()->count() == 0){

        return json_encode(['response'=>'No Weather info available'], JSON_PRETTY_PRINT);
    
        }
        else{
       
        $FetchCommunications =json_decode(weatherinfo::orderby('id', 'desc')->get());
        return $FetchCommunications;
        /*
        return json_encode([
            'city'=>$FetchCommunications->city,
            'description'=>$FetchCommunications->description,
            'temperature'=>$FetchCommunications->temperature,
            'visibility'=>$FetchCommunications->visibility,
            'wind'=>[
                'speed'=>$FetchCommunications->wind_speed,
                'deg'=>$FetchCommunications->wind_deg
            ],
            "last_update"=>$FetchCommunications->created_at
        ], JSON_PRETTY_PRINT);
        */

       
        }
}



}
