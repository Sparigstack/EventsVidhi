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

//All routes for Aunthentication will be here.
// Auth::routes();
Auth::routes(['verify' => true]);
Route::post('loginCheck', 'Auth\LoginController@determineLoginType')->middleware('guest');
Route::get('userRegister', function () {
    return view('auth/register');
});
Route::get('forgotPassword', function () {
    return view('auth/passwords/forgotPassword');
});

//All routes for Organizer Panel will be here.
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
Route::post('org/events/updateSpeaker/{id}', 'org\EventsController@updateSpeaker');
Route::post('org/events/speaker/deleteProfilePic', 'org\EventsController@deleteProfilePic');
Route::post('org/events/podcast/store', 'org\EventsController@storePodcast');
Route::post('org/events/ticket/store', 'org\EventsController@storeTicket');
Route::post('org/events/editTicket/{id}', 'org\EventsController@editTicket');
Route::post('org/events/updateTicket/{id}', 'org\EventsController@updateTicket');
Route::post('org/events/deleteTicket/{id}/{Type}/{UrlType}', 'org\EventsController@destroyVideo');
Route::post('copyEvent', 'org\EventsController@copyEvent');
Route::post('saveCustomUrl', 'org\EventsController@saveCustomUrl');
Route::get('org/eventPreview/{eventid}', 'org\EventsController@eventPreview');

Route::get('org/videos', 'org\VideosController@index');
Route::get('org/videos/new', 'org\VideosController@create');
Route::post('org/videos/store', 'org\VideosController@store');
Route::post('org/videos/store_demo', 'org\VideosController@store_demo');
Route::get('org/videos/{videoid}', 'org\VideosController@edit');
Route::post('org/videos/edit/{id}', 'org\VideosController@update');
Route::post('deleteVideo', 'org\VideosController@destroy');

Route::get('org/podcasts', 'org\PodcastsController@index');
Route::get('org/podcasts/new', 'org\PodcastsController@create');
Route::post('org/podcasts/store', 'org\PodcastsController@store');
Route::get('org/podcasts/{podcastid}', 'org\PodcastsController@edit');
Route::post('org/podcasts/edit/{podcastid}', 'org\PodcastsController@update');
Route::post('deletePodcast', 'org\PodcastsController@destroy');

// Route::get('org/contacts', 'org\ContactsController@index');
Route::get('org/my_contacts/{tag_ids?}', 'org\ContactsController@index');
Route::get('org/contacts/new', 'org\ContactsController@create');
Route::post('org/contacts/store', 'org\ContactsController@store');
Route::get('org/contacts/edit/{contactid}', 'org\ContactsController@edit');
Route::post('org/contacts/update/{contactid}', 'org\ContactsController@update');
Route::post('deleteContact', 'org\ContactsController@destroy');
Route::post('deleteSelectedContacts', 'org\ContactsController@deleteSelectedContacts');
Route::post('org/contact/approve/{id}', 'org\ContactsController@approve');

Route::post('getState', 'org\EventsController@getState');
Route::post('getCity', 'org\EventsController@getCity');

Route::get('org/profile', function () {
    return view('org/profileList');
});
Route::get('org/profile/{id}','org\ProfileController@index');
Route::post('org/profile/update', 'org\ProfileController@update');

Route::get('org/tags', 'org\TagsController@show');
Route::post('org/tags/store', 'org\TagsController@store');
Route::post('org/tags/delete/{id}', 'org\TagsController@Delete');
Route::get('org/tags/{value}', 'org\TagsController@GetTagsByValue');

Route::get('org/customFields', 'org\CustomFieldController@Index');
Route::post('org/customfield/store', 'org\CustomFieldController@store');
Route::get('org/customFields/edit/{id}', 'org\CustomFieldController@edit');
Route::post('org/customFields/update/{id}', 'org\CustomFieldController@update');
Route::post('org/customfield/delete/{id}', 'org\CustomFieldController@delete');
Route::post('org/setting/update', 'org\SettingController@update');

Route::get('userProfile', function () {
    return view('userProfileList');
});
Route::get('userProfile/{id}','UserController@index');
Route::post('userProfile/update', 'UserController@update');

