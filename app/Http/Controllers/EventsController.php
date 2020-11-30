<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\ContentFollower;
use App\FailedJob;

class EventsController extends Controller
{
    public function __construct() {
        // $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function myEvents(){
        $user = Auth::user();
        $events = DB::table('events')->select('events.*', 'content_followers.content_id as eventFollowEventId' , 'users.profile_pic', 'users.name')->join('users', 'events.user_id', '=', 'users.id')->join('content_followers', 'events.id', '=', 'content_followers.content_id')->where('content_followers.user_id', $user->id)->get();
        $eventFollowersList = ContentFollower::all();
        return view('myEvents', compact('events', 'eventFollowersList'));
    }


    // public function index($eventid)
    // {
    //     // $events = FailedJob::all();
    //     // return view('events', compact('events'));
    //     $event = Event::find($eventid);
    //     $countryName = DB::table('events')->select('countries.name')->join('countries', 'events.country_id', '=', 'countries.id')->where('events.id', $eventid)->first();
    //     $eventsList = Event::where('date_time', '>=', date('Y-m-d', strtotime(now())))->take(4)->orderBy('id', 'DESC')
    //         ->get();
    //     return view('eventDetail', compact('event', 'eventsList', 'countryName'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         //return view('createEvent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($eventid)
    {
        $event = FailedJob::find($eventid);
        return view('eventDetail', compact('event'));
        //return 'got event id here'.$eventid;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
