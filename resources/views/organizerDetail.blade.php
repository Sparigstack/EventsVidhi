<?php $v = "1.0.1"; ?>
@extends('layouts.appFront')
@section('content')

<div class="container mainHomePageContainer pt-3" style="">

<?php $AwsUrl = env('AWS_URL'); 
		   $bannerImage = "";
		  if (!empty($organizer->banner)) {
            $bannerImage = $AwsUrl . $organizer->banner;
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
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-4"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="featuredContent mb-4 row" style="padding: 0px 40px;">
     	<div class="col-md-9 col-lg-9">
     		<div class="card w-100">

     			<div class="col-md-12 col-lg-12 d-flex align-items-center" style="background:url('{{$bannerImage}}'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:250px; padding:unset;border-radius:6px;">
     			</div>

     			<div class="card-body pb-4 profileTop" style="margin-top: -18%;position: relative;padding: 0px 45px;">

     				<div class="profileNameImg row">
     					<div class="col-md-9">
     				<?php
                            $profileLogo = "";
                            if(!is_null($organizer->profile_pic) && $organizer->profile_pic != ""){
                                $profileLogo = $AwsUrl. $organizer->profile_pic; ?>
                                <img class="align-self-start profileImg mediaImg" src="{{$profileLogo}}" alt="user avatar" style="width: 200px !important;height:200px !important;">
                            <?php } else{
                            		$profileLogo = $AwsUrl . 'no-image-logo.jpg' ?>
                                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width: 200px !important;height:200px !important;">
                             <?php } ?>
                          </div>

                          <div class="col-md-3" style="margin-top: 22%;">
                          		<a href="#"><input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Following"></a>
                          </div>

                    </div>

                    
                    <h5 class="mt-5"> {{$organizer->name}} </h5>

                    <p class="mt-3"> 254 Followers </p>
                    <hr>

                    <?php if($organizer->description != ""){ ?>
                    <h5 class=""> About </h5>
                    <p class="mt-3">{{$organizer->description}}</p>
                    <hr>
                    <?php } ?>

                    <?php if(count($orgFutureEventsList) > 0) { ?>
                    <h5 class="mb-3"> Future Events &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h5>


                    <div class="row pl-0 pr-0">
            <?php $row_count = 1;
            foreach ($orgFutureEventsList as $orgFutureEventList) { ?>
            <?php
                $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                if (!empty($orgFutureEventList->thumbnail)) {
                    $logoUrl = $AwsUrl . $orgFutureEventList->thumbnail;
                                        }
                ?>
				<div class="col-md-4 eventListDiv parent pl-2 pr-2">
                <div class="card" style="border: 1px solid #BBBBBB;border-radius: 6px;">
                <?php
                    $sdStamp = strtotime($orgFutureEventList->date_time);
                    $dateStr = date("d",  $sdStamp);
                    $MonthStr = date("M",  $sdStamp); 
                ?>
                    <a href="{{url('events/'. $orgFutureEventList->id)}}" target="_blank"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;border-radius: 6px 6px 0px 0px;"></a>
                    
                    <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $orgFutureEventList->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$orgFutureEventList->id}}" discriminator="e">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>

                    <div class="card-body" style="padding: 10px;">
                        <a href="{{url('events/'. $orgFutureEventList->id)}}" target="_blank">
                        <div class="col-md-12 row pr-0" style="padding: unset;margin: unset;">
                            <div class="col-md-2 pr-0 pl-1 mobRowDisplay">
                                <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                            </div>
                            <div class="col-md-10 pl-2 pr-0 mobRowDisplay1">
                                <h6> {{$orgFutureEventList->title}} </h6>
                            </div>
                        </div></a>

						<?php
						for ($x = 0; $x < 1; $x++) {  ?>
                        <a class="text-center chevronClass" data-toggle="collapse" aria-expanded="false" data-target="#headingfevent<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down" style="color: #9C9C9C;"></i>
                                                    <i class="fa fa-chevron-up" style="color: #9C9C9C;"></i></a>
                        <div id="headingfevent<?php echo $row_count ?>" class="mt-2 ml-2 mr-2 collapse" style="color: black;">
                            {{$orgFutureEventList->description}}
                        </div>
                        <?php $row_count++; } ?>

                        <?php if($orgFutureEventList->is_online == 1){ ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;">Online Event </div>
                                              <?php  } else { ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;"> <i aria-hidden="true" class="fa fa-location-arrow pr-1"></i> {{$orgFutureEventList->city}},  {{$orgFutureEventList->state}}</div>
                                                <?php } ?>
                        
                    </div>
                </div>
            </div> 
            <?php }  } ?>

        </div>


        <?php if(count($videosList) > 0) { ?>
        <h5 class="mb-3"> Videos &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h5>

        <div class="eventVideosList row pl-0 pr-0" style="">

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
                                            <iframe width="218px" height="125px" src="{{$url}}" frameborder="0" class="vFrame" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe>
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
        	<h5 class="mb-3"> Podcasts &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h5>

        	<div class="eventPodcastsList row" style="">

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



            <?php } ?>


                <div class="col-md-12 mobileSeeMoreBtn d-none" style="">
                                    <a href="{{url('organizer/'.$organizer->id.'/1/0/0/page=1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);float: right;"></a>
                                </div>
     				

     			</div>

     		</div>
     	</div>

     	<div class="col-md-3 col-lg-3 pl-1">

     		<h5 class=""> Contacts </h5>

     		@if($organizer->email != '')
     			<div class="row ml-1">
     				<i aria-hidden="true" class="fa fa-envelope-o" style="color: #9C9C9C;margin-top:4px;"></i><p class="ml-1" style="color:black;">{{$organizer->email}}</p>
     			</div>
     		@endif

     		@if($organizer->website_url != '')
     			<div class="row ml-1">
     				<i aria-hidden="true" class="fa fa-globe" style="color: #9C9C9C;margin-top:4px;"></i><p class="ml-1" style="color: black;">{{$organizer->website_url}}</p>
     			</div>
     		@endif

     		@if($organizer->linkedin_url != '')
     			<div class="row ml-1">
     				<i aria-hidden="true" class="fa fa-linkedin" style="color: #9C9C9C;margin-top:4px;"></i><p class="ml-1" style="color: black;">{{$organizer->linkedin_url}}</p>
     			</div>
     		@endif

     		<!-- <i aria-hidden="true" class="fa fa-envelope-o" style="color: #9C9C9C;"></i>
     		<i aria-hidden="true" class="fa fa-globe"></i>
     		<i aria-hidden="true" class="fa fa-linkedin"></i> -->

     		<h5 class="mt-4"> Share </h5>

     		<div class="col-md-12 col-lg-12 row">
     			<a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1 float-right" style="background-color:white;"><i aria-hidden="true" class="fa fa-link" style="color: #9C9C9C;"></i></a>
     			<a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-linkedin"></i></a>
     			<a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>
     		</div>


     		<?php if(count($orgPastEventsList) > 0) { ?>
     		<h5 class="mt-4 mb-3"> Past Events &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h5>

     		<div class="row pl-0 pr-0">
            <?php $row_count = 1;
            foreach ($orgPastEventsList as $orgPastEventList) { ?>
            <?php
                $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                if (!empty($orgPastEventList->thumbnail)) {
                    $logoUrl = $AwsUrl . $orgPastEventList->thumbnail;
                                        }
                ?>
				<div class="col-md-12 eventListDiv parent pl-2 pr-2">
				<?php
                foreach ($orgPastEventList->categories as $EventCategory) { ?>
                    <input type="hidden" class="eventCatID" value="{{$EventCategory->id}}">
                <?php } ?>
                <div class="card">
                <?php
                    $sdStamp = strtotime($orgPastEventList->date_time);
                    $dateStr = date("d",  $sdStamp);
                    $MonthStr = date("M",  $sdStamp); 
                ?>
                    <a href="{{url('events/'. $orgPastEventList->id)}}" target="_blank"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;border-radius: 6px 6px 0px 0px;"></a>
                    
                    <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $orgPastEventList->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$orgPastEventList->id}}" discriminator="e">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>

                    <div class="card-body" style="padding: 10px;">
                        <a href="{{url('events/'. $orgPastEventList->id)}}" target="_blank">
                        <div class="col-md-12 row pr-0" style="padding: unset;margin: unset;">
                            <div class="col-md-2 pr-0 pl-1 mobRowDisplay">
                                <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                            </div>
                            <div class="col-md-10 pl-2 pr-0 mobRowDisplay1">
                                <h6> {{$orgPastEventList->title}} </h6>
                            </div>
                        </div></a>

						<?php
						for ($x = 0; $x < 1; $x++) {  ?>
                        <a class="text-center chevronClass" data-toggle="collapse" aria-expanded="false" data-target="#headingevent<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down" style="color: #9C9C9C;"></i>
                                                    <i class="fa fa-chevron-up" style="color: #9C9C9C;"></i></a>
                        <div id="headingevent<?php echo $row_count ?>" class="mt-2 ml-2 mr-2 collapse" style="color: black;">
                            {{$orgPastEventList->description}}
                        </div>
                        <?php $row_count++; } ?>

                        <?php if($orgPastEventList->is_online == 1){ ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;">Online Event </div>
                                              <?php  } else { ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;"> <i aria-hidden="true" class="fa fa-location-arrow pr-1"></i> {{$orgPastEventList->city}},  {{$orgPastEventList->state}}</div>
                                                <?php } ?>
                        
                        <hr class="mt-2 mb-2">
                        <a href="{{url('organizer/'. $orgPastEventList->user->id)}}" target="_blank">
                        <div class="row">
                           <div class="pl-3">
                            <?php
                            $profileLogo = "";
                            if(!is_null($orgPastEventList->user->profile_pic) && $orgPastEventList->user->profile_pic != ""){
                               $profileLogo = env("AWS_URL"). $orgPastEventList->user->profile_pic; ?>
                                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                            <?php } else{ ?>
                                <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                            <?php } ?>
                            </div>
                            <div class="">
                               <h6 class="mt-2 ml-2"> {{$orgPastEventList->user->name}} </h6>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
            </div> 
            <?php }  }?>

        </div>



     	</div>


    </div>



    <div class="col-md-12 eventsList mb-4" style="padding: 0px 40px;">
     	<h5 class="mb-4"> Events you may like &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h5>

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
<script src="{{asset('/js/custom.js?v='.$v)}}" type="text/javascript"></script>
@endsection