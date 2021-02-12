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
            $bannerImage = '../assets/images-new/banner-image-2.png';
          }

 $event_date = $event->date_time; 
 $date_now = date("Y-m-d", strtotime(now()));
 $checkDate = "";

if ($event_date >= $date_now) {
    $checkDate = "1";
}else{
    $checkDate = "0";
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
                             <input type="hidden" class="saveOrgFollower" value="{{url('saveOrgFollower')}}">
                             <input type="hidden" class="saveUserSuggestion" value="{{url('saveUserSuggestion')}}">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3 pl-0">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class=""><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	

     <div class="featuredContent mb-4 row" style="">
        <!-- padding: 0px 40px; -->
     	<div class="col-md-9 col-lg-9">
     		<div class="card w-100">
                <div class="card-body eventDetailCardBody pt-0">
                    <div class="col-md-12 col-lg-12 d-flex align-items-center" style="background:url('{{$bannerImage}}'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:290px; padding:unset;border-radius:6px;">
                    <!-- 294px -->
                    </div>

                    <div class="col-md-12 row" style="padding: 0px 25px;">
                        <div class="col-md-7">
                            <h5 class="mt-3" style="font-size: 20px;line-height: 30px;"> {{$event->title}} </h5>
                        </div>
                        <hr>
                        <div class="col-md-5 pr-0">
                            <?php
                                    $dateStr = "";
                                    $timeStr = "";

                                    $sdStamp = strtotime($event->date_time);
                                    $sd = date("d M, Y", $sdStamp);
                                    $st = date('h:i A', $sdStamp);

                                    $edStamp = strtotime($event->end_date_time);
                                    $ed = date("d M, Y", $edStamp);
                                    $et = date('h:i A', $edStamp);
                                    if ($sd == $ed) {
                                        $dateStr = date("D, jS M", $sdStamp);
                                        $timeStr = $st . " - " . $et;
                                    } else {
                                        $dateStr = date("D, jS M", $sdStamp) . ' - ' . date("D, jS M", $edStamp);
                                        $timeStr = $st . " - " . $et;
                                    }
                                    ?>
                            <div style="border-left: 1px solid rgba(0, 0, 0, 0.1);height: 60px;">
                                <h5 style="font-size: 16px;" class="ml-3 mt-3"> {{$dateStr}} </h5>
                                <div class="row col-md-12">
                                    <h5 style="font-size: 16px;" class="ml-3"> {{$timeStr}} </h5>
                                    <p style="font-weight: bold;" class="ml-3"> {{$event->timezone->abbreviation}} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <p style="color: #958E8E;font-weight: bold;padding: 0px 25px;"> About the Event </p>
                	<p style="padding: 0px 25px;" class="mb-4">{{$event->description}}</p>

                    <?php if(count($speakersList) > 0 && $checkDate == "1") { ?>
                    <hr class="mb-0">
                    <div class="speakersDiv col-md-12 row">
                        <div class="col-md-4 pl-0" style="padding: 0px 25px;">
                            <div style="width: 70%;
    height: 100%;
    background-color: #FED8C6;"> </div>
                        </div>

                        <div class="col-md-8 row" style="align-items: center;">
                            <div class="col-md-12 row mb-3 mt-3" style="margin-left: -8%;">
                            <h4 class="mt-2 pt-1 mr-2" style="font-size: 22px;"> Speakers </h4><span class="dot1 mt-4"></span> <span class="dot ml-1 mt-4"></span></div>

                            <?php 
                            foreach($speakersList as $speakerList) { ?>
                            <div class="row mb-5" style="margin-left: -45%;">
                                <div class="pl-3 col-md-3">
                                    <?php
                            $speakerProfileLogo = "";
                            if(!is_null($speakerList->profile_pic) && $speakerList->profile_pic != ""){
                               $speakerProfileLogo = env("AWS_URL"). $speakerList->profile_pic; 
                            } else {
                                $speakerProfileLogo = env("AWS_URL")."no-image-logo.jpg"; 
                            }
                               ?>
                                    <img class="align-self-start profileImg" src="{{$speakerProfileLogo}}" alt="user avatar" style="width: 170px !important;height: 170px !important;border-radius: 6px !important;">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="mb-0 pb-1 mt-2"> {{$speakerList->name}}
                                            <?php if($speakerList->linkedin_url != '') { ?> 
                                            <a href="{{$speakerList->linkedin_url}}" target="_blank" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white;height: 30px;width:30px;"><i class="fa fa-linkedin pt-1 d-flex justify-content-center"></i></a>
                                            <?php } ?> 
                                        </h5>
                                        <p class="" style="color: #9C9C9C;">{{$speakerList->title}} </p> 
                                        <p class="mt-2"> {{$speakerList->description}} </p>
                                    </div>
                            </div>
                            <?php }  ?>

                        </div>

                    </div>
                    <?php } ?>

                    <?php if(count($videosList) > 0 || count($podcastsList) > 0) { ?>
                	<!-- <h5 style="padding: 0px 45px;"> Event Media </h5> -->
                    <hr class="mt-0">
                    <?php if(count($videosList) > 0) {
                     ?>
                    <h5 style="padding: 0px 25px;"> Videos &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"> </i> </h5>
                    <div class="eventVideosList row" style="padding: 0px 25px;padding-left: 35px !important;">

                        @foreach($videosList as $videoList)
                        <div class="col-md-4 showHideListDiv parent pl-2 pr-2">
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
                                            <iframe width="248px" height="140px" src="{{$url}}" frameborder="0" class="vFrame" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe>
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
                    <h5 style="padding: 0px 25px;"> Podcasts &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"> </i> </h5>
                    <div class="eventPodcastsList row" style="padding: 0px 25px;padding-left: 35px !important;">

                        @foreach($podcastsList as $podcastList)

                            <div class="col-md-4 showHideListDiv parent pl-2 pr-2">
                                
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

                    <hr class="mt-0">
                    @include('layouts.giveSuggestionView', ['section' => $event])

                    <hr>
                    @include('layouts.commentsView', ['comment' => 'comment'])


                </div>
            </div>    
     	</div>

     	<div class="col-md-3 col-lg-3">
            @include('layouts.orgDetailView', ['sectionevent' => $event])
     		
            <?php if($event->is_paid == 0 && $checkDate == "1") { ?>
                <div class="card w-100 d-flex align-items-center" style="margin-top: 15%;border-radius: 6px;">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-center">
                            <h5> Free Event </h5>
                        </div>
                        <div class="registerEvent col-md-12 row mt-3">
                            <a href="#">
                            <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Register" style="padding: 8px 30px;"></a>
                        </div>
                    </div>
                </div>
            <?php } 
                if($event->is_paid == 1 && $checkDate == "1" && count($ticketsList) > 0) { ?>
                    <div class="card w-100" style="margin-top: 15%;border-radius: 6px;">
                        <div class="card-body pt-3 pb-2">
                            <h5> Tickets </h5>
                            <?php
                                $countForColor = 1; 
                            ?>
                            @foreach($ticketsList as $ticketList)
                            <?php 
                                if($countForColor%2 == 0){
                                    $addColorStyle = "";
                                } else {
                                    $addColorStyle = "background: #FED8C6;border-radius: 0px 6px 6px 0px;";   
                                }
                            ?>
                        <div class="col-md-12 eventTicket pl-0 pr-0">
                            <div class="card mb-3" style="background: #F1F2F2;border-radius: 5px;box-shadow: none;">

                                <div class="card-body p-0">
                                    <div class="row priceDiv pl-0 pr-0 mr-0">
                                        <div class="col-md-8 col-lg-8 pr-0 d-flex justify-content-center">
                                            <p class="mt-4 mb-4" style="font-weight: 600;color: #1E1E1E;"> {{$ticketList->name}} </p>
                                        </div>
                                        <div class="col-md-4 col-lg-4 pl-0 pr-0 d-flex justify-content-center" style="{{$addColorStyle}}">
                                            <h5 class="mb-0 mt-4 mb-4">${{round($ticketList->price, 0)}}</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php $countForColor++; ?>
                        @endforeach

                        <div class="registerEvent mt-3 d-flex justify-content-center">
                            <a href="#">
                            <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Purchase" style="padding: 8px 30px;"></a>
                        </div>

                        </div>
                    </div>
                <?php } ?>

            <div class="card w-100" style="margin-top: 15%;border-radius: 6px;">
                <div class="card-body pt-3 pb-2">
                <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $event->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$event->id}}" discriminator="e">
                                                <span class="likeButtonSpan" style="top:2px;right:5px;font-size: 25px;"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>
                                            </div>
                                                <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                                ?>
                            <div class="col-md-9" style="">
                                <a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1" style="background-color:white;width: 35px;height: 35px;border: 2px solid #9C9C9C;">
                                    <i aria-hidden="true" class="fa fa-link pt-2" style="color: #9C9C9C;display: flex;justify-content: center;" onclick="shareLink();"></i>
                                </a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $actual_link; ?>" target="_blank" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1" style="width: 35px;height: 35px;background: #BBBBBB;border-color: white;"><i class="fa fa-linkedin pt-2" style="color: white;display: flex;justify-content: center;"></i></a>
                <a href="http://www.facebook.com/share.php?u=<?php echo $actual_link; ?>" onclick="return fbs_click();" target="_blank" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1" style="width: 35px;height: 35px;background: #BBBBBB;border-color: white;"><i class="fa fa-facebook pt-2" style="color: white;display: flex;justify-content: center;"></i></a>
            </div>
                        <div class="copied mt-2 ml-4 pl-2" style="color: green;font-size: 13px;"></div>
                                            </div>

                </div>
            </div>

            <?php
                //$cityName = "";
                $fullAddress = "";
                $countryNameAdd = "";
                if($event->country_id && $countryName && $checkDate == "1"){
                    $countryNameAdd = $countryName->name;
                    //$cityName = $event->city;
                    $fullAddress .=  $event->address;

                    if($event->address_line2 != ''){
                        $fullAddress .= ", " . $event->address_line2;
                    }
                    if($event->city != ''){
                        $fullAddress .= ", " . $event->city;
                    }
                    if($event->state != ''){
                        $fullAddress .= ", " . $event->state;
                    }
                    if($event->postal_code != ''){
                        $fullAddress .= ", " . $event->postal_code;
                    }
                    $fullAddress .= ", " . $countryNameAdd;
                ?>
                
     		<h5 class=""> Location </h5>

     		<div class="mt-3 mb-4"> 
     			<!--Google map-->
				<div id="map-container-google-1" class="z-depth-1-half map-container" style="">
  					<!-- <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                    <iframe src="https://maps.google.com/maps?q={{$fullAddress}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0;width:265px;" allowfullscreen></iframe>
				</div>
				<!--Google Maps-->

				<p class="mt-2"> {{$fullAddress}}</p>
     		</div>
            <?php } ?>

     		<h5 class="mt-3"> Tags </h5>

     		<div class="TagNames row">
     			@foreach($event->categories as $eventCategory)
     				<div class="col-md-6 pr-0 pl-0 mt-2">
     					<div class="eventCategoryTag">
     						<p class="text-center mb-0" style="font-weight: 300;font-size: 13px;color:#9C9C9C;"> #{{$eventCategory->name}} </p>
     					</div>
     				</div>
     			@endforeach
     		</div>

     	</div>
     </div>

     <div class="col-md-12 eventsList mb-4" style="">
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