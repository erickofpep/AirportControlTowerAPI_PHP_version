//Aircraft initiates communication: PUT
<br />
http://127.0.0.1:8080/api/initiate/communication
<br />
{
<br />
  "authorization_key": "NA8930dafdadfad=="
  <br />
}

//Aircraft sends communication: PUT
<br />
When aircraft is parked, Ground Crew communicates the PARKED state internally with the control tower (not via API).
<br />
http://127.0.0.1:8080/api/send/communication
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

//Control Tower Views all Communication: GET
<br />
http://127.0.0.1:8080/api/view_communications

//Control Tower's Answer to a request: PUT
<br />
http://127.0.0.1:8080/api/send/response
<br />
{
<br />
"authorization_key": "",
"outcome": "" //ACCEPTED or REJECTED
<br />
}


//View all State change attempts: GET
http://127.0.0.1:8080/api/public/stateChangeAttempts

//Response to State Change: POST
http://127.0.0.1:8080/api/public/statechangeResponse
{
"state_change_id": "1", //Refer state_ids of /api/public/stateChangeAttempts
"outcome": "APPROACH" //ACCEPTED or REJECTED
}

//aircraft sends current position: PUT
http://127.0.0.1:8080/api/sendLocation
{
"aircraft_name": "NA8930",
"type": "AIRLINER|PRIVATE",
"latitude": "44.82128505247063",
"longitude": "20.455516172478386",
"altitude": 3500,
"heading": 220
}

//view transmitted locations: GET
http://127.0.0.1:8080/api/public/aircraftLocations


//Auto Generate Flight Call Signs: GET
http://127.0.0.1:8080/api/public/addcallSigns

// Auto clear Generated Flight Call Signs: POST
http://127.0.0.1:8080/api/public/clearcallsigns

//View all Flight Call Signs: GET
http://127.0.0.1:8080/api/public/flight_callSigns

//Flight Call Sign request: POST
http://127.0.0.1:8080/api/public/intent
