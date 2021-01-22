<?php $v = "1.0.1"; ?>
@extends('layouts.appFront')
@section('content')

<div class="container mainHomePageContainer pt-3" style="">

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
			<div class="card w-100" style="border-radius: 6px;">
                <div class="card-body p-0">
                    <?php
                         $AwsUrl = env('AWS_URL');
                         $videoUrl = "";
                         if (!empty($video->url)) {
                            if($video->url_type == 1){
                                $videoUrl = $AwsUrl . $video->url; ?>
                	<div class="videoContainerDiv" style="position: relative;">
                                 <video class="" src="{{$videoUrl}}" width="100%" height="100%" controls="controls" style="border-radius: 6px;"></video>
                    </div>
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
                                }?>
                                <div class="videoContainerDiv" style="position: relative;padding-top: 56.25%;">
                                <iframe style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;border-radius: 6px;" src="{{$url}}" frameborder="0"></iframe> </div>
                     <?php  }
                }?>

                	<div class="videoContent" style="padding: 0px 45px;">
                	<h5 class="mt-4"> {{$video->title}} </h5>

                	<?php $videoDesc = "";
                    if(isset($video->event)){
                        $videoDesc = $video->event->description;
                    }
                    else{
                        $videoDesc = $video->description;
                    } ?>
                	<p class="mt-3">{{$videoDesc}}</p>
                </div>

                	<hr>

                	<div class="commentsDiv mb-5" style="padding: 0px 45px;">
                		<h5 class="mt-2 mb-4"> Comments </h5>

                		<div class="row parent mb-3">
                			<div class="pl-2 col-md-1">
                				<img class="align-self-start profileImg" src="https://panelhiveus.s3.us-west-1.amazonaws.com/org_5/Profile/1606136463image-1.jpg" alt="user avatar" style="width: 45px !important;height: 45px !important;">
                			</div>

                			<div class="col-md-11">
                				<h6 class="mt-1 mb-0"> Mansi Mehta </h6>
                				<?php
                					$comment = "Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he developed following a personal crisis. Cohen and Professor Francesca Gino, author of a case study about the company, discuss whether that approach can endure through rapid growth, a leadership transition, and changing employee expectations.";
                					$commentText = substr($comment,0,140).'...';
                				 ?>
                				<div class="contentDiv fullContent d-none mb-2">{{$comment}}</div>
                				<div class="shortContent mb-2">{{$commentText}}</div>
                				<u><a style="cursor: pointer;color: black;" class="show_hide" data-content="toggle-text" onclick="showHideComments(this);">Show More</a></u>
                				
                			</div>

                		</div>

                        <div class="row parent mb-3">
                            <div class="pl-2 col-md-1">
                                <img class="align-self-start profileImg" src="https://panelhiveus.s3.us-west-1.amazonaws.com/org_5/Profile/1606136463image-1.jpg" alt="user avatar" style="width: 45px !important;height: 45px !important;">
                            </div>

                            <div class="col-md-11">
                                <h6 class="mt-1 mb-0"> Mansi Mehta </h6>
                                <?php
                                    $comment = "Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he developed following a personal crisis. Cohen and Professor Francesca Gino, author of a case study about the company, discuss whether that approach can endure through rapid growth, a leadership transition, and changing employee expectations.";
                                    $commentText = substr($comment,0,140).'...';
                                 ?>
                                <div class="contentDiv fullContent d-none mb-2">{{$comment}}</div>
                                <div class="shortContent mb-2">{{$commentText}}</div>
                                <u><a style="cursor: pointer;color: black;" class="show_hide" data-content="toggle-text" onclick="showHideComments(this);">Show More</a></u>
                                
                            </div>

                        </div>

                	</div>

            	</div>
        	</div>
    	</div>

		<div class="col-md-3 col-lg-3">

            <a href="{{url('organizer/'. $video->user->id)}}" target="_blank">
			<div class="card w-100 d-flex align-items-center" style="margin-top: 15%;border-radius: 6px;">
				<?php
                    $profileLogo = "";
                    if(!is_null($video->user->profile_pic) && $video->user->profile_pic != ""){
                   	 $profileLogo = env("AWS_URL"). $video->user->profile_pic; ?>
                     <img class="videoUserprofileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                <?php } else{ ?>
                        <img class="videoUserprofileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                <?php } ?>

                <div class="card-body pt-3">
                    <div class="d-flex justify-content-center">
                	   <h6> {{$video->user->name}} </h6>
                    </div>

                    <div class="row pt-2">
                        <i style="color: #9C9C9C;" aria-hidden="true" class="fa fa-location-arrow pr-1 pt-1"></i>
                        <p style="color: #9C9C9C;">{{$video->user->location}}</p>&nbsp;&nbsp;&nbsp;
                        <p class="" style="color: #9C9C9C;">134 followers </p>
                    </div>

                	<div class="followingDiv row d-flex justify-content-center">
     					<a href="#">
                		<input type="button" id="" class="clickable createEventButton buttonMobileSize mt-2" value="Follow" style="background: #FED8C6;color:black;height:40px;"></a>
     				</div>

                </div>
            </div>
        </a>

            <?php if($eventCategoriesResult){ ?>
            <h5 class="mt-4"> Tags </h5>

            <div class="TagNames row">
                    @foreach($eventCategoriesResult as $eventCategoryresult)
     				<div class="col-md-6 pr-0 pl-0 mt-2">
     					<div class="eventCategoryTag">
     						<p class="text-center mb-0" style="font-weight: 300;font-size: 13px;color:#9C9C9C;"> #{{$eventCategoryresult->name}} </p>
     					</div>
     				</div>
                    @endforeach
     		</div>
            <?php } ?>

     		<h5 class="mt-4"> Share </h5>

     		<div class="col-md-12 col-lg-12 row">
     			<a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1 float-right" style="background-color:white;"><i aria-hidden="true" class="fa fa-link" style="color: #9C9C9C;"></i></a>
     			<a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-linkedin"></i></a>
     			<a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>
     		</div>

		</div>
	</div>

	<div class="col-md-12 videosList mb-4" style="padding: 0px 40px;padding-bottom: 50px;">
     	<h5 class="mb-4"> Videos you may like </h5>

     	<div class="row col-md-12 pl-0 pr-0">
			<?php
            foreach ($videosList as $videoList) { ?>
            <div class="col-md-3 parent showHideListDiv pl-2 pr-2">
                <div class="card">
                <?php
                	$sdStamp = strtotime($videoList->created_at);
                	$dateStr = date("d",  $sdStamp);
                    $MonthStr = date("M",  $sdStamp); 
                ?>
                <?php
                    $AwsUrl = env('AWS_URL');
                    $videoUrl = "";
                    if (!empty($videoList->url)) {
                        if($videoList->url_type == 1){
                          	$videoUrl = $AwsUrl . $videoList->url; ?>
                       		<a href="{{url('videos/'. $videoList->id)}}" target="_blank">
                            <video class="" src="{{$videoUrl}}" width="100%" height="100%" controls="controls" style="border-radius: 6px 6px 0px 0px;"></video></a>
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
                            } ?>
                            <a href="{{url('videos/'. $videoList->id)}}" target="_blank">
                            <iframe width="240px" height="130px" src="{{$url}}" frameborder="0" class="videoIframe" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe></a>
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
                        	  $eventDescText = "";
                         	if(isset($videoList->event)){
                                $eventDesc = $videoList->event->description;
                                $eventDescText = substr($eventDesc,0,80).'...';
                            }
                            else{
                                $eventDesc = $videoList->description;
                                $eventDescText = substr($eventDesc,0,80).'...';
                            } ?>
                                
                                <div class="col-md-12 pr-0 pl-0" style="color: black;">{{$eventDescText}}</div>

                                <div class="col-md-12 pr-0 mt-2 mr-2 pl-0" style="color:#9C9C9C;">Video </div> </a>
                                
                                 <hr class="mt-2 mb-2">

                                 <a href="{{url('organizer/'. $videoList->user->id)}}" target="_blank">
                                 <div class="row">
                                    <div class="pl-3">
                                     <?php
                                        $profileLogo = "";
                                        if(!is_null($videoList->user->profile_pic) && $videoList->user->profile_pic != ""){
                                            $profileLogo = env("AWS_URL"). $videoList->user->profile_pic; ?>
                                            <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                        <?php } else{ ?>
                                            <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                        <?php } ?>
                                    </div>
                                                                   
                                    <div class="">
                                       <h6 class="mt-2 ml-2"> {{$videoList->user->name}} </h6>
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

@endsection