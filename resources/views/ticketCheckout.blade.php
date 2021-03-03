@extends('layouts.appFront')
@section('content')
<?php $v = "1.0.1"; ?>
<div class="container mainHomePageContainer pt-3 pb-5 pl-0 pr-0" style="">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('ticketDetails/'. $eventid)}}" style="color: #9C9C9C;font-weight: 100;" class=""><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="card col-md-8 m-auto container" style="padding: 15px 30px;">
		<form role="form" action="{{ route('stripe.post1') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{env('STRIPE_KEY')}}" id="payment-form">
                                {{ csrf_field() }}

                                <input type="hidden" name="eventId" value="{{$eventid}}">
                                <input type="hidden" name="selectedPrice" class="" id="selectedPrice" value="{{$total}}">
                                <input type="hidden" name="tktId" class="" id="tktId" value="{{$tids}}">
                                <input type="hidden" name="tktQty" class="" id="tktQty" value="{{$tqty}}">

                                <div class="form-group">
                                    <label for="input-1">Name on Card</label>
                                    <input type="text" class="form-control" required id="name_on_card" name="name_on_card" placeholder="Enter Your Name" value="{{Auth::user()->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="input-1">Email</label>
                                    <input type="text" class="form-control" required id="email" name="email" placeholder="Enter Your Email" value="{{Auth::user()->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="input-2">Card Number</label>
                                    <input type="text" autocomplete='off' class="form-control card-number" value="" required name="card-number" size='20' id="card-number" placeholder="Enter Your Card Number">
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label>
                                        <input autocomplete='off' class='form-control required card-cvc' value="" name="card-cvc" id="card-cvc" placeholder='ex. 311' size='4' type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label> <input
                                            class='form-control card-expiry-month' required name="card-expiry-month" value="" id="card-expiry-month" placeholder='MM' size='2'
                                            type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label> <input
                                            class='form-control card-expiry-year' required name="card-expiry-year" value="" id="card-expiry-year" placeholder='YYYY' size='4'
                                            type='text'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-md-12 error form-group d-none'>
                                        <div class='alert-danger alert p-2'>Please correct the errors and try
                                            again.</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" id="" class="clickable createEventButton buttonMobileSize px-5 pull-right" value="Pay Now ${{$total}}" style="padding: 8px 30px;">
                                    <!-- <button type="submit" class="btn createEventButton buttonMobileSize px-5 pull-right" style="font-weight: bold;">Pay Now</button> -->
                                </div>
                             </form>
         </div>

</div>
@endsection
@section('script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="{{asset('/js/payment.js?v='.$v)}}" type="text/javascript"></script>
@endsection