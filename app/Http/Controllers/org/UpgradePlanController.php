<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Plan;
use App\User;
use App\Mail\Email;
use Mail;
use App\CustomClass\MailContent;

class UpgradePlanController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function planDetails($id){
        $plans = Plan::orderBy('id', 'ASC')->get();
        return view('planDetails', compact('id', 'plans'));
    }

    public function payment($id,$type){
        return view('payment', compact('id', 'type'));
    }

    public function upgradePlan(Request $request){
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            //add customer to stripe
            $customer = \Stripe\Customer::create(array(
                        'email' => $request->email,
                        'name' => $request->name_on_card,
                        'source' => $request->stripeToken,
                        'address' => [
    //'line1' => '510 Townsend St',
    //'postal_code' => '98140',
    //'city' => 'San Francisco',
    //'state' => 'CA',
    //'country' => 'US'
                        	'line1' => '510 Townsend St',
    'postal_code' => '380001',
    'city' => 'Ahmedabad',
    'state' => 'Gujarat',
    'country' => 'India'
  ],
            ));

            $planName = $request->planName;
            $planId = $request->planId;
            $db_plan_id = "";
            $planIdName = "";

            if ($planName == "yearly") {
                if($planId == 2){
                    $db_plan_id = 2;
                    $planIdName = "price_1IGNFpIO92oFYq9N5PfkuYFA";
                } else {
                    $db_plan_id = 4;
                    $planIdName = "price_1IGHqFIO92oFYq9Nn9iSevkI";
                }
            } elseif ($planName == "monthly") {
                if($planId == 2){
                    $db_plan_id = 1;
                    $planIdName = "price_1IGHkOIO92oFYq9NS5iG0E43";
                } else {
                    $db_plan_id = 3;
                    $planIdName = "price_1IGHoiIO92oFYq9NqLtq648g";
                }
            }

            //create subscription
            $subscription = \Stripe\Subscription::create([
                        "customer" => $customer->id,
                        "items" => [
                            [
                                "plan" => $planIdName,
                                // $planId
                            ],
                        ]
            ]);

            //var_dump($subscription);return;

            $start_date = date("m/d/y H:i:s");
            // if (count($space->space_payments) > 0) {
            //     $latest_payment = $space->latest_payment;
            //     $start_date = $latest_payment->plan_expiry;
            // }

            if ($db_plan_id == 1 || $db_plan_id == 3) {
                $expiry_date = date('y/m/d H:i:s', strtotime($start_date . ' + 30 days'));
            } else if ($db_plan_id == 2 || $db_plan_id == 4) {
                $expiry_date = date('y/m/d H:i:s', strtotime($start_date . ' + 365 days'));
            }

            $userid = Auth::id();
            $user = User::find($userid);
            $user->plan_id = $db_plan_id; //plan_id from plans table
            $user->transaction_id = $subscription->id;
            $user->expiry_date = $expiry_date;
            //$user->save();

            Session::flash('success', 'Payment done successfully !');
            $success = "Payment done successfully !";

            $user = Auth::user();
            $subscriptionid = $subscription->id;
            $amount = $request->selectedPrice;

            $mail_content = new MailContent();
            $mail_content->user_name = Auth::user()->name;
            $mail_content->transaction_id = $subscriptionid;
            $data = ['view' => 'mails.upgradePlan', 'mail_content' => $mail_content, 'subject' => 'Upgrade Plan Successfully !'];
            $emailOb = new Email($data);
            // $request->email
            //Mail::to("team.sprigstack@gmail.com")->send($emailOb);

            return view('planUpgradation');
            // compact('amount', 'subscriptionid', 'success', 'planName', 'user')
        } catch (Exception $e) {
            Session::flash('fail_message', "Error! Please Try again.");
            return $e;
        }
    }
}