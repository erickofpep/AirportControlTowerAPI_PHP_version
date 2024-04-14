<?php

namespace App\Http\Controllers;

use App\User;
use App\FlightCallSigns;
use App\StateChangeAttempts;
use App\aircraftLocations;
use App\aircraftCommunications;
use App\weatherinfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

/*
 User Register method
 */    
    public function register(Request $request) {

        $validator = $request->validate([
            "firstname"    => "required|string|min:3|max:50",
            "lastname"  => "required|string|min:3|max:50",
            "email"  => "email|required|unique:users",
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4'
        ]);

        $task_user = new User();
 
        $task_user->firstname = $request->firstname;
        $task_user->lastname = $request->lastname;
        $task_user->email = $request->email;
        $task_user->password = Hash::make($request->password);
        $task_user->save();
        
        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {

            return redirect()->intended('dashboard')->with('success', 'Welcome!');
        }
        else{
            return redirect()->back()->with('error', 'Invalid Login details. Please try again');
        }

    }

/*
 User Login method
 */
    public function user_login(Request $request) {
        
        $validator = $request->validate([
            "email"  => "email|required",
            'password' => 'required|min:4'
        ]);

        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {
           
            return redirect()->intended('dashboard')->with('success', 'Welcome!');
        }
        else{
            return redirect()->back()->with('error', 'Invalid Login details. Please try again');
        }

    }


/*
Show fetched weather data
*/
public function viewWeatherData(){

// $fetchweatherdata =weatherinfo::paginate(5);//all()->orderBy('id', 'desc')->
// return $fetchweatherdata;

// return view('weatherdata', compact('hello'));

// $employees = weatherinfo::all(); return view('weatherdata', ['hello' => $employees]);

/*
$users = DB::table('weatherinfos')->get();
//  return $users;
return view('weatherdata', ['hello' => $users]);
*/

/*
$results = weatherinfo::orderBy('id', 'desc')->get();
return view('weatherdata', ['results' => $results]);
*/

}


public function weatherData_page(){
return view('weatherdata');
}

public function parkingOverview(){

$fetchWeather= aircraftCommunications::where('state', 'PARKED')->orderBy('id', 'desc')->paginate(5);
return view('parking', ['fetchWeather' => $fetchWeather]);
// return view('parking');
}


public function showhome(){
 return view('welcome');
}






}