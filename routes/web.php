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

//Route::resource('events', 'EventsController');
Route::get('events', 'EventsController@index');
Route::get('events/{eventid}', 'EventsController@show');


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

///All routes for Organizer panel will be here.
Route::get('org/events', 'org\EventsController@index');
Route::get('org/events/new', 'org\EventsController@create');
Route::get('org/events/{eventid}', 'org\EventsController@show');
Route::post('org/events/store', 'org\EventsController@store');
Route::post('org/events/edit/{id}', 'org\EventsController@edit');