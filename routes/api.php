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
 * Flight Call Sign request route
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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
