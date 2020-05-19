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
    return view('home');
});

//Route::resource('events', 'EventsController');
Route::get('events', 'EventsController@index');
Route::get('events/{eventid}', 'EventsController@show');


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

///All routes for Organizer panel will be here.
Route::get('org/events', 'org\EventsController@index')->name('orgEvents');
Route::get('org/pastEvents', 'org\EventsController@pastEvents');
Route::get('org/events/new', 'org\EventsController@create')->name('newEvent');;
Route::get('org/events/{eventid}/{tabe?}', 'org\EventsController@edit');
Route::post('org/events/store', 'org\EventsController@store');
Route::post('deleteEvent', 'org\EventsController@destroy');
Route::post('org/events/edit/{id}', 'org\EventsController@update');
Route::post('org/events/videos/store', 'org\EventsController@storeVideo');
Route::post('org/events/update', 'org\EventsController@UpdateEventStatus');


Route::get('org/videos', 'org\VideosController@index');
Route::get('org/videos/new', 'org\VideosController@create');
Route::post('org/videos/store', 'org\VideosController@store');
Route::post('org/videos/update', 'org\VideosController@update');

Route::post('getState', 'org\EventsController@getState');
Route::post('getCity', 'org\EventsController@getCity');