/*1
Aircraft initiates communication: PUT
*/
<br />
HOST/api/initiate/communication
<br />
No Request Body:
<br />
{
<br />
  "authorization_key": "NA8930dafdadfad=="
  <br />
}

/*2
Aircraft sends communication: PUT
*/
<br />
When aircraft is parked, Ground Crew communicates the PARKED state internally with the control tower (not via API).
<br />
HOST/api/send/communication
<br />
Request body:
<br />
{
<br />
"authorization_key": "",
"aircraft_call_sign": "NA8930",
"type": "", //AIRLINER|PRIVATE
"state": "" //AIRBORNE |PARKED | LANDED |TAKE-OFF
<br />
}

/*3
Control Tower Views all Communication: GET
*/
<br />
HOST/api/view_communications

/*4
Control Tower's Answer to a request: PUT
*/
<br />
HOST/api/send/response
<br />
{
<br />
"authorization_key": "",
"outcome": "" //ACCEPTED or REJECTED
<br />
}


/*5
Aircraft Retrieves response from Control Tower: PUT
*/
<br />
HOST/api/receive/response
<br />
{
<br />
"authorization_key": ""
<br />
}

/*6
Aircraft initiates communication on location: PUT
*/
<br />
HOST/api/initiate/location
<br />
No Request Body:

/*7
Aircraft sends location: PUT
*/
<br />
HOST/api/send/location
<br />
Request body:
<br />
{
<br />
"authorization_key": "NA8930",
"aircraft_name": "NA8930",
"type": "AIRLINER",
"latitude": "44.82128505247063",
"longitude": "20.455516172478386",
"altitude": "3500",
"heading": "220"
<br />
}

/*8
Control Tower Views all transmitted Locations: GET
*/
<br />
HOST/api/view/locations
<br />

/*9
View all State change attempts: GET
*/
<br />
HOST/api/public/stateChangeAttempts

/*10
Response to State Change: POST
*/
HOST/api/public/statechangeResponse
{
"state_change_id": "1", //Refer state_ids of /api/public/stateChangeAttempts
"outcome": "APPROACH" //ACCEPTED or REJECTED
}

/*11
aircraft sends current position: PUT
*/
HOST/api/sendLocation
<br />
{
<br />
"aircraft_name": "NA8930",
"type": "AIRLINER|PRIVATE",
"latitude": "44.82128505247063",
"longitude": "20.455516172478386",
"altitude": "3500",
"heading": "220"
<br />
}

/*12
view transmitted locations: GET
*/
<br />
HOST/api/public/aircraftLocations


/*13
Auto Generate Flight Call Signs: GET
*/
<br />
HOST/api/public/addcallSigns

/*14
Auto clear Generated Flight Call Signs: POST
*/
<br />
HOST/api/public/clearcallsigns

/*15
View all Flight Call Signs: GET
*/
<br />
HOST/api/public/flight_callSigns

/*16
Flight Call Sign request: POST
*/
<br />
HOST/api/public/intent


/*17
Ground Crew checks for LANDED aircraft
*/
<br />
HOST/api/view/landed_aircrafts


/*18
Get current weather data: POST
*/
<br />
HOST/api/public/weather
<br />
Request body:
<br />
{
<br />
"city": "1"
<br />
}

/*19
view fetched weather data: GET
*/
<br />
HOST/api/public/view_weather_info



