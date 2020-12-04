<?php $v = "1.0.1"; ?>
@extends('layouts.appFront')
@section('content')
    <?php $AwsUrl = env('AWS_URL'); ?>
                <div class="container mainHomePageContainer" style="">
                    <div class="col-md-12 col-lg-12 d-flex align-items-center" style="background:url('assets/images-new/banner-image-1.png'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:350px; padding:unset;">
                        <!--<img src="assets/images-new/banner-image-1.png" class="w-100 bannerImage">-->
                        <div class="col-md-6 bannerImageOverlay">
                            <div class="bannerText">
                                <h4 class="fontSizeCss"> Hub for all great learning.<br>Start your journey with us!</h4>
                                <?php
                                if(Auth::check()){ 
                                    if(Auth::user()->user_type == 1) {?>
                                <a href="{{ url('org/events') }}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize mt-3" value="Create your event"></a>
                                <?php } else{ ?>
                                    <!-- <a href="{{ route('register') }}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize mt-3" value="Create your event"></a> -->
                                    <a href="{{url('allContent/1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize mt-3" value="Browse Events"></a>
                               <?php } } else{?>
                                    <a href="{{ route('register') }}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize mt-3" value="Create your event"></a>
                           <?php }
                                ?>
                                </div>
                            </div>
                        </div> 

                        <div class="col-md-12 col-lg-12 mt-4 mb-4">
                            <h4> Featured Content </h4>
                        </div>

                        <div class="col-md-11 featuredContent mb-4">
                            <!-- <img src="assets/images-new/banner-image-2.png" class="w-100"> -->
                            <!-- carousel start -->
                            <div id="carouselExampleIndicators" class="carousel slide w-100" data-ride="carousel">
                                <?php $countIndicatorActive = 0;
                                  ?>
                              <!-- Indicators -->
                              <ol class="carousel-indicators">
                                <?php for($countIndicator=1;$countIndicator<=count($eventsFeature);$countIndicator++) { ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{$countIndicator-1}}" class="<?php if($countIndicatorActive==0){ echo "active"; } else{ echo " ";}?>"></li>
                                
                                <?php $countIndicatorActive++;
                                 } ?>
                                <!-- <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li> -->
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <?php $count = 0;
                                    foreach ($eventsFeature as $eventFeature) {
                                    $sdStamp = strtotime($eventFeature->date_time);
                                    $dateStr = date("d",  $sdStamp);
                                    $MonthStr = date("M",  $sdStamp);
                                    $bannerImageSrc = "";
                                    if($eventFeature->banner){
                                        $bannerImageSrc = env('AWS_URL') . $eventFeature->banner;
                                    } else {
                                        $bannerImageSrc = "assets/images-new/banner-image-2.png";
                                    }
                                ?>
                                <div class="carousel-item <?php if($count==0){ echo "active"; } else{ echo " ";}?>">
                                    <a href="{{url('events/'. $eventFeature->id)}}">
                                    <img class="d-block w-100" src="{{$bannerImageSrc}}" data-color="lightblue" alt="First Image" style="height: 365px;border-radius: 6px;"></a>
                                    <a href="{{url('events/'. $eventFeature->id)}}">
                                    <div class="col-md-6 bannerImageOverlay banner2">
                                <div class="bannerText2">
                                    <div class="col-md-12 row">
                                        <div class="col-md-3 pl-0 pr-0 mobSlider">
                                            <h4> {{$dateStr}} <br> {{$MonthStr}} </h4>
                                        </div>

                                        <div class="col-md-9 mobSlider1">
                                            <h4 class="text-left"> {{$eventFeature->title}} </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 pl-0 pr-0">
                                    <p class=" Pmobmargin " style="color: black;font-weight: 500;">
                                        <?php $eventDesc = substr($eventFeature->description,0,140).'...'; ?>
                                        {{$eventDesc}}</p>
                                </div>
                            </div></a>
                                  <div class="carousel-caption d-md-block">
                                    <!-- <h5>First Image</h5> -->
                                </div>
                            </div>
                            <?php $count++; } ?>
                </div>
            </div>
