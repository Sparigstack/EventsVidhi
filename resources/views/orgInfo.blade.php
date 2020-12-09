@extends('layouts.appFront')
@section('content')
<div class="container mainHomePageContainer pt-3 pb-3" style="">

	<div class="col-md-12 col-lg-12 align-items-center mb-3 d-none backBtn" style="display: flex;">
		<a style="cursor: pointer;color: #9C9C9C;font-weight: 100;" class="ml-5 pl-4" onclick="BackButton(this);"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="col-md-12 col-lg-12 align-items-center mb-3 infoDiv" style="display: flex;">
		<a style="cursor: pointer;color: #9C9C9C;font-weight: 100;" href="{{url('information')}}" class="ml-5 pl-4"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="aboutUsDiv mb-5">
    	<div class="aboutUsCardCss col-md-12 col-lg-12 row" style="background: white;padding-left: 5%;">
    		<div class="mb-3 col-md-12 col-lg-12 pl-0 pr-0">
    			<a style="cursor: pointer;" onclick="showHideInformation(this);" data-name="createPublishDiv">
               	<button type="button" id="" class="clickable createEventButton buttonMobileSize infoBtn" value="" style="">Create & Publish</button></a>

            	<a style="cursor: pointer;" onclick="showHideInformation(this);" data-name="promoteEventDiv">
                <button type="button" id="" class="clickable createEventButton buttonMobileSize infoBtn ml-2" value="" style="">Promote Event</button></a>

            	<a style="cursor: pointer;" onclick="showHideInformation(this);" data-name="manageAttendeesDiv">
                <button type="button" id="" class="clickable createEventButton buttonMobileSize infoBtn ml-2" value="" style="">Manage Attendees</button></a>

            	<a style="cursor: pointer;" onclick="showHideInformation(this);" data-name="sellingTicketsDiv">
                <button type="button" id="" class="clickable createEventButton buttonMobileSize infoBtn ml-2" value="" style="">Selling Tickets</button></a>
            </div>

            <div class="row col-md-12 col-lg-12">
            	<a style="cursor: pointer;" onclick="showHideInformation(this);" data-name="checkInOnEventDiv">
                <button type="button" id="" class="clickable createEventButton buttonMobileSize infoBtn" value="" style="">Check-in on the Event Day</button></a>

                <a style="cursor: pointer;" onclick="showHideInformation(this);" data-name="pricePayoutDiv">
                <button type="button" id="" class="clickable createEventButton buttonMobileSize infoBtn ml-3" value="" style="">Pricing & Payouts</button></a>

                <a style="cursor: pointer;" onclick="showHideInformation(this);" data-name="accountDiv">
                <button type="button" id="" class="clickable createEventButton buttonMobileSize infoBtn ml-2" value="" style="">Account</button></a>
            </div>
			
    	</div>
    </div>


    <div class="col-md-12 col-lg-12 featuredContent mb-4 d-block infoContent" style="">
    	<div class="showHideDiv" data-item="createPublishDiv">
    		<h4 class="mb-3"> Create & Publish </h4>

    		<div class="mb-3">
    			<a href="{{url('createEventInfo')}}" target="_blank"><h5> How to create an event? </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<hr>

    	</div>


    	<div class="showHideDiv" data-item="promoteEventDiv">
    		<h4 class="mb-3"> Promote Event </h4>

    		<div class="mb-3">
    			<a href="{{url('createEventInfo')}}" target="_blank"><h5> How to create an event? </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<hr>

    	</div>


    	<div class="showHideDiv" data-item="manageAttendeesDiv">
    		<h4 class="mb-3"> Manage Attendees </h4>

    		<div class="mb-3">
    			<a href="{{url('createEventInfo')}}" target="_blank"><h5> How to create an event? </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<hr>

    	</div>

    	<div class="showHideDiv" data-item="sellingTicketsDiv">
    		<h4 class="mb-3"> Selling Tickets </h4>

    		<div class="mb-3">
    			<a href="{{url('createEventInfo')}}" target="_blank"><h5> How to create an event? </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<hr>

    	</div>

    	<div class="showHideDiv" data-item="checkInOnEventDiv">
    		<h4 class="mb-3"> Check-in on the Event Day </h4>

    		<div class="mb-3">
    			<a href="{{url('createEventInfo')}}" target="_blank"><h5> How to create an event? </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<hr>

    	</div>


    	<div class="showHideDiv" data-item="pricePayoutDiv">
    		<h4 class="mb-3"> Pricing & Payouts </h4>

    		<div class="mb-3">
    			<a href="{{url('createEventInfo')}}" target="_blank"><h5> How to create an event? </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<hr>

    	</div>

    	<div class="showHideDiv" data-item="accountDiv">
    		<h4 class="mb-3"> Account </h4>

    		<div class="mb-3">
    			<a href="{{url('createEventInfo')}}" target="_blank"><h5> How to create an event? </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>

    		<div class="mb-3 d-none showHideTextDiv">
    			<a href="{{url('featureOverview')}}" target="_blank"><h5> Feature overview </h5></a>
    			<p>  Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he... </p>
    		</div>


    	</div>






    </div>





</div>
@endsection

@section('script')
<script>
	function showHideInformation(element){
		$(".showHideTextDiv").addClass("d-none");
		var className = $(element).attr("data-name");

		$('.showHideDiv').each(function() {
    		var contentDiv = $(this).attr('data-item');
    		if(contentDiv == className){
    			$(this).find(".showHideTextDiv").removeClass("d-none");
    			$(this).removeClass("d-none");
    		} else {
    			$(this).addClass("d-none");
    		}
    		$(this).find("hr").addClass("d-none");
    		$(".aboutUsDiv").addClass("d-none");
		});
		$(".backBtn").removeClass("d-none");
		$(".infoDiv").addClass("d-none");
	}

	function BackButton(element){
		$(".showHideDiv").removeClass("d-none");
		$(".showHideTextDiv").addClass("d-none");
		$("hr").removeClass("d-none");
		$(".aboutUsDiv").removeClass("d-none");
		$(".backBtn").addClass("d-none");
		$(".infoDiv").removeClass("d-none");
	}
</script>
@endsection