<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Aircraft Retrieves response from Control Tower: PUT
*/
Route::put('/initiate/location', 'API\RequestsController@initiateLocation');

/*
Aircraft sends location: PUT
*/
Route::put('/send/location', 'API\RequestsController@location_send');

/*
Control Tower Views all Locations transmitted: GET
*/
Route::get('/view/locations', 'API\RequestsController@location_view');


/*
Ground Crew checks for LANDED aircraft: GET
*/
Route::get('/view/landed_aircrafts', 'API\RequestsController@landed_aircrafts');


/*Aircraft sends communication: PUT
When aircraft is parked, Ground Crew communicates the PARKED state internally with the control tower (not via API).
*/
Route::put('/send/communication', 'API\RequestsController@sendCommunication');


/*
Control Tower Views all Communications
*/
Route::get('/view_communications', 'API\RequestsController@view_communications');

/*
Control Tower's Answer to a request
*/
Route::put('/send/response', 'API\RequestsController@sendResponse');

/*
//Retrieve response from Control Tower
*/
Route::put('/receive/response', 'API\RequestsController@receiveResponse');


/*
//Auto Generate Flight Call Signs
*/
Route::get('/public/addcallSigns', 'API\RequestsController@addcallSigns');

/*
// Auto clear Generated Flight Call Signs
*/
Route::post('/public/clearcallsigns', 'API\RequestsController@autoclearCallSigns');

//View all Flight Call Signs
Route::get('/public/flight_callSigns', 'API\RequestsController@flight_callSigns');

/**
 * Flight Call Sign request
 * {NIUYWYW}
 */
Route::post('/public/intent', 'API\RequestsController@intent');

/***
 * View all State change attempts
 */
Route::get('/public/stateChangeAttempts', 'API\RequestsController@stateChangeAttempts');

/***
 * Respond to State Change
 */
Route::post('/public/statechangeResponse', 'API\RequestsController@respondToStateChange');


/***
 * send aircraft location
 */
Route::put('/sendLocation', 'API\RequestsController@sendLocation');


/***
 * view aircraft location
 */
Route::get('/public/aircraftLocations', 'API\RequestsController@aircraftLocationsView');

/*
Ground Crew checks for LANDED aircraft: POST
*/
Route::post('/public/weather', 'API\RequestsController@weatherdata');

/*
view all fetched weather data: GET
*/
Route::get('/public/view_weather_info', 'API\RequestsController@viewweatherdata');
/*


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/