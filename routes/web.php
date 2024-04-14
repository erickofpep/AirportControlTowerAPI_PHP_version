<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', 'RegisterController@register')->name('register');

Route::post('/login', 'RegisterController@user_login')->name('login');

Route::get('/login', 'RegisterController@showhome')->name('login');


Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard')->middleware('auth');

Route::get('/weatherdata', 'RegisterController@weatherData_page')->name('weatherdata')->middleware('auth');;

Route::get('/parking', 'RegisterController@parkingOverview')->name('parking')->middleware('auth');;

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
