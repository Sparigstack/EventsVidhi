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
Route::post('org/events/deleteVideo/{id}/{Type}/{UrlType}', 'org\EventsController@destroyVideo');
Route::post('org/events/speaker/store', 'org\EventsController@storeSpeaker');
Route::post('org/events/deleteSpeaker/{id}/{Type}/{UrlType}', 'org\EventsController@destroyVideo');
Route::post('org/events/editSpeaker/{id}', 'org\EventsController@editSpeaker');
Route::post('org/events/speaker/deleteProfilePic', 'org\EventsController@deleteProfilePic');
Route::post('org/events/podcast/store', 'org\EventsController@storePodcast');

Route::get('org/videos', 'org\VideosController@index');
Route::get('org/videos/new', 'org\VideosController@create');
Route::post('org/videos/store', 'org\VideosController@store');
Route::get('org/videos/{videoid}', 'org\VideosController@edit');
Route::post('org/videos/edit/{id}', 'org\VideosController@update');
Route::post('deleteVideo', 'org\VideosController@destroy');

Route::get('org/podcasts', 'org\PodcastsController@index');
Route::get('org/podcasts/new', 'org\PodcastsController@create');
Route::post('org/podcasts/store', 'org\PodcastsController@store');
Route::get('org/podcasts/{podcastid}', 'org\PodcastsController@edit');
Route::post('org/podcasts/edit/{podcastid}', 'org\PodcastsController@update');
Route::post('deletePodcast', 'org\PodcastsController@destroy');

Route::post('getState', 'org\EventsController@getState');
Route::post('getCity', 'org\EventsController@getCity');