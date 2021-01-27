<?php $v = "1.0.1"; ?>
@extends('layouts.appFront')
@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container mainHomePageContainer pt-3" style="">
	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-4 pl-2"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

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



    <?php if(count($organizers) > 0) { ?>
    <div class="col-md-11 featuredContent mb-4">
        <div class="col-md-12 row MobDisplay">
            <div class="col-md-4 pl-0">
               <h4> Followed Organizers &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h4>
            </div>
        </div>
    </div>

    <div class="col-md-11 featuredContent mb-4">
        <div class="row col-md-12 pl-0 pr-0">
            @include('layouts.orgDetailView', ['myContent' => $organizers])
        </div>
    </div>
    <?php } ?>


    <?php if(count($events) > 0) { ?>
	<div class="col-md-11 featuredContent mb-4">
        <div class="col-md-12 row MobDisplay">
            <div class="col-md-4 pl-0">
               <h4> Followed Events &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h4>
            </div>
        </div>
    </div>

    <div class="col-md-11 featuredContent mb-4">
        <div class="row col-md-12 pl-0 pr-0">
            <div class="col-md-12 d-none noEventMsg">
                <p class="text-center"> No Records Found! </p>
            </div>
            <?php $row_count = 1;
             foreach ($events as $event) { ?>

             <?php
                $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                if (!empty($event->thumbnail)) {
                    $logoUrl = $AwsUrl . $event->thumbnail;
                }
            ?>

            <div class="col-md-3 showHideListDiv eventListDiv parent pl-2 pr-2">

           <div class="card">
                                                <?php
                                                $freeEventClass = "d-none";
                                                if($event->is_paid != 1){
                                                    $freeEventClass = "freeTextSpanClass";
                                                }
                                                $sdStamp = strtotime($event->date_time);
                                                $dateStr = date("d",  $sdStamp);
                                                $MonthStr = date("M",  $sdStamp); 
                                                ?>
                                                <a href="{{url('events/'. $event->id)}}" target="_blank"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;border-radius: 6px 6px 0px 0px;"></a>
                                                <span class="{{$freeEventClass}} mt-2">FREE</span>

                                                <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $event->eventFollowEventId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$event->id}}" discriminator="e">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>

                                                <div class="card-body" style="padding: 10px;">
                                                    <a href="{{url('events/'. $event->id)}}" target="_blank">
                                                    <div class="col-md-12 row pr-0" style="padding: unset;margin: unset;">
                                                        <div class="col-md-2 pr-0 pl-1 mobRowDisplay">
                                                            <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                                                        </div>
                                                        <div class="col-md-10 pl-2 pr-0 mobRowDisplay1">
                                                            <h6> {{$event->title}} </h6>
                                                        </div>
                                                    </div> </a>

                                                    <?php
                                                    for ($x = 0; $x < 1; $x++) {  ?>
                                                    <a class="text-center chevronClass" data-toggle="collapse" aria-expanded="false" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down" style="color: #9C9C9C;"></i>
                                                    <i class="fa fa-chevron-up" style="color: #9C9C9C;"></i></a>

                                                    <div id="heading<?php echo $row_count ?>" class="collapse mt-2 ml-2 mr-2" style="color: black;">
                                                        {{$event->description}}
                                                    </div>
                                                    <?php $row_count++; } ?>

                                                    <?php if($event->is_online == 1){ ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;">Online Event </div>
                                              <?php  } else { ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;"> <i aria-hidden="true" class="fa fa-location-arrow pr-1"></i> {{$event->city}},  {{$event->state}}</div>
                                                <?php } ?>

                                                    <hr class="mt-2 mb-2">

                                                    <a href="{{url('organizer/'. $event->userId)}}" target="_blank">
                                                    <div class="row">
                                                        <div class="pl-3">
                                                            <?php
                                                            $profileLogo = "";
                                                            if(!is_null($event->profile_pic) && $event->profile_pic != ""){
                                                               $profileLogo = env("AWS_URL"). $event->profile_pic; ?>
                                                               <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } else{ ?>
                                                               <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } ?>
                                                           </div>
                                                           <div class="">
                                                            <h6 class="mt-2 ml-2"> {{$event->name}} </h6>
                                                        </div>
                                                    </div>
                                                </a>

                                                </div>
                                            </div>
                                        </div> 
                                        <?php } ?>

                                    </div>
                                </div>



    <?php } ?>



    <?php if(count($videos) > 0) { ?>
    <div class="col-md-11 featuredContent mb-4">
        <div class="col-md-12 row MobDisplay">
            <div class="col-md-4 pl-0">
               <h4> Followed Videos &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h4>
            </div>
        </div>
    </div>

    <div class="col-md-11 featuredContent mb-4">
                                    <div class="row col-md-12 pl-0 pr-0">
                                        <div class="col-md-12 d-none noEventMsg">
                                            <p class="text-center"> No Records Found! </p>
                                        </div>
                                        <?php $row_count = 1;
                                        foreach ($videos as $video) { ?>
                                        <div class="col-md-3 showHideListDiv parent pl-2 pr-2">

                                            <div class="card">
                                                <?php
                                                $AwsUrl = env('AWS_URL');
                                                $videoUrl = "";
                                                if (!empty($video->url)) {
                                                    if($video->url_type == 1){
                                                        $videoUrl = $AwsUrl . $video->url; ?>
                                                        <!-- <a href="{{$videoUrl}}" target="_blank"> -->
                                                            <a href="{{url('videos/'. $video->id)}}" target="_blank">
                                                            <video class="" src="{{$videoUrl}}" width="100%" height="100%" controls="controls" style="border-radius: 6px 6px 0px 0px;"></video></a>
                                                        <?php   }
                                                        else{
                                                            $videoUrl = $video->url; 
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
                                                            <!-- <a href="{{$url}}" target="_blank"> -->
                                                                <a href="{{url('videos/'. $video->id)}}" target="_blank">
                                                                <iframe width="232px" height="130px" src="{{$url}}" frameborder="0" class="" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe></a>
                                                            <?php  }
                                                        }
                                                        ?>
                                                        

                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $video->eventFollowVideoId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "v"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$video->id}}" discriminator="v">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>


                                                        <div class="card-body" style="padding: 10px;">
                                                            <a href="{{url('videos/'. $video->id)}}" target="_blank">
                                                            <div class="col-md-12 pr-0 pl-0">
                                                                <h6> {{$video->title}} </h6>
                                                            </div>

                                                            <?php $eventDesc = "";
                                            // $eventPrefix = "";
                                                            $eventLink = "";
                                                            $desc = "";
                                                            $eventDescText = "";
                                                            if($video->description == ''){
                                                // $eventPrefix = "Event : ";
                                                // $eventDesc = $eventPrefix.$video->event->title;
                                                                $eventDesc = $video->eventDesc;
                                                                $eventDescText = substr($eventDesc,0,80).'...';
                                                            }
                                                            else{
                                                                $eventDesc = $video->description;
                                                                $eventDescText = substr($eventDesc,0,80).'...';
                                                            } 
                                                            ?>
                                                            
                                                            <div class="col-md-12 pr-0 pl-0" style="color: black;">{{$eventDescText}}</div>

                                <div class="col-md-12 pr-0 mt-2 pl-0" style="color:#9C9C9C;">Video </div> </a>

                                                            <hr class="mt-2 mb-2">

                                                            <a href="{{url('organizer/'. $video->userId)}}" target="_blank">
                                                            <div class="row">
                                                                <div class="pl-3">
                                                                    <?php
                                                                    $profileLogo = "";
                                                                    if(!is_null($video->profile_pic) && $video->profile_pic != ""){
                                                                       $profileLogo = env("AWS_URL"). $video->profile_pic; ?>
                                                                       <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } else{ ?>
                                                                       <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } ?>
                                                                   </div>
                                                                   <div class="">
                                                                    <h6 class="mt-2 ml-2"> {{$video->name}} </h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>

                                            </div>
                                        </div>


    <?php } ?>



    <?php if(count($podcasts) > 0){ ?>
    <div class="col-md-11 featuredContent mb-4">
        <div class="col-md-12 row MobDisplay">
            <div class="col-md-4 pl-0">
               <h4> Followed Podcasts &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h4>
            </div>
        </div>
    </div>


    <div class="col-md-11 featuredContent mb-4">
                                            <div class="row col-md-12 pl-0 pr-0">
                                                <div class="col-md-12 d-none noEventMsg">
                                            <p class="text-center"> No Records Found! </p>
                                        </div>
                                                <?php $row_count = 1;
                                                foreach ($podcasts as $podcast) { ?>
                                                <div class="col-md-3 parent showHideListDiv pl-2 pr-2">
                                                    
                                                    <div class="card">
                                                        <a href="{{url('podcasts/'. $podcast->id)}}" target="_blank"><img src="assets/images-new/sample-image.png" class="" alt="" style="width: 100%;height: 130px;"></a>

                                                        
                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $podcast->eventFollowPodcastId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "p"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$podcast->id}}" discriminator="p">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>



                                                        <div class="card-body" style="padding: 10px;">
                                                            <div class="col-md-12 row pr-0">
                                                                <a href="{{url('podcasts/'. $podcast->id)}}" target="_blank"><h6> {{$podcast->title}} </h6></a>
                                                            </div>

                                                            <?php
                            // $freeEventClass = "d-none";
                            // if($event->is_paid != 1){
                            //     $freeEventClass = "freeTextSpanClass";
                            // }
                                                            $sdStamp = strtotime($podcast->created_at);
                                                            $dateStr = date("d",  $sdStamp);
                                                            $MonthStr = date("M",  $sdStamp); 
                                                            ?>
                                                            <?php
                                                            $videoPodcastUrl = "";
                                                            $dnoneClass = "";
                                                            if (!empty($podcast)) {
                                                                $dnoneClass = "d-none";
                                                                if(substr($podcast->url, 0, 8 ) != "https://"){
                                                                    $videoPodcastUrl = $AwsUrl . $podcast->url;
                                                                }
                                                                else{
                                                                    $videoPodcastUrl = $podcast->url;
                                                                }
                                                            }
                                                            ?>
                                                            <a href="{{$videoPodcastUrl}}" target="_blank"><audio controls  class="w-100"><source src="{{$videoPodcastUrl}}" type="audio/ogg" class="col-lg-7 pr-0 pl-0"></audio></a>

                                                                <div class="col-md-12 pr-0 mt-2 pl-0" style="color:#9C9C9C;">Podcast </div>

                                                                <hr class="mt-2 mb-2">

                                                                <a href="{{url('organizer/'. $podcast->userId)}}" target="_blank">
                                                                <div class="row">
                                                                    <div class="pl-3">
                                                                        <?php
                                                                        $profileLogo = "";
                                                                        if(!is_null($podcast->profile_pic) && $podcast->profile_pic != ""){
                                                                           $profileLogo = env("AWS_URL"). $podcast->profile_pic; ?>
                                                                           <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } else{ ?>
                                                                           <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } ?>
                                                                       </div>
                                                                       <div class="">
                                                                        <h6 class="mt-2 ml-2"> {{$podcast->name}} </h6>
                                                                    </div>
                                                                </div>
                                                            </a>


                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <?php } ?>

                                                </div>
    </div>

    <?php } ?>




</div>

@endsection

@section('script')
<script src="{{asset('/js/custom.js?v='.$v)}}" type="text/javascript"></script>
@endsection