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
                            <input type="hidden" class="saveOrgFollower" value="{{url('saveOrgFollower')}}">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3 pl-0">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class=""><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="featuredContent mb-4 row" style="">
        <!-- padding: 0px 40px; -->
		<div class="col-md-9 col-lg-9">
			<div class="card w-100" style="border-radius: 6px;">
                <div class="card-body p-0">
                	<?php
                         $AwsUrl = env('AWS_URL');
                         $podcastUrl = "";
                         if (!empty($podcast->url)) {
                            if(substr($podcast->url, 0, 8 ) != "https://"){
                                $podcastUrl = $AwsUrl . $podcast->url;
                            } else{
                                $podcastUrl = $podcast->url;
                            } ?>
                			<div class="podcastContainerDiv mt-4" style="position: relative;">
                         		<audio controls  class="w-100"><source src="{{$podcastUrl}}" type="audio/ogg" class=""></audio>
                    		</div>
                     <?php } ?>
                    

                	<div class="podcastContent" style="padding: 0px 45px;">
                	<h5 class="mt-4"> {{$podcast->title}} </h5>

                	<?php $podcastDesc = "";
                    if(isset($podcast->event)){
                        $podcastDesc = $podcast->event->description;
                    }
                    else{
                        $podcastDesc = $podcast->description;
                    } ?>
                	<p class="mt-3">{{$podcastDesc}}</p>
                </div>

                	<hr>
                	@include('layouts.commentsView', ['comment' => 'comment'])
            	</div>
        	</div>
    	</div>

    	<div class="col-md-3 col-lg-3">
            @include('layouts.orgDetailView', ['section' => $podcast])

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

     		@include('layouts.appShare')

		</div>

	</div>

	<div class="col-md-12 podcastsList mb-4" style="padding-bottom: 50px;">
        <!-- padding: 0px 40px; -->
     	<h5 class="mb-4"> Podcasts you may like </h5>

     	<div class="row col-md-12 pl-0 pr-0">
     		<?php foreach($podcastsList as $podcastList) { ?>

     			<div class="col-md-3 parent showHideListDiv pl-2 pr-2">
                                                    
                    <div class="card">
                       	<a href="{{url('podcasts/'. $podcastList->id)}}" target="_blank"><img src="../assets/images-new/sample-image.png" class="" alt="" style="width: 100%;height: 130px;"></a>

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
                        </span></a>



                         <div class="card-body" style="padding: 10px;">
                            <div class="col-md-12 row pr-0">
                                <a href="{{url('podcasts/'. $podcastList->id)}}" target="_blank"><h6> {{$podcastList->title}} </h6></a>
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

                              	<hr class="mt-2 mb-2">

                                <a href="{{url('organizer/'. $podcastList->user->id)}}" target="_blank">
                                <div class="row">
                                    <div class="pl-3">
                                       <?php
                                        	$profileLogo = "";
                                           if(!is_null($podcastList->user->profile_pic) && $podcastList->user->profile_pic != ""){
                                              	$profileLogo = env("AWS_URL"). $podcastList->user->profile_pic ?>
                                                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                          	<?php } else{ ?>
                                               <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                            <?php } ?>
                                    </div>
                                    <div class="">
                                        <h6 class="mt-2 ml-2"> {{$podcastList->user->name}} </h6>
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