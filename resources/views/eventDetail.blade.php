<?php $v = "1.0.1"; ?>
@extends('layouts.appFront')
@section('content')

<div class="container mainHomePageContainer pt-3" style="">
	<?php $AwsUrl = env('AWS_URL'); 
		   $bannerImage = "";
		  if (!empty($event->banner)) {
            $bannerImage = $AwsUrl . $event->banner;
          } else {
          	// $bannerImage = $AwsUrl . 'no-image-logo.jpg';
            $bannerImage = '../assets/images-new/banner_img_no_available.png';
          }
	?>

    <?php 
                                $getUserID = "";
                                if(Auth::check()){
                                    $getUserID = Auth::user()->id;
                                }
                            ?>
                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input type="hidden" class="saveEventFollower" value="{{url('saveEventFollower')}}">
                            <input type="hidden" class="loginRoute" value="{{route('login')}}">
                            <input type="hidden" class="userIDFollow" value="{{$getUserID}}">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-5"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="col-md-12 col-lg-12 d-flex align-items-center" style="background:url('{{$bannerImage}}'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:350px; padding:unset;border-radius:6px;">
           <!-- <img src="{{$bannerImage}}" style="background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:350px; padding:unset;"> -->
                    <!-- <img src="{{url('assets/images-new/banner-image-1.png')}}" class="w-100 bannerImage"> -->
     </div>

     <div class="featuredContent mt-5 mb-4 row" style="padding: 0px 40px;">
     	<div class="col-md-8 col-lg-8">
     		<div class="card w-100">
                <div class="card-body eventDetailCardBody">
                	<h5> {{$event->title}} </h5>
                	<p>{{$event->description}}</p>
                	<h5> Tickets </h5>

                	<div class="ticketsDiv col-md-12 row mb-5">
                		<div class="col-md-4">
                			<div class="ticketBoxes"></div>
                		</div>
                		<div class="col-md-4">
                			<div class="ticketBoxes"></div>
                		</div>
                		<div class="col-md-4">
                			<div class="ticketBoxes"></div>
                		</div>
                	</div>

                	<div class="row">
                        <div class="pl-2">
                         <?php
                            $profileLogo = "";
                            if(!is_null($event->user->profile_pic) && $event->user->profile_pic != ""){
                                $profileLogo = $AwsUrl. $event->user->profile_pic; ?>
                                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width: 45px !important;height:45px !important;">
                            <?php } else{
                            		$profileLogo = $AwsUrl . 'no-image-logo.jpg' ?>
                                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width: 45px !important;height:45px !important;">
                             <?php } ?>
                        </div>
                        <div class="">
                            <h6 class="mt-3 ml-2"> {{$event->user->name}} </h6>
                        </div>
                    </div>

                </div>
            </div>    
     	</div>

     	<div class="col-md-4 col-lg-4">
     		<h5> Time </h5>

     		<div class="eventDateTimeBox mb-4">
     			<?php
     				$eventDateTime = strtotime($event->date_time);
                    $dateStr = date("d M",  $eventDateTime);
                    $timeStr = date("H:i",  $eventDateTime);
     			?>
    			<p class="text-center text-uppercase"> {{$timeStr}}, {{$dateStr}}</p>
     		</div>

            <?php
                $address = "";
                $countryNameAdd = "";
                $cityName = "";
                if($event->country_id && $countryName){
                    $address = $event->address;
                    $countryNameAdd = $countryName->name;
                    $cityName = $event->city; ?>
                
     		<h5 class=""> Location </h5>

     		<div class="mt-3 mb-4"> 
     			<!--Google map-->
				<div id="map-container-google-1" class="z-depth-1-half map-container" style="">
  					<!-- <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                    <iframe src="https://maps.google.com/maps?q={{$cityName}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<!--Google Maps-->

				<p class="mt-2"> {{$address}} ({{$cityName}}) </p>
     		</div>
            <?php } ?>

     		<div class="registerEvent col-md-12 row">
     			<a href="{{ route('register') }}">
                <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Registration" style="padding: 8px 30px;"></a>
     		</div>

     		<h5 class="mt-5"> Tags </h5>

     		<div class="TagNames row">
     			@foreach($event->categories as $eventCategory)
     				<div class="col-md-6 pr-0 pl-0 mt-2">
     					<div class="eventCategoryTag">
     						<p class="text-center mb-0" style="font-weight: 300;font-size: 13px;color:#9C9C9C;"> #{{$eventCategory->name}} </p>
     					</div>
     				</div>
     			@endforeach
     		</div>

     		<h5 class="mt-4"> Share </h5>

     		<div class="col-md-12 col-lg-12 row">
     			<a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1 float-right" style="background-color:white;"><i aria-hidden="true" class="fa fa-link" style="color: #9C9C9C;"></i></a>
     			<a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-linkedin"></i></a>
     			<a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>
     		</div>

     	</div>
     </div>

     <div class="col-md-12 eventsList mb-4" style="padding: 0px 40px;padding-top: 70px;">
     	<h5 class="mb-4"> Events you may like </h5>

     	<div class="row col-md-12 pl-0 pr-0">
            <?php $row_count = 1;
            foreach ($eventsList as $eventList) { ?>
            <?php
                $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                if (!empty($eventList->thumbnail)) {
                    $logoUrl = $AwsUrl . $eventList->thumbnail;
                                        }
                ?>
				<div class="col-md-3 eventListDiv parent pl-2 pr-2">
				<?php
                foreach ($eventList->categories as $EventCategory) { ?>
                    <input type="hidden" class="eventCatID" value="{{$EventCategory->id}}">
                <?php } ?>
                <div class="card">
                <?php
                    $sdStamp = strtotime($eventList->date_time);
                    $dateStr = date("d",  $sdStamp);
                    $MonthStr = date("M",  $sdStamp); 
                ?>
                    <a href="{{url('events/'. $eventList->id)}}"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;border-radius: 6px 6px 0px 0px;"></a>
                    
                    <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $eventList->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$eventList->id}}" discriminator="e">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>

                    <div class="card-body" style="padding: 10px;">
                        <a href="{{url('events/'. $eventList->id)}}">
                        <div class="col-md-12 row pr-0" style="padding: unset;margin: unset;">
                            <div class="col-md-2 pr-0 pl-1 mobRowDisplay">
                                <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                            </div>
                            <div class="col-md-10 pl-2 pr-0 mobRowDisplay1">
                                <h6> {{$eventList->title}} </h6>
                            </div>
                        </div></a>

						<?php
						for ($x = 0; $x < 1; $x++) {  ?>
                        <a class="text-center chevronClass" data-toggle="collapse" aria-expanded="false" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down" style="color: #9C9C9C;"></i>
                                                    <i class="fa fa-chevron-up" style="color: #9C9C9C;"></i></a>
                        <div id="heading<?php echo $row_count ?>" class="mt-2 ml-2 mr-2 collapse" style="color: black;">
                            {{$eventList->description}}
                        </div>
                        <?php $row_count++; } ?>

                        <?php if($eventList->is_online == 1){ ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;">Online Event </div>
                                              <?php  } else { ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;"> <i aria-hidden="true" class="fa fa-location-arrow pr-1"></i> {{$eventList->city}},  {{$eventList->state}}</div>
                                                <?php } ?>
                        
                        <hr class="mt-2 mb-2">
                        <div class="row">
                           <div class="pl-3">
                            <?php
                            $profileLogo = "";
                            if(!is_null($eventList->user->profile_pic) && $eventList->user->profile_pic != ""){
                               $profileLogo = env("AWS_URL"). $eventList->user->profile_pic; ?>
                                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                            <?php } else{ ?>
                                <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                            <?php } ?>
                            </div>
                            <div class="">
                               <h6 class="mt-2 ml-2"> {{$eventList->user->name}} </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <?php } ?>

        </div>

    </div>

</div>

@endsection

@section('script')
<script src="{{asset('/js/custom.js?v='.$v)}}" type="text/javascript"></script>
@endsection