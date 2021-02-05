<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
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
                        'source' => $request->stripeToken
            ));

            $planName = $request->planName;
            $planId = $request->planId;
            $db_plan_id = "";
            $planIdName = "";
            $selectedPlan= "";
            $planDuration = "";
            $benefits = "";

            if ($planName == "yearly") {
                if($planId == 2){
                    $db_plan_id = 2;
                    $planIdName = "price_1IGgDVEQcfgVhdcDtNAbf90p";
                    $selectedPlan = "Plus Yearly Plan";
                    $benefits = "10 gb of cloud space to upload & showcase content";
                } else {
                    $db_plan_id = 4;
                    $planIdName = "price_1IGgIDEQcfgVhdcDihMv5OTn";
                    $selectedPlan = "Premium Yearly Plan";
                    $benefits = "Unlimited of cloud space to upload & showcase content";
                }
                $planDuration = "year";
            } elseif ($planName == "monthly") {
                if($planId == 2){
                    $db_plan_id = 1;
                    $planIdName = "price_1IGfvfEQcfgVhdcDWAnM9cZn";
                    $selectedPlan = "Plus Monthly Plan";
                    $benefits = "10 gb of cloud space to upload & showcase content";
                } else {
                    $db_plan_id = 3;
                    $planIdName = "price_1IGgFwEQcfgVhdcDe53zaX9a";
                    $selectedPlan = "Premium Monthly Plan";
                    $benefits = "Unlimited of cloud space to upload & showcase content";
                }
                 $planDuration = "month";
            }

            //create subscription
            $subscription = \Stripe\Subscription::create([
                        "customer" => $customer->id,
                        "items" => [
                            [
                                "plan" => $planIdName,
                            ],
                        ]
            ]);

            $start_date = date("m-d-Y");
            if ($db_plan_id == 1 || $db_plan_id == 3) {
                $expiry_date = date('Y-m-d', strtotime($start_date . ' + 31 days'));
            } else if ($db_plan_id == 2 || $db_plan_id == 4) {
                $expiry_date = date('Y-m-d', strtotime($start_date . ' + 365 days'));
            }

            $userid = Auth::id();
            $user = User::find($userid);
            $user->plan_id = $db_plan_id; //plan_id from plans table
            $user->transaction_id = $subscription->id;
            $user->expiry_date = $expiry_date;
            $user->save();

            Session::flash('success', 'Payment done successfully !');
            $success = "Payment done successfully !";

            $user = Auth::user();
            $subscriptionid = $subscription->id;
            $amount = $request->selectedPrice;

            $mail_content = new MailContent();
            //$mail_content->transaction_id = $subscriptionid;
            $mail_content->planName = $selectedPlan;
            $mail_content->expiry_date = $expiry_date;
            $mail_content->amount = $amount;
            $mail_content->planDuration = $planDuration;
            $mail_content->benefits = $benefits;
            $data = ['view' => 'mails.upgradePlan', 'mail_content' => $mail_content, 'subject' => 'Upgrade Plan Successfully'];
            $emailOb = new Email($data);
            // team.sprigstack@gmail.com
            Mail::to($request->email)->send($emailOb);

            return view('planUpgradation');
        } catch (Exception $e) {
            Session::flash('fail_message', "Error! Please Try again.");
            return $e;
        }
    }

    public function updateRecurringSubscription($webhookRequest){
        $subscriptionid = $webhookRequest['data']['object']['lines']['data'][0]['subscription'];
        $planInterval = $webhookRequest['data']['object']['lines']['data'][0]['price']['recurring']['interval'];
        
        $transactionid = User::where('transaction_id', $subscriptionid)->first();
        $db_expiry_date = "";

        if($transactionid){
            $db_expiry_date = $transactionid->expiry_date;
            if($planInterval == "month"){
                $expiry_date = date('Y-m-d', strtotime($db_expiry_date . ' + 31 days'));
            } else {
            $expiry_date = date('Y-m-d', strtotime($db_expiry_date . ' + 365 days'));
            }

            $user = User::findOrFail($transactionid->id);
            $user->expiry_date = $expiry_date;
            $user->save();
        }
    }

    public function cancelSubscription(Request $request){
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        //cancel subscription in stripe
        $sub = \Stripe\Subscription::retrieve($getUser->transaction_id);
        $sub->cancel();

        //Update plan_id to basic plan
        $userId = $request->userId;
        $getUser = User::findOrFail($userId);
        $getUser->plan_id = 5;
        $getUser->save();
    }
}