<!-- carousel end -->

                        </div>

                        <div class="col-md-11 featuredContent mb-4">

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



                            <div class="card w-100">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mainTab">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#contentTab" onclick=""><span class="tabSpan">All Content</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link eventsTab" data-toggle="tab" href="#eventsTab" onclick=""><span class="tabSpan">Events</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#videoTab" onclick=""><span class="tabSpan">Videos</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#audioTab" onclick=""><span class="tabSpan">Podcasts</span></a>
                                        </li>
                                    </ul>

                                    <ul class="nav categoriesNav mt-2" style="">
                                        @foreach($categories as $category)
                                        <li class="nav-item mobileNav" style="margin-right: 1rem;">
                                            <a class="nav-link" data-toggle="tab" href="#" onclick="showHideEventListing(this);" data-id="{{$category->id}}"><span class="" style="letter-spacing: 0px;">{{$category->name}}</span></a>
                                        </li>
                                        @endforeach
                                        <!-- <li class="nav-item ml-4">
                                            <a class="nav-link active" data-toggle="tab" href="#"><span class="hidden-xs">All</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#"><span class="hidden-xs">Business</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#"><span class="hidden-xs">Finance</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#"><span class="hidden-xs">Mindfullness</span></a>
                                        </li> -->
                                    </ul>

                                </div>
                            </div>




                            <!-- sample mobile view -->
                                <!-- <div class="col-lg-6">
           <div class="card">
              <div class="card-body"> 
                <ul class="nav nav-tabs mainTab">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><i class=""></i> <span class="hidden-xs">Home</span></a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void();" aria-expanded="false"><i class=""></i> <span class="hidden-xs">Events</span></a>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 42px, 0px);">
                      <a class="dropdown-item" data-toggle="tab" href="#tabe-3">Link 1</a>
                      <a class="dropdown-item" href="javascript:void();">Link 2</a>
                      <a class="dropdown-item" href="javascript:void();">Link 3</a>
                    </div>
                  </li>
                 
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void();" aria-expanded="false"><i class=""></i> <span class="hidden-xs">Videos</span></a>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 42px, 0px);">
                      <a class="dropdown-item" data-toggle="tab" href="#tabe-3">Link 1</a>
                      <a class="dropdown-item" href="javascript:void();">Link 2</a>
                      <a class="dropdown-item" href="javascript:void();">Link 3</a>
                    </div>
                  </li>
                </ul> -->

                <!-- Tab panes -->
                <!-- <div class="tab-content">
                  <div id="tabe-1" class="container tab-pane active">
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
          <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet</p>
                  </div>
                  <div id="tabe-2" class="container tab-pane fade">
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          <p>It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
                  </div>
                  <div id="tabe-3" class="container tab-pane fade">
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                  </div>
                </div>
              </div>
           </div>

        </div> -->


                            <!-- sample mobile view -->




                        </div>

                        <div class="tab-content">
                            <div class="row tab-pane active" id="contentTab">
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="col-md-12 row MobDisplay">
                                        <div class="col-md-4 pl-0">
                                            <h4> All Content &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </h4>
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                            <div class="dropdown-menu">
                                                @foreach($countries as $country)
                                                <a class="dropdown-item" href="#">{{$country->name}}</a>
                                                @endforeach
                                                <!-- <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a> -->
                                            </div>
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
                                            <?php
                                            $eventCat = "";
                                         foreach ($event->categories as $EventCategory) {
                                         $eventCat .= $EventCategory->id . ',';
                                          ?>
                                        <?php }
                                         ?>
                                         <input type="hidden" class="eventCatID" value="<?php echo $eventCat; ?>">
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
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $event->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
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
                                                    <div class="col-md-12 row pr-0" style="padding: unset;margin:unset;">
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
                                                    <div id="heading<?php echo $row_count ?>" class="mt-2 ml-2 mr-2 collapse" style="color: black;">
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

                                        <?php $row_count = 1;
                                        foreach ($videos as $video) { ?>
                                        <div class="col-md-3 parent showHideListDiv pl-2 pr-2">
                                           <?php
                                           $eventCat = "";
                                            if($video->event_id != '' || $video->event_id != "NULL") {
                                                foreach($eventCategories as $eventCategory) {
                                                if($eventCategory->event_id == $video->event_id) {
                                                $eventCat .= $eventCategory->category_id . ','; ?>
                                        <?php }  ?>
                                            
                                      <?php  } }
                                       ?>
                                       <input type="hidden" class="eventCatID" value="<?php echo $eventCat; ?>">
                                            <div class="card">
                                                <?php
                            // $freeEventClass = "d-none";
                            // if($event->is_paid != 1){
                            //     $freeEventClass = "freeTextSpanClass";
                            // }
                                                $sdStamp = strtotime($video->created_at);
                                                $dateStr = date("d",  $sdStamp);
                                                $MonthStr = date("M",  $sdStamp); 
                                                ?>
                                                <?php
                                                $AwsUrl = env('AWS_URL');
                                                $videoUrl = "";
                                                if (!empty($video->url)) {
                                                    if($video->url_type == 1){
                                                        $videoUrl = $AwsUrl . $video->url; ?>
                                                        <!-- <a href="{{$videoUrl}}" target="_blank"> -->
                                                            <a href="{{url('videos/'. $video->id)}}" target="_blank">
                                                            <video class="" src="{{$videoUrl}}" width="100%" height="100%" controls="controls" style="border-radius: 6px 6px 0px 0px;"></video>
                                                        </a>
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
                                                                <iframe class="MobFrame" width="240px" height="130px" frameborder="0" src="{{$url}}" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe>
                                                            </a>
                                                            <?php  }
                                                        }
                                                        ?>
                                                        <!-- <a href="#"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;"></a> -->
                                                        <!-- <span class="{{$freeEventClass}} mt-2">FREE</span> -->
                                                        
                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $video->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "v"){
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
                                                            if(isset($video->event)){
                                                // $eventPrefix = "Event : ";
                                                // $eventDesc = $eventPrefix.$video->event->title;
                                                                $eventDesc = $video->event->description;
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

                                                            <a href="{{url('organizer/'. $video->user->id)}}" target="_blank">
                                                            <div class="row">
                                                                <div class="pl-3">
                                                                    <?php
                                                                    $profileLogo = "";
                                                                    if(!is_null($video->user->profile_pic) && $video->user->profile_pic != ""){
                                                                       $profileLogo = env("AWS_URL"). $video->user->profile_pic; ?>
                                                                       <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } else{ ?>
                                                                       <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } ?>
                                                                   </div>
                                                                   <div class="">
                                                                    <h6 class="mt-2 ml-2"> {{$video->user->name}} </h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>

                                                 <?php $row_count = 1;
                                                foreach ($podcasts as $podcast) { ?>
                                                <div class="col-md-3 parent showHideListDiv pl-2 pr-2">
                                                    <?php
                                           $eventCat = "";
                                            if($podcast->event_id != '' || $podcast->event_id != "NULL") {
                                                foreach($eventCategories as $eventCategory) {
                                                if($eventCategory->event_id == $podcast->event_id) {
                                                $eventCat .= $eventCategory->category_id . ','; ?>
                                        <?php }  ?>
                                            
                                      <?php  } }
                                       ?>
                                       <input type="hidden" class="eventCatID" value="<?php echo $eventCat; ?>">
                                                    <div class="card">
                                                        <a href="{{url('podcasts/'. $podcast->id)}}" target="_blank"><img src="assets/images-new/sample-image.png" class="" alt="" style="width: 100%;height: 130px;"></a>

                                                        
                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $podcast->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "p"){
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

                                                                <a href="{{url('organizer/'. $podcast->user->id)}}" target="_blank">
                                                                <div class="row">
                                                                    <div class="pl-3">
                                                                        <?php
                                                                        $profileLogo = "";
                                                                        if(!is_null($podcast->user->profile_pic) && $podcast->user->profile_pic != ""){
                                                                           $profileLogo = env("AWS_URL"). $podcast->user->profile_pic; ?>
                                                                           <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } else{ ?>
                                                                           <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } ?>
                                                                       </div>
                                                                       <div class="">
                                                                        <h6 class="mt-2 ml-2"> {{$podcast->user->name}} </h6>
                                                                    </div>
                                                                </div>
                                                            </a>


                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <?php } ?>

                                    </div>
                                </div>

                                <div class="col-md-12 mb-5 mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                    <a href="{{url('allContent/1/0/page=1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                </div>

                            </div>

                            <div class="row tab-pane" id= "eventsTab">
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="col-md-12 row MobDisplay">
                                        <div class="col-md-4 pl-0">
                                            <h4> Events &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                            <div class="dropdown-menu">
                                                @foreach($countries as $country)
                                                <a class="dropdown-item" href="#">{{$country->name}}</a>
                                                @endforeach
                                                <!-- <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a> -->
                                            </div>
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

                                            <?php
                                            $eventCat = "";
                                         foreach ($event->categories as $EventCategory) {
                                         $eventCat .= $EventCategory->id . ',';
                                          ?>
                                        <?php }
                                         ?>
                                         <input type="hidden" class="eventCatID" value="<?php echo $eventCat; ?>">

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
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $event->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
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

                                <div class="col-md-12 mb-5 seeMoreEvent mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                    <a href="{{url('allContent/2/0/page=1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                </div>

                            </div>

                            <div class="row tab-pane" id= "videoTab">
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="col-md-12 row MobDisplay">
                                        <div class="col-md-4 pl-0">
                                            <h4>Videos &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                            <div class="dropdown-menu">
                                                @foreach($countries as $country)
                                                <a class="dropdown-item" href="#">{{$country->name}}</a>
                                                @endforeach
                                                <!-- <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a> -->
                                            </div>
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

                                            <?php
                                           $eventCat = "";
                                            if($video->event_id != '' || $video->event_id != "NULL") {
                                                foreach($eventCategories as $eventCategory) {
                                                if($eventCategory->event_id == $video->event_id) {
                                                $eventCat .= $eventCategory->category_id . ','; ?>
                                        <?php }  ?>
                                            
                                      <?php  } }
                                       ?>
                                       <input type="hidden" class="eventCatID" value="<?php echo $eventCat; ?>">

                                            <div class="card">
                                                <?php
                            // $freeEventClass = "d-none";
                            // if($event->is_paid != 1){
                            //     $freeEventClass = "freeTextSpanClass";
                            // }
                                                $sdStamp = strtotime($video->created_at);
                                                $dateStr = date("d",  $sdStamp);
                                                $MonthStr = date("M",  $sdStamp); 
                                                ?>
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
                                                                <iframe width="240px" height="130px" src="{{$url}}" frameborder="0" class="" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe></a>
                                                            <?php  }
                                                        }
                                                        ?>
                                                        <!-- <a href="#"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;"></a> -->
                                                        <!-- <span class="{{$freeEventClass}} mt-2">FREE</span> -->
                                                        

                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $video->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "v"){
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
                                                            if(isset($video->event)){
                                                // $eventPrefix = "Event : ";
                                                // $eventDesc = $eventPrefix.$video->event->title;
                                                                $eventDesc = $video->event->description;
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

                                                            <a href="{{url('organizer/'. $video->user->id)}}" target="_blank">
                                                            <div class="row">
                                                                <div class="pl-3">
                                                                    <?php
                                                                    $profileLogo = "";
                                                                    if(!is_null($video->user->profile_pic) && $video->user->profile_pic != ""){
                                                                       $profileLogo = env("AWS_URL"). $video->user->profile_pic; ?>
                                                                       <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } else{ ?>
                                                                       <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } ?>
                                                                   </div>
                                                                   <div class="">
                                                                    <h6 class="mt-2 ml-2"> {{$video->user->name}} </h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>

                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-5 mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                        <a href="{{url('allContent/3/0/page=1')}}">
                                        <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                        </div>

                                    </div>


                                    <div class="row tab-pane" id= "audioTab">
                                        <div class="col-md-11 featuredContent mb-4">
                                            <div class="col-md-12 row MobDisplay">
                                                <div class="col-md-4 pl-0">
                                                    <h4>Podcasts &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                                                </div>
                                                <div class="col-md-8">
                                                    <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                                    <div class="dropdown-menu">
                                                        @foreach($countries as $country)
                                                <a class="dropdown-item" href="#">{{$country->name}}</a>
                                                @endforeach
                                                        <!-- <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a> -->
                                                    </div>
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
                                                    <?php
                                           $eventCat = "";
                                            if($podcast->event_id != '' || $podcast->event_id != "NULL") {
                                                foreach($eventCategories as $eventCategory) {
                                                if($eventCategory->event_id == $podcast->event_id) {
                                                $eventCat .= $eventCategory->category_id . ','; ?>
                                        <?php }  ?>
                                            
                                      <?php  } }
                                       ?>
                                       <input type="hidden" class="eventCatID" value="<?php echo $eventCat; ?>">
                                                    <div class="card">
                                                        <a href="{{url('podcasts/'. $podcast->id)}}" target="_blank"><img src="assets/images-new/sample-image.png" class="" alt="" style="width: 100%;height: 130px;"></a>

                                                        
                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $podcast->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "p"){
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

                                                                <a href="{{url('organizer/'. $podcast->user->id)}}" target="_blank">
                                                                <div class="row">
                                                                    <div class="pl-3">
                                                                        <?php
                                                                        $profileLogo = "";
                                                                        if(!is_null($podcast->user->profile_pic) && $podcast->user->profile_pic != ""){
                                                                           $profileLogo = env("AWS_URL"). $podcast->user->profile_pic; ?>
                                                                           <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } else{ ?>
                                                                           <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } ?>
                                                                       </div>
                                                                       <div class="">
                                                                        <h6 class="mt-2 ml-2"> {{$podcast->user->name}} </h6>
                                                                    </div>
                                                                </div>
                                                            </a>


                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <?php } ?>

                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-5 mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                                <a href="{{url('allContent/4/0/page=1')}}">
                                                <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="col-md-12 mb-5 card">
                                        <div class="card-body col-md-12 row">
                                            <div class="col-md-6">
                                                <h3 class="communityHeader"> <a style="color:#FD6568;"> JOIN </a> OUR <br> COMMUNITY! </h3> <br>
                                                <p class="communityText"> As an Organiser, you can list your events, manage them, showcase videos and podcasts of previous events.</p>
                                                <a href="#">
                                                    <input type="button" id="" class="clickable createEventButton mt-3" value="Learn More" style="margin-left:18%;"></a>
                                                </div>

                                                <div class="col-md-6">
                                                    <img src="assets/images-new/Community 1.jpg" class="w-100">
                                                </div>
                                            </div>
                                            <!-- <img src="assets/images-new/join-community.png" class="w-100"> -->
                                        </div>

                                    </div>
@endsection

@section('script')
<script src="{{asset('/js/custom.js?v='.$v)}}" type="text/javascript"></script>
@endsection