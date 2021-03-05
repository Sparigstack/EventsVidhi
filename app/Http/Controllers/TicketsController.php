<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Session;
use Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Event;
use App\Ticket;
use App\PaymentInfo;
use DB;
use App\Mail\Email;
use Mail;
use App\CustomClass\MailContent;

class TicketsController extends Controller
{
	public function ticketDetails($eventid){
		$ticketDetail = Ticket::where("event_id", $eventid)->orderBy("id" , "ASC")->get();
		$eventRecord = Event::where("id", $eventid)->first();

		return view("ticketDetails", compact('ticketDetail', 'eventRecord'));
	}

	public function ticketCheckout(Request $request,$eventid, $total, $tids, $tqty){
		return view("ticketCheckout", compact('eventid', 'total' , 'tids' , 'tqty'));
	}

	public function purchaseTicket(Request $request){
		Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            //add customer to stripe
            $user = Auth::user();
            if($user->stripe_customer_id == ""){
                $customer = \Stripe\Customer::create(array(
                        'email' => $request->email,
                        'name' => $request->name_on_card,
                        'source' => $request->stripeToken
                ));

                $users = User::findOrFail($user->id);
                $users->stripe_customer_id = $customer->id;
                $users->save();
            } else {
                //retrieve customer id
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            }

            $totalPrice = $request->selectedPrice;

            //create charge
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount' => $totalPrice * 100,
                'currency' => "usd",
                'description' => "New Payment From ". $request->name_on_card
                //'source' => $request->stripeToken
            ));


            Session::flash('success', 'Payment done successfully !');
            $success = "Payment done successfully !";

            $eventId = $request->eventId;

            $b = array();

            //update ticket quantity
            if( strpos($request->tktId, ',') !== false ) {
                $ticketId = explode(',' , $request->tktId);
            } else {
                $ticketId = array();
                array_push($ticketId, $request->tktId);
            }

            if( strpos($request->tktQty, ',') !== false ) {
                $ticketQty = explode(',', $request->tktQty);
            } else {
                $ticketQty = array();
                array_push($ticketQty, $request->tktQty);
            }

            $ticketDetail = Ticket::whereIn("id" , $ticketId)->get();
            $tQty = 0;

            foreach($ticketDetail as $ticketDetails){
            	if(in_array($ticketDetails->id, $ticketId)) {            			
            		if(count($ticketQty) > 0) {
            			$ticketUpdate = Ticket::where("id" , $ticketDetails->id)->first();
            			$ticketUpdate->quantity = $ticketUpdate->quantity - $ticketQty[$tQty];
            			$ticketUpdate->save();
            			$tQty++;
            			continue;
            		}
            	}
            }

            //save stripe related data
            $paymentInfo = new PaymentInfo;
            $paymentInfo->event_id = $eventId;
            $paymentInfo->user_id = Auth::id();
            $paymentInfo->amount = $totalPrice;
            $paymentInfo->transaction_id = $charge->id;
            $paymentInfo->stripe_customer_id = $customer->id;
            $paymentInfo->save();

            //mail sent to user
            $eventDetails = Event::where("id" , $eventId)->first();

            $sdStamp = strtotime($eventDetails->date_time);
        	$sd = date("d M, Y", $sdStamp);
        	$st = date('H:i A', $sdStamp);
        	$dateStr = date("d M, Y", $sdStamp) . ' ' . $st;

            $mail_content = new MailContent();
            $mail_content->user_name = Auth::user()->name;
            $mail_content->event_title = $eventDetails->title;
            $mail_content->org_name = $eventDetails->user->name;
            $mail_content->event_datetime = $dateStr;
            $mail_content->event_id = $eventDetails->id;
            $mail_content->transaction_id = $charge->id;
            $data = ['view' => 'mails.ticketConfirmation', 'mail_content' => $mail_content, 'subject' => 'Payment done successfully!'];
            $emailOb = new Email($data);
            //$request->email
            //Mail::to("team.sprigstack@gmail.com")->send($emailOb);

            return redirect("ticketPaymentConfirm/". $eventId);
        } catch (Exception $e) {
            Session::flash('fail_message', "Error! Please Try again.");
            return $e;
        }
	}
}