Route::get('org/pricingPlans', function () {
    return view('org/pricingPlans');
});

Route::get('myAccount', 'UserController@show');
Route::post('org/csv/import', 'org\CsvImportController@store');
Route::get('account', function () {
    return view('account');
});
Route::get('org/csvImport', 'org\CsvImportController@index');
Route::get('org/settings','org\SettingController@index');

Route::get('org/regForms', 'org\RegistrationFormController@index');
Route::get('org/regForm/new', 'org\RegistrationFormController@create');
Route::post('org/regForm/store', 'org\RegistrationFormController@store');
Route::get('org/regForm/{regFormid}', 'org\RegistrationFormController@edit');
Route::post('org/regForm/edit/{regFormid}', 'org\RegistrationFormController@update');
Route::post('deleteRegForm', 'org\RegistrationFormController@destroy');
Route::post('deleteThisQue', 'org\RegistrationFormController@deleteThisQue');

Route::post('saveUserAnswers', 'HomeController@saveUserAnswers');


//All routes for Admin Panel will be here.
Route::get('organizers', 'UserController@orgList');
Route::get('orgEvents', 'UserController@orgEventsList');
Route::get('orgEvents/{id}', 'UserController@orgEventsList');
Route::post('updateIsFeaturedEvent', 'org\EventsController@updateIsFeaturedEvent');
Route::get('saveOrgFollower', 'HomeController@saveOrgFollower');

//All routes according to new UI will be here.
Route::get('/', 'HomeController@indexPage');
Route::get('/{tabId}/{categoryId}/page={pageCount}', 'HomeController@indexPage');

Route::get('allContent/{tabId}/{categoryId}/{searchName}/page={pageCount}', 'HomeController@allContent');

Route::get('events/{eventid}', 'HomeController@eventDetail');
Route::get('videos/{videoid}', 'HomeController@videoDetail');
Route::get('podcasts/{podcastid}', 'HomeController@podcastDetail');
Route::get('organizer/{orgid}', 'HomeController@organizerDetail');

Route::post('saveEventFollower', 'HomeController@saveEventFollower');
Route::post('saveOrgFollower', 'HomeController@saveOrgFollower');

Route::post('saveUserSuggestion', 'HomeController@saveUserSuggestion');

Route::get('myContent', 'UserController@myContent');

Route::get('aboutUs', function () {
    return view('aboutUs');
});
Route::get('information', function () {
    return view('information');
});
Route::get('orgInfo', function () {
    return view('orgInfo');
});
Route::get('createEventInfo', function () {
    return view('createEventInfo');
});
Route::get('featureOverview', function () {
    return view('featureOverview');
});
Route::get('pricingPlans','HomeController@pricingPlan');
Route::get('contactUs', function () {
    return view('contactUs');
});
Route::get('whyBecomeOrg', function () {
    return view('whyBecomeOrg');
});
Route::get('eventRegConfirm/{eventid}/{userid}','UserController@eventRegConfirm');
Route::get('ticketPaymentConfirm/{eventid}','UserController@ticketPaymentConfirm');

//Upgrade Plan Routes
Route::get('planDetails/{id}','org\UpgradePlanController@planDetails');
Route::get('payment/{id}/{type}', 'org\UpgradePlanController@payment');
Route::post('upgradePlan', 'org\UpgradePlanController@upgradePlan')->name('stripe.post');
Route::get('planUpgradation', function () {
    return view('planUpgradation');
});

//webhook call for recurringSubscription
Route::get('updateRecurringSubscription', 'org\UpgradePlanController@updateRecurringSubscription');
Route::stripeWebhooks('recurringSubscription');
Route::post('cancelSubscription', 'org\UpgradePlanController@cancelSubscription');

//Ticket Purchase Routes
Route::get('ticketDetails/{eventid}', 'TicketsController@ticketDetails');
Route::get('ticketCheckout/{eventid}/{amount}/{tids}/{tqty}', 'TicketsController@ticketCheckout');
Route::post('purchaseTicket', 'TicketsController@purchaseTicket')->name('stripe.post1');

Route::post('getRegisterAnsData/{userid}/{eventid}', 'org\EventsController@getRegisterAnsData');