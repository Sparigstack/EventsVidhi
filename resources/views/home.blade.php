<?php $v = "1.0.1"; ?>
@extends('layouts.appFront')
@section('content')
    <?php $AwsUrl = env('AWS_URL'); ?>
                <div class="container mainHomePageContainer" style="">

                    <input type="hidden" class="homePageUrl" value="{{url('/')}}">

<!-- 'assets/images-new/banner-image-1.png' -->
                    <div class="col-md-12 col-lg-12 d-flex align-items-center" style="background:url('{{asset('assets/images-new/banner-image-1.png')}}'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:350px; padding:unset;">
                        <!--<img src="assets/images-new/banner-image-1.png" class="w-100 bannerImage">-->
                        <div class="col-md-6 bannerImageOverlay">
                            <div class="bannerText">
                                <h4 class="fontSizeCss"> Hub for all great learning.<br>Start your journey with us!</h4>
                                <?php
                                if(Auth::check()){ 
                                    if(Auth::user()->user_type == 1) {?>
                                <a href="{{ url('org/events') }}" target="_blank">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize mt-3" value="Create your event"></a>
                                <?php } else{ ?>
                                    <!-- <a href="{{ route('register') }}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize mt-3" value="Create your event"></a> -->
                                    <a href="{{url('allContent/1/0/0/page=1')}}">
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
                                    $imageSrc = "url({{ URL::asset('assets/images-new/banner-image-2.png') }})";
                                    if($eventFeature->banner){
                                        $bannerImageSrc = env('AWS_URL') . $eventFeature->banner;
                                    } else {
                                        if($tabId == NULL){
                                            $bannerImageSrc = "assets/images-new/banner-image-2.png";
                                        } else {
                                            $bannerImageSrc = "../../assets/images-new/banner-image-2.png";
                                        }
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
                                $activeClass = "active";
                                $dnoneClass = "d-none";
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
                                            <a class="nav-link <?php if($tabId == 1 || $tabId == NULL){ echo $activeClass;} ?>" data-toggle="tab" href="javascript:void(0);" onclick="showHidecategoriesNavItem(this);" value="1"><span class="tabSpan">All Content</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link <?php if($tabId == 2){ echo $activeClass;} ?> eventsTab" data-toggle="tab" href="javascript:void(0);" onclick="showHidecategoriesNavItem(this);" value="2"><span class="tabSpan">Events</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link <?php if($tabId == 3){ echo $activeClass;} ?>" data-toggle="tab" href="javascript:void(0);" onclick="showHidecategoriesNavItem(this);" value="3"><span class="tabSpan">Videos</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link <?php if($tabId == 4){ echo $activeClass;} ?>" data-toggle="tab" href="javascript:void(0);" onclick="showHidecategoriesNavItem(this);" value="4"><span class="tabSpan">Podcasts</span></a>
                                        </li>
                                    </ul>

                                    <ul class="nav categoriesNav mt-2" style="">
                                        @foreach($categories as $category)
                                        <?php
                                            $activeCatClass = '';
                                            if($categoryId == $category->id){
                                                $activeCatClass = "active";
                                            }
                                         ?>
                                        <li class="nav-item mobileNav" style="margin-right: 1rem;">
                                            <a class="nav-link {{$activeCatClass}}" data-toggle="tab" href="javascript:void(0)" onclick="filterByCategoryList(this);" data-id="{{$category->id}}"><span class="" style="letter-spacing: 0px;">{{$category->name}}</span></a>
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

                        </div>

                        <div class="tab-content">
                            <div class="row tab-pane <?php if($tabId == 1 || $tabId == NULL){ echo $activeClass;} ?>" id="contentTab">
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
                                        if(count($allDataResult) > 0){
                                        foreach ($allDataResult as $allData) {
                                        if($allData->videoId == NULL && $allData->podcastId == NULL) { ?>
                                        <?php
                                        $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                        if (!empty($allData->eventThumbnail)) {
                                            $logoUrl = $AwsUrl . $allData->eventThumbnail;
                                        }
                                        ?>

                                        <div class="col-md-3 showHideListDiv eventListDiv parent pl-2 pr-2">
                                            
                                            <div class="card">
                                                <?php
                                                $freeEventClass = "d-none";
                                                if($allData->eventPaid != 1){
                                                    $freeEventClass = "freeTextSpanClass";
                                                }
                                                $sdStamp = strtotime($allData->eventDateTime);
                                                $dateStr = date("d",  $sdStamp);
                                                $MonthStr = date("M",  $sdStamp); 
                                                ?>
                                                <a href="{{url('events/'. $allData->eventId)}}" target="_blank"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;border-radius: 6px 6px 0px 0px;"></a>
                                                <span class="{{$freeEventClass}} mt-2">FREE</span>

                                                <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $allData->eventId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$allData->eventId}}" discriminator="e">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>

                                                <div class="card-body" style="padding: 10px;">
                                                    <a href="{{url('events/'. $allData->eventId)}}" target="_blank">
                                                    <div class="col-md-12 row pr-0" style="padding: unset;margin:unset;">
                                                        <div class="col-md-2 pr-0 pl-1 mobRowDisplay">
                                                            <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                                                        </div>
                                                        <div class="col-md-10 pl-2 pr-0 mobRowDisplay1">
                                                            <h6> {{$allData->eventTitle}} </h6>
                                                        </div>
                                                    </div> </a>

                                                    <?php
                                                    for ($x = 0; $x < 1; $x++) {  ?>
                                                    <a class="text-center chevronClass" data-toggle="collapse" aria-expanded="false" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down" style="color: #9C9C9C;"></i>
                                                    <i class="fa fa-chevron-up" style="color: #9C9C9C;"></i></a>
                                                    <div id="heading<?php echo $row_count ?>" class="mt-2 ml-2 mr-2 collapse" style="color: black;">
                                                        {{$allData->eventDesc}}
                                                    </div>
                                                    <?php $row_count++; } ?>

                                                    <?php if($allData->eventOnline == 1){ ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;">Online Event </div>
                                              <?php  } else { ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;"> <i aria-hidden="true" class="fa fa-location-arrow pr-1"></i> {{$allData->eventCity}},  {{$allData->eventState}}</div>
                                                <?php } ?>

                                                    <hr class="mt-2 mb-2">

                                                    <a href="{{url('organizer/'. $allData->userId)}}" target="_blank">
                                                    <div class="row">
                                                        <div class="pl-3">
                                                            <?php
                                                            $profileLogo = "";
                                                            if(!is_null($allData->userProfilePic) && $allData->userProfilePic != ""){
                                                               $profileLogo = env("AWS_URL"). $allData->userProfilePic; ?>
                                                               <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } else{ ?>
                                                               <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } ?>
                                                           </div>
                                                           <div class="">
                                                            <h6 class="mt-2 ml-2"> {{$allData->userName}} </h6>
                                                        </div>
                                                    </div>
                                                </a>

                                                </div>
                                            </div> 
                                        </div>
                                        <?php }  ?>

                                        <?php 
                                        // $row_count = 1;
                                        if($allData->videoId != NULL && $allData->podcastId == NULL){ ?>
                                        <div class="col-md-3 parent showHideListDiv pl-2 pr-2">
                                           
                                            <div class="card">
                                                <?php
                            // $freeEventClass = "d-none";
                            // if($event->is_paid != 1){
                            //     $freeEventClass = "freeTextSpanClass";
                            // }
                                                // $sdStamp = strtotime($video->created_at);
                                                // $dateStr = date("d",  $sdStamp);
                                                // $MonthStr = date("M",  $sdStamp); 
                                                ?>
                                                <?php
                                                $AwsUrl = env('AWS_URL');
                                                $videoUrl = "";
                                                if (!empty($allData->videoUrl)) {
                                                    if($allData->videoUrlType == 1){
                                                        $videoUrl = $AwsUrl . $allData->videoUrl; ?>
                                                        <!-- <a href="{{$videoUrl}}" target="_blank"> -->
                                                            <a href="{{url('videos/'. $allData->videoId)}}" target="_blank">
                                                            <video class="" src="{{$videoUrl}}" width="100%" height="100%" controls="controls" style="border-radius: 6px 6px 0px 0px;"></video>
                                                        </a>
                                                        <?php   }
                                                        else{
                                                            $videoUrl = $allData->videoUrl; 
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
                                                                <a href="{{url('videos/'. $allData->videoId)}}" target="_blank">
                                                                <iframe class="MobFrame" width="240px" height="130px" frameborder="0" src="{{$url}}" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe>
                                                            </a>
                                                            <?php  }
                                                        }
                                                        ?>
                                                        
                                                        
                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $allData->videoId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "v"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$allData->videoId}}" discriminator="v">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>



                                                        <div class="card-body" style="padding: 10px;">
                                                            <a href="{{url('videos/'. $allData->videoId)}}" target="_blank">
                                                            <div class="col-md-12 pr-0 pl-0">
                                                                <h6> {{$allData->videoTitle}} </h6>
                                                            </div>

                                                            <?php $eventDesc = "";
                                                            $eventLink = "";
                                                            $desc = "";
                                                            $eventDescText = "";
                                                            if($allData->videoDesc == ''){
                                                
                                                                $eventDesc = $allData->eventVideoDesc;
                                                                $eventDescText = substr($eventDesc,0,80).'...';
                                                            }
                                                            else{
                                                                $eventDesc = $allData->videoDesc;
                                                                $eventDescText = substr($eventDesc,0,80).'...';
                                                            } 
                                                            ?>
                                                            <div class="col-md-12 pr-0 pl-0" style="color: black;">{{$eventDescText}}</div>

                                <div class="col-md-12 pr-0 mt-2 mr-2 pl-0" style="color:#9C9C9C;">Video </div> </a>

                                                            <hr class="mt-2 mb-2">

                                                            <a href="{{url('organizer/'. $allData->userId)}}" target="_blank">
                                                            <div class="row">
                                                                <div class="pl-3">
                                                                    <?php
                                                                    $profileLogo = "";
                                                                    if(!is_null($allData->userProfilePic) && $allData->userProfilePic != ""){
                                                                       $profileLogo = env("AWS_URL"). $allData->userProfilePic; ?>
                                                                       <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } else{ ?>
                                                                       <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } ?>
                                                                   </div>
                                                                   <div class="">
                                                                    <h6 class="mt-2 ml-2"> {{$allData->userName}} </h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>

                                                 <?php 
                                                 // $row_count = 1;
                                                if ($allData->videoId == NULL && $allData->podcastId != NULL) { ?>
                                                <div class="col-md-3 parent showHideListDiv pl-2 pr-2">

                                                    <?php 
                                                    $podcastImg = "";
                                                    if($tabId == NULL){
                                            $podcastImg = "assets/images-new/sample-image.png";
                                        } else {
                                            $podcastImg = "../../assets/images-new/sample-image.png";
                                        }
                                                    ?>
                                                    
                                                    <div class="card">
                                                        <a href="{{url('podcasts/'. $allData->podcastId)}}" target="_blank"><img src="{{$podcastImg}}" class="" alt="" style="width: 100%;height: 130px;"></a>

                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $allData->podcastId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "p"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$allData->podcastId}}" discriminator="p">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>



                                                        <div class="card-body" style="padding: 10px;">
                                                            <div class="col-md-12 row pr-0">
                                                                <a href="{{url('podcasts/'. $allData->podcastId)}}" target="_blank"><h6> {{$allData->podcastTitle}} </h6></a>
                                                            </div>

                                                            <?php
                                                            $videoPodcastUrl = "";
                                                            $dnoneClass = "";
                                                            if (!empty($allData->videoUrl)) {
                                                                $dnoneClass = "d-none";
                                                                if(substr($allData->videoUrl, 0, 8 ) != "https://"){
                                                                    $videoPodcastUrl = $AwsUrl . $allData->videoUrl;
                                                                }
                                                                else{
                                                                    $videoPodcastUrl = $allData->videoUrl;
                                                                }
                                                            }
                                                            ?>
                                                            <a href="{{$videoPodcastUrl}}" target="_blank"><audio controls  class="w-100"><source src="{{$videoPodcastUrl}}" type="audio/ogg" class="col-lg-7 pr-0 pl-0"></audio></a>

                                                                <div class="col-md-12 pr-0 mt-2 mr-2 pl-0" style="color:#9C9C9C;">Podcast </div>

                                                                <hr class="mt-2 mb-2">

                                                                <a href="{{url('organizer/'. $allData->userId)}}" target="_blank">
                                                                <div class="row">
                                                                    <div class="pl-3">
                                                                        <?php
                                                                        $profileLogo = "";
                                                                        if(!is_null($allData->userProfilePic) && $allData->userProfilePic != ""){
                                                                           $profileLogo = env("AWS_URL"). $allData->userProfilePic; ?>
                                                                           <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } else{ ?>
                                                                           <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } ?>
                                                                       </div>
                                                                       <div class="">
                                                                        <h6 class="mt-2 ml-2"> {{$allData->userName}} </h6>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <?php } } ?>


                                                    <div class="col-md-12 mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                    <a href="{{url('allContent/1/0/0/page=1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                </div>



                                            <?php    } else{ ?>
                                                <div class="col-md-12 noEventMsg">
                                            <p class="text-center"> No Records Found! </p>
                                        </div>
                                                    <?php } ?>

                                    </div>
                                </div>


                            </div>

                            <div class="row tab-pane <?php if($tabId == 2){ echo $activeClass;} ?>" id= "eventsTab">
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
                                        if(count($allDataResult) > 0){
                                        foreach ($allDataResult as $allData) {
                                        if($allData->videoId == NULL && $allData->podcastId == NULL) {
                                         ?>

                                        <?php
                                        $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                        if (!empty($allData->eventThumbnail)) {
                                            $logoUrl = $AwsUrl . $allData->eventThumbnail;
                                        }
                                        ?>

                                        <div class="col-md-3 showHideListDiv eventListDiv parent pl-2 pr-2">

                                            <div class="card">
                                                <?php
                                                $freeEventClass = "d-none";
                                                if($allData->eventPaid != 1){
                                                    $freeEventClass = "freeTextSpanClass";
                                                }
                                                $sdStamp = strtotime($allData->eventDateTime);
                                                $dateStr = date("d",  $sdStamp);
                                                $MonthStr = date("M",  $sdStamp); 
                                                ?>
                                                <a href="{{url('events/'. $allData->eventId)}}" target="_blank"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;border-radius: 6px 6px 0px 0px;"></a>
                                                <span class="{{$freeEventClass}} mt-2">FREE</span>

                                                <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $allData->eventId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "e"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$allData->eventId}}" discriminator="e">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>

                                                <div class="card-body" style="padding: 10px;">
                                                    <a href="{{url('events/'. $allData->eventId)}}" target="_blank">
                                                    <div class="col-md-12 row pr-0" style="padding: unset;margin: unset;">
                                                        <div class="col-md-2 pr-0 pl-1 mobRowDisplay">
                                                            <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                                                        </div>
                                                        <div class="col-md-10 pl-2 pr-0 mobRowDisplay1">
                                                            <h6> {{$allData->eventTitle}} </h6>
                                                        </div>
                                                    </div> </a>

                                                    <?php
                                                    for ($x = 0; $x < 1; $x++) {  ?>
                                                    <a class="text-center chevronClass" data-toggle="collapse" aria-expanded="false" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down" style="color: #9C9C9C;"></i>
                                                    <i class="fa fa-chevron-up" style="color: #9C9C9C;"></i></a>
                                                    <div id="heading<?php echo $row_count ?>" class="mt-2 ml-2 mr-2 collapse" style="color: black;">
                                                        {{$allData->eventDesc}}
                                                    </div>
                                                    <?php $row_count++; } ?>

                                                    <?php if($allData->eventOnline == 1){ ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;">Online Event </div>
                                              <?php  } else { ?>
                                                    <div class="col-md-12 pr-0 mt-2 ml-2 mr-2 pl-0" style="color:#9C9C9C;"> <i aria-hidden="true" class="fa fa-location-arrow pr-1"></i> {{$allData->eventCity}},  {{$allData->eventState}}</div>
                                                <?php } ?>

                                                    <hr class="mt-2 mb-2">

                                                    <a href="{{url('organizer/'. $allData->userId)}}" target="_blank">
                                                    <div class="row">
                                                        <div class="pl-3">
                                                            <?php
                                                            $profileLogo = "";
                                                            if(!is_null($allData->userProfilePic) && $allData->userProfilePic != ""){
                                                               $profileLogo = env("AWS_URL"). $allData->userProfilePic; ?>
                                                               <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } else{ ?>
                                                               <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                               <?php } ?>
                                                           </div>
                                                           <div class="">
                                                            <h6 class="mt-2 ml-2"> {{$allData->userName}} </h6>
                                                        </div>
                                                    </div>

                                                </a>

                                                </div>
                                            </div>
                                        </div> 
                                        <?php } } ?>


                                        <div class="col-md-12 mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                    <a href="{{url('allContent/2/0/0/page=1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                </div>





                                 <?php   } else{ ?>
                                                <div class="col-md-12 noEventMsg">
                                            <p class="text-center"> No Records Found! </p>
                                        </div>
                                                    <?php } ?>

                                    </div>
                                </div>


                            </div>

                            <div class="row tab-pane <?php if($tabId == 3){ echo $activeClass;} ?>" id= "videoTab">
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
                                        if(count($allDataResult) > 0){
                                        foreach ($allDataResult as $allData) {
                                        if($allData->videoId != NULL && $allData->podcastId == NULL){ ?>
                                        <div class="col-md-3 showHideListDiv parent pl-2 pr-2">

                                            <div class="card">
                                                
                                                <?php
                                                $AwsUrl = env('AWS_URL');
                                                $videoUrl = "";
                                                if (!empty($allData->videoUrl)) {
                                                    if($allData->videoUrlType == 1){
                                                        $videoUrl = $AwsUrl . $allData->videoUrl; ?>
                                                        <!-- <a href="{{$videoUrl}}" target="_blank"> -->
                                                            <a href="{{url('videos/'. $allData->videoId)}}" target="_blank">
                                                            <video class="" src="{{$videoUrl}}" width="100%" height="100%" controls="controls" style="border-radius: 6px 6px 0px 0px;"></video></a>
                                                        <?php   }
                                                        else{
                                                            $videoUrl = $allData->videoUrl; 
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
                                                                <a href="{{url('videos/'. $allData->videoId)}}" target="_blank">
                                                                <iframe width="240px" height="130px" src="{{$url}}" frameborder="0" class="" style="border-radius: 6px 6px 0px 0px;pointer-events: none;"></iframe></a>
                                                            <?php  }
                                                        }
                                                        ?>
                                                        
                                                        
                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $allData->videoId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "v"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$allData->videoId}}" discriminator="v">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>


                                                        <div class="card-body" style="padding: 10px;">
                                                            <a href="{{url('videos/'. $allData->videoId)}}" target="_blank">
                                                            <div class="col-md-12 pr-0 pl-0">
                                                                <h6> {{$allData->videoTitle}} </h6>
                                                            </div>

                                                            <?php $eventDesc = "";
                                                            $eventLink = "";
                                                            $desc = "";
                                                            $eventDescText = "";
                                                            if($allData->videoDesc == ''){
                                                
                                                                $eventDesc = $allData->eventVideoDesc;
                                                                $eventDescText = substr($eventDesc,0,80).'...';
                                                            }
                                                            else{
                                                                $eventDesc = $allData->videoDesc;
                                                                $eventDescText = substr($eventDesc,0,80).'...';
                                                            } 
                                                            ?>
                                                            
                                                            <div class="col-md-12 pr-0 pl-0" style="color: black;">{{$eventDescText}}</div>

                                <div class="col-md-12 pr-0 mt-2 mr-2 pl-0" style="color:#9C9C9C;">Video </div> </a>

                                                            <hr class="mt-2 mb-2">

                                                            <a href="{{url('organizer/'. $allData->userId)}}" target="_blank">
                                                            <div class="row">
                                                                <div class="pl-3">
                                                                    <?php
                                                                    $profileLogo = "";
                                                                    if(!is_null($allData->userProfilePic) && $allData->userProfilePic){
                                                                       $profileLogo = env("AWS_URL"). $allData->userProfilePic; ?>
                                                                       <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } else{ ?>
                                                                       <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                       <?php } ?>
                                                                   </div>
                                                                   <div class="">
                                                                    <h6 class="mt-3 ml-2"> {{$allData->userName}} </h6>
                                                                </div>
                                                            </div>

                                                        </a>

                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } } ?>


                                                <div class="col-md-12 mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                    <a href="{{url('allContent/3/0/0/page=1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                </div>







                                       <?php     } else{ ?>
                                                    
                                                <div class="col-md-12 noEventMsg">
                                            <p class="text-center"> No Records Found! </p>
                                        </div>
                                                    <?php } ?>

                                            </div>
                                        </div>


                                    </div>


                                    <div class="row tab-pane <?php if($tabId == 4){ echo $activeClass;} ?>" id= "audioTab">
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
                                                if(count($allDataResult) > 0){
                                                foreach ($allDataResult as $allData) {
                                        if($allData->videoId == NULL && $allData->podcastId != NULL) {
                                                 ?>
                                                <div class="col-md-3 parent showHideListDiv pl-2 pr-2">

                                                    <?php 
                                                    $podcastImg = "";
                                                    if($tabId == NULL){
                                            $podcastImg = "assets/images-new/sample-image.png";
                                        } else {
                                            $podcastImg = "../../assets/images-new/sample-image.png";
                                        }
                                                    ?>
                                                    
                                                    <div class="card">
                                                        <a href="{{url('podcasts/'. $allData->podcastId)}}" target="_blank"><img src="{{$podcastImg}}" class="" alt="" style="width: 100%;height: 130px;"></a>

                                                        <?php 
                                                    $checkHeartFill = "d-none";
                                                    $checkHeartEmpty = "";
                                                    $checkVal = "";
                                                    if(Auth::check()){
                                                        foreach($eventFollowersList as $eventFollowerList){
                                                            if(Auth::user()->id == $eventFollowerList->user_id && $allData->podcastId == $eventFollowerList->content_id && $eventFollowerList->discriminator == "p"){
                                                                $checkHeartFill = "";
                                                                $checkHeartEmpty = "d-none";
                                                                $checkVal = "1";
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <a style="cursor: pointer;" onclick="followEvent(this);" data-event-id="{{$allData->podcastId}}" discriminator="p">
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o emptyHeart {{$checkHeartEmpty}}" id="" style=""></i>
                                                    <i aria-hidden="true" class="fa fa-heart {{$checkHeartFill}} fillHeart" style="color: #FD6568;" value="{{$checkVal}}"></i>
                                                </span></a>



                                                        <div class="card-body" style="padding: 10px;">
                                                            <div class="col-md-12 row pr-0">
                                                                <a href="{{url('podcasts/'. $allData->podcastId)}}" target="_blank"><h6> {{$allData->podcastTitle}} </h6></a>
                                                            </div>

                                                            <?php
                                                            $videoPodcastUrl = "";
                                                            $dnoneClass = "";
                                                            if (!empty($allData->videoUrl)) {
                                                                $dnoneClass = "d-none";
                                                                if(substr($allData->videoUrl, 0, 8 ) != "https://"){
                                                                    $videoPodcastUrl = $AwsUrl . $allData->videoUrl;
                                                                }
                                                                else{
                                                                    $videoPodcastUrl = $allData->videoUrl;
                                                                }
                                                            }
                                                            ?>
                                                            <a href="{{$videoPodcastUrl}}" target="_blank"><audio controls  class="w-100"><source src="{{$videoPodcastUrl}}" type="audio/ogg" class="col-lg-7 pr-0 pl-0"></audio></a>

                                                                <div class="col-md-12 pr-0 mt-2 mr-2 pl-0" style="color:#9C9C9C;">Podcast </div>

                                                                <hr class="mt-2 mb-2">

                                                                <a href="{{url('organizer/'. $allData->userId)}}" target="_blank">
                                                                <div class="row">
                                                                    <div class="pl-3">
                                                                        <?php
                                                                        $profileLogo = "";
                                                                        if(!is_null($allData->userProfilePic) && $allData->userProfilePic != ""){
                                                                           $profileLogo = env("AWS_URL"). $allData->userProfilePic; ?>
                                                                           <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } else{ ?>
                                                                           <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="width:40px !important;height:40px !important;">
                                                                           <?php } ?>
                                                                       </div>
                                                                       <div class="">
                                                                        <h6 class="mt-2 ml-2"> {{$allData->userName}} </h6>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <?php } } ?>


                                                    <div class="col-md-12 mobileSeeMoreBtn" style="justify-content: center;display: flex;">
                                    <a href="{{url('allContent/4/0/0/page=1')}}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="See more" style="background: #FED8C6;color:black;box-shadow: 0px 2px 7px rgba(81, 33, 34, 0.2), 0px 2px 10px rgba(81, 33, 34, 0.25);"></a>
                                </div>




                                            <?php    } else{?>
                                                <div class="col-md-12 noEventMsg">
                                            <p class="text-center"> No Records Found! </p>
                                        </div>
                                                    <?php } ?>
                                                </div>
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
                                                    <?php
                                                    $communityImg = "";
                                                        if($tabId == NULL){
                                            $communityImg = "assets/images-new/Community 1.jpg";
                                        } else {
                                            $communityImg = "../../assets/images-new/Community 1.jpg";
                                        }
                                                     ?>
                                                    <img src="{{$communityImg}}" class="w-100">
                                                </div>
                                            </div>
                                            <!-- <img src="assets/images-new/join-community.png" class="w-100"> -->
                                        </div>

                                    </div>
@endsection

@section('script')
<script src="{{asset('/js/custom.js?v='.$v)}}" type="text/javascript"></script>
@endsection