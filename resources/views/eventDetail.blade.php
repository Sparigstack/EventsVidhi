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
                	<h5 style="padding: 0px 45px;"> {{$event->title}} </h5>
                	<p style="padding: 0px 45px;">{{$event->description}}</p>

                    <?php if(count($ticketsList) > 0) { ?>
                    <h5 class="mt-3" style="padding: 0px 45px;"> Event Tickets </h5>

                    <div class="ticketsDiv row" style="padding: 0px 45px;padding-left: 52px;">

                        @foreach($ticketsList as $ticketList)
                        <div class="col-md-5 eventTicket">
                            <div class="card" style="border: 1px solid #BBBBBB;border-radius: 6px;">

                                <?php
                                    $dateStr = "";

                                    $salesStart = strtotime($ticketList->sales_start);
                                    $startDate = date("d M", $salesStart);
                                    $startTime = date('H:i', $salesStart);

                                    $salesEnd = strtotime(($ticketList->sales_end));
                                    $endDate = date("d M", $salesEnd);
                                    $endTime = date('H:i', $salesEnd);
                                    if($startDate == $endDate){
                                        $dateStr = $startDate. ', '.$startTime. ' - '.$endTime;
                                    } else {
                                        $dateStr = $startDate.', '.$startTime. ' to '.$endDate. ' '. $endTime;
                                    }
                                ?>

                                <div class="card-body">

                                    <h6 class="text-center mb-3"> {{$ticketList->name}} </h6>

                                    <div class="row dateTimeDiv">
                                        <div class="col-md-12 col-lg-12">
                                            <h6 class="mb-0"> Date & Time </h6>
                                            <p class="text-uppercase">{{$dateStr}}</p>
                                        </div>
                                    </div>

                                    <div class="row priceDiv">
                                        <div class="col-md-6 col-lg-6">
                                            <h6 class="mb-0"> Quantity </h6>
                                            <p>{{$ticketList->quantity}} Tickets</p>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <h6 class="mb-0"> Price </h6>
                                            <p class="text-uppercase">${{$ticketList->price}}</p>
                                        </div>
                                    </div>

                                    <div class="row purchaseTicketDiv" style="justify-content: center;">
                                        <a href="#">
                                            <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Purchase Ticket" style="padding: 5px 15px;height: 35px;"></a>
                                    </div>

                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>

                    <?php } ?>

                   <!--  <div class="col-md-4">
                            <div class="ticketBoxes"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="ticketBoxes"></div>
                        </div> -->

                    <?php if(count($videosList) > 0 || count($podcastsList) > 0) { ?>
                	<h5 style="padding: 0px 45px;"> Event Media </h5>

                    <?php if(count($videosList) > 0) { ?>
                    <h6 style="padding: 0px 45px;"> Video </h6>
                    <div class="eventVideosList row" style="padding: 0px 45px;padding-left: 52px !important;">

                        @foreach($videosList as $videoList)
                        <div class="col-md-5 showHideListDiv parent pl-2 pr-2">
                            <div class="card" style="border: 1px solid #BBBBBB;border-radius: 6px;">
                                <?php
                                    $AwsUrl = env('AWS_URL');
                                    $videoUrl = "";
                                    if (!empty($videoList->url)) {
                                        if($videoList->url_type == 1){
                                            $videoUrl = $AwsUrl . $videoList->url;?>
                                            <a href="{{url('videos/'. $videoList->id)}}" target="_blank">
                                                <video class="" src="{{$videoUrl}}" width="100%" height="100%" controls="controls" style="border-radius: 6px 6px 0px 0px;"></video>
                                            </a>
                                        <?php   }
                                        else{
                                                $videoUrl = $videoList->url; 
                                                if(strpos($videoUrl, 'youtube') !== false){
                                                        $explodeUrl = explode('=', $videoUrl);
                                                        $getLastWord = array_pop($explodeUrl);
                                                        $url = "https://www.youtube.com/embed/" . $getLastWord;
                                                }else{
                                                        $explodeUrl = explode('/', $videoUrl);
                                                        $getLastWord = array_pop($explodeUrl);
                                                        $url = "https://player.vimeo.com/video/" . $getLastWord;
                                                }
                                        ?>
                                        <a href="{{url('videos/'. $videoList->id)}}" target="_blank">
                                            <iframe width="238px" height="135px" src="{{$url}}" frameborder="0" class="vFrame" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe>
                                        </a>
                                    <?php  }
                                } ?>
                                                        
                                <?php 
                                    $checkHeartFill = "d-none";
                                    $checkHeartEmpty = "";
                                    $checkVal = "";
                                    if(Auth::check()){
                                        foreach($eventFollowersList as $eventFollowerList){
                                            if(Auth::user()->id == $eventFollowerList->user_id && $videoList->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "v"){
                                                    $checkHeartFill = "";
                                                    $checkHeartEmpty = "d-none";
                                                    $checkVal = "1";
                                                }
                                            }
                                    }
                                    ?>
                                    <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$videoList->id}}" discriminator="v">
                                    <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                    </span></a>
                                    <div class="card-body" style="padding: 10px;">
                                        <a href="{{url('videos/'. $videoList->id)}}" target="_blank">
                                            <div class="col-md-12 pr-0 pl-0">
                                                                <h6> {{$videoList->title}} </h6>
                                            </div>

                                            <?php $eventDesc = "";
                                                $eventLink = "";
                                                $desc = "";
                                                $eventDescText = "";
                                                if($videoList->description == ''){
                                                    $eventDesc = $videoList->event->description;
                                                        $eventDescText = substr($eventDesc,0,70).'...';
                                                }
                                                else{
                                                        $eventDesc = $videoList->description;
                                                        $eventDescText = substr($eventDesc,0,70).'...';
                                                } 
                                            ?>
                                                            
                                            <div class="col-md-12 pr-0 pl-0" style="color: black;">{{$eventDescText}}</div>

                                            <div class="col-md-12 pr-0 mt-2 mr-2 pl-0" style="color:#9C9C9C;">Video </div> 
                                        </a>

                                        </div>
                                    </div>
                            </div> 
                            @endforeach


                    </div>


                    <?php } ?> 

                    <?php if(count($podcastsList) > 0) { ?>
                    <h6 style="padding: 0px 45px;"> Podcasts </h6>
                    <div class="eventPodcastsList row" style="padding: 0px 45px;padding-left: 52px !important;">

                        @foreach($podcastsList as $podcastList)

                            <div class="col-md-5 showHideListDiv parent pl-2 pr-2">
                                
                                <div class="card" style="border: 1px solid #BBBBBB;border-radius: 6px;">
                                    <a href="{{url('podcasts/'. $podcastList->id)}}" target="_blank">
                                        <img src="../assets/images-new/sample-image.png" class="" alt="" style="width: 100%;height: 130px;">
                                    </a>

                                    <?php 
                                        $checkHeartFill = "d-none";
                                        $checkHeartEmpty = "";
                                        $checkVal = "";
                                        if(Auth::check()){
                                            foreach($eventFollowersList as $eventFollowerList){
                                                if(Auth::user()->id == $eventFollowerList->user_id && $podcastList->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "p"){
                                                        $checkHeartFill = "";
                                                        $checkHeartEmpty = "d-none";
                                                        $checkVal = "1";
                                                    }
                                                }
                                        }
                                    ?>
                                    <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$podcastList->id}}" discriminator="p">
                                        <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                        <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                        </span>
                                    </a>



                                    <div class="card-body" style="padding: 10px;">
                                        <div class="col-md-12 row pr-0">
                                            <a href="{{url('podcasts/'. $podcastList->id)}}" target="_blank">
                                                <h6> {{$podcastList->title}} </h6>
                                            </a>
                                        </div>

                                        <?php
                                            $videoPodcastUrl = "";
                                            $dnoneClass = "";
                                            if (!empty($podcastList->url)) {
                                                $dnoneClass = "d-none";
                                                if(substr($podcastList->url, 0, 8 ) != "https://"){
                                                    $videoPodcastUrl = $AwsUrl . $podcastList->url;
                                                }
                                                else{
                                                    $videoPodcastUrl = $podcastList->url;
                                                }
                                            }
                                            ?>
                                            <a href="{{$videoPodcastUrl}}" target="_blank"><audio controls  class="w-100"><source src="{{$videoPodcastUrl}}" type="audio/ogg" class="col-lg-7 pr-0 pl-0"></audio></a>

                                                <div class="col-md-12 pr-0 mt-2 mr-2 pl-0" style="color:#9C9C9C;">Podcast </div>

                                        </div>
                                </div>


                            </div>


                        @endforeach

                    </div>


            <?php } } ?>

                    <!-- <a href="{{url('organizer/'. $event->user->id)}}" target="_blank"> -->
                	<div class="row" style="padding: 0px 45px;">

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
                    <!-- </a> -->
                    <hr>
                    @include('layouts.commentsView', ['comment' => 'comment'])
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
     			<a href="#">
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

     		@include('layouts.appShare')

     	</div>
     </div>

     <div class="col-md-12 eventsList mb-4" style="padding: 0px 40px;">
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
                    <a href="{{url('events/'. $eventList->id)}}" target="_blank"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;border-radius: 6px 6px 0px 0px;"></a>
                    
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
                        <a href="{{url('events/'. $eventList->id)}}" target="_blank">
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

                        <a href="{{url('organizer/'. $eventList->user->id)}}" target="_blank">
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
                    </a>

                    </div>
                </div>
            </div> 
            <?php } ?>

        </div>

    </div>

</div>

@endsection

@section('script')
<script>
    function showHideComments(comment){
        var txt = $(comment).parent().parent().find(".contentDiv").is(':visible') ? 'Show More' : 'Show Less';
        var txtData = $(comment).parent().parent().find(".show_hide").text(txt);
        if(txt == 'Show Less'){
            $(comment).parent().parent().find('.fullContent').removeClass('d-none');
            $(comment).parent().parent().find('.shortContent').addClass('d-none');
        } else {
            $(comment).parent().parent().find('.fullContent').addClass('d-none');
            $(comment).parent().parent().find('.shortContent').removeClass('d-none');
        }
    }
</script>
<script src="{{asset('/js/custom.js?v='.$v)}}" type="text/javascript"></script>
@endsection