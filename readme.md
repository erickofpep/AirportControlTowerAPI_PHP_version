//Aircraft initiates communication: PUT
<br />
HOST/api/initiate/communication
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

//Control Tower Views all Communication: GET
<br />
HOST/api/view_communications

//Control Tower's Answer to a request: PUT
<br />
HOST/api/send/response
<br />
{
<br />
"authorization_key": "",
"outcome": "" //ACCEPTED or REJECTED
<br />
}


//Retrieve response from Control Tower: PUT
<br />
HOST/api/receive/response
<br />
{
<br />
"authorization_key": ""
<br />
}



//View all State change attempts: GET
HOST/api/public/stateChangeAttempts

//Response to State Change: POST
HOST/api/public/statechangeResponse
{
"state_change_id": "1", //Refer state_ids of /api/public/stateChangeAttempts
"outcome": "APPROACH" //ACCEPTED or REJECTED
}

//aircraft sends current position: PUT
HOST/api/sendLocation
{
"aircraft_name": "NA8930",
"type": "AIRLINER|PRIVATE",
"latitude": "44.82128505247063",
"longitude": "20.455516172478386",
"altitude": 3500,
"heading": 220
}

//view transmitted locations: GET
HOST/api/public/aircraftLocations


//Auto Generate Flight Call Signs: GET
HOST/api/public/addcallSigns

// Auto clear Generated Flight Call Signs: POST
HOST/api/public/clearcallsigns

//View all Flight Call Signs: GET
HOST/api/public/flight_callSigns

//Flight Call Sign request: POST
HOST/api/public/intent
