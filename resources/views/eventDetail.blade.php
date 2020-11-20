@extends('layouts.appFront')
@section('content')

<div class="container mainHomePageContainer pt-3" style="">
	<?php $AwsUrl = env('AWS_URL'); 
		   $bannerImage = "";
		  if (!empty($event->banner)) {
            $bannerImage = $AwsUrl . $event->banner;
          } else {
          	$bannerImage = $AwsUrl . 'no-image-logo.jpg';
          }
	?>

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-5"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="col-md-12 col-lg-12 d-flex align-items-center" style="background:url('{{$bannerImage}}'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:350px; padding:unset;border-radius:6px;">
           <!-- <img src="{{$bannerImage}}" style="background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:350px; padding:unset;"> -->
                    <!-- <img src="{{url('assets/images-new/banner-image-1.png')}}" class="w-100 bannerImage"> -->
     </div>

     <div class="col-md-12 featuredContent mt-5 mb-4 row" style="padding: 0px 40px;">
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

     		<div class="eventDateTimeBox">
     			<?php
     				$eventDateTime = strtotime($event->date_time);
                    $dateStr = date("d M",  $eventDateTime);
                    $timeStr = date("H:i",  $eventDateTime);
     			?>
    			<p class="text-center text-uppercase"> {{$timeStr}}, {{$dateStr}}</p>
     		</div>

     		<h5 class="mt-4"> Location </h5>

     		<div class="mt-3 mb-4"> 
     			<?php
     				$cityName = "";
     				$address = "";
     				if($event->city_id){
     					$cityName = $event->city_id;
     					$address = $event->address;
     				}
     			?>
     			<!--Google map-->
				<div id="map-container-google-1" class="z-depth-1-half map-container" style="">
  					<iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<!--Google Maps-->

				<p class="mt-2"> {{$address}} (Manhattan) </p>
     		</div>

     		<div class="registerEvent">
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

     <div class="col-md-12 eventsList mb-4 row" style="padding: 0px 40px;padding-top: 70px;">
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
				<div class="col-md-3 eventListDiv parent">
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
                    <a href="{{url('events/'. $eventList->id)}}"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;"></a>
                    <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o"></i></span>
                    <div class="card-body">
                        <div class="col-md-12 row pr-0">
                            <div class="pr-0 pl-1">
                                <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                            </div>
                            <div class="pl-4">
                                <h6> {{$eventList->title}} </h6>
                            </div>
                        </div>

						<?php
						for ($x = 0; $x < 1; $x++) {  ?>
                        <a class="text-center" data-toggle="collapse" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down"></i></a>
                        <div id="heading<?php echo $row_count ?>" class="collapse" style="color: black;">
                            {{$eventList->description}}
                        </div>
                        <?php $row_count++; } ?>
                        <hr>
                        <div class="row">
                           <div class="pl-2">
                            <?php
                            $profileLogo = "";
                            if(!is_null($eventList->user->profile_pic) && $eventList->user->profile_pic != ""){
                               $profileLogo = env("AWS_URL"). $eventList->user->profile_pic; ?>
                                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                            <?php } else{ ?>
                                <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                            <?php } ?>
                            </div>
                            <div class="">
                               <h6 class="mt-3 ml-2"> {{$eventList->user->name}} </h6>
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