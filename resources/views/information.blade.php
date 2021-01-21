@extends('layouts.appFront')
@section('content')

<div class="container mainHomePageContainer pt-3 pb-3" style="">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-5"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="aboutUsDiv mb-5">
    	<div class="aboutUsCardCss col-md-12 col-lg-12 row" style="background: #FED8C6;padding-left: 5%;padding-bottom: 0px;">
    		<div class="col-md-6 col-lg-6 mt-4">
    			<h4 class="mb-5"> We are here to help you! </h5>

    			<div class="row">
    				<a href="{{url('orgInfo')}}">
                	<input type="button" id="" class="clickable createEventButton buttonMobileSize orgInfoButton" value="I'm an Organizer!" style=""></a>
                	<a href="#">
                	<input type="button" id="" class="clickable createEventButton buttonMobileSize ml-3 userInfoButton" value="I'm a User!" style=""></a>
            	</div>

    		</div>

    		<div class="col-md-6 col-lg-6">
    			<img src="assets/images-new/infoBanner.jpg" class="w-100">
    		</div>
			
    	</div>
    </div>

    <div class="col-md-9 featuredContent mb-4 d-block" style="">
    	<h4 class="mb-3" style="color: #FD6568;font-weight:bold;"> For Organizers </h4>

    	<div class="mb-3">
    		<h5> How to create an event? </h5>
    		<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    	</div>

    	<div class="mb-3">
    		<h5> Feature overview </h5>
    		<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    	</div>

    	<hr>

    	<h4 class="mb-3" style="color: #FD6568;font-weight:bold;"> For Users </h4>

    	<div class="mb-3">
    		<h5> How to order a ticket? </h5>
    		<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    	</div>

    	<div class="mb-3">
    		<h5> Troubleshooting for ticket purchase </h5>
    		<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    	</div>


    </div>

</div>


@endsection