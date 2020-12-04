<?php $v = "1.0.1"; ?>
@extends('layouts.appFront')
@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container mainHomePageContainer pt-3" style="">
	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-4 pl-2"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="col-md-11 featuredContent mb-4">
        <div class="col-md-12 row MobDisplay">
            <div class="col-md-4 pl-0">
               <h4> My Events &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h4>
            </div>
        </div>
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

                                                    <a href="{{url('organizer/'. $event->user->id)}}" target="_blank">
                                                    <div class="row">
                                                        <div class="pl-3">
                                                            <?php
                                                            $profileLogo = "";
                                                            if(!is_null($event->user->profile_pic) && $event->user->profile_pic != ""){
                                                               $profileLogo = env("AWS_URL"). $event->user->profile_pic; ?>
                                                               <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } else{ ?>
                                                               <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } ?>
                                                           </div>
                                                           <div class="">
                                                            <h6 class="mt-2 ml-2"> {{$event->user->name}} </h6>
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