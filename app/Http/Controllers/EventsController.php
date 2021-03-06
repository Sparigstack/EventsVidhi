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
