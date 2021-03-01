<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Event;
use App\Ticket;
use DB;

class TicketsController extends Controller
{
	public function ticketDetails($eventid){
		$ticketDetail = Ticket::where("event_id", $eventid)->get();
		$eventRecord = Event::where("id", $eventid)->first();

		return view("ticketDetails", compact('ticketDetail', 'eventRecord'));
	}

	public function ticketCheckout(Request $request,$eventid){
		return view("ticketCheckout");
	}
}