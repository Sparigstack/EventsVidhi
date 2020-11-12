@extends('layouts.appFront')
@section('content')
    <?php $AwsUrl = env('AWS_URL'); ?>
                <div class="container mainHomePageContainer" style="">
                    <div class="col-md-12 col-lg-12">
                        <img src="assets/images-new/banner-image-1.png" class="w-100 bannerImage">
                        <div class="col-md-6 bannerImageOverlay">
                            <div class="bannerText">
                                <h4 class="fontSizeCss"> Hub for all great learning.<br>Start your journey with us!</h4>
                                <a href="{{ route('register') }}">
                                    <input type="button" id="" class="clickable createEventButton buttonMobileSize mt-3" value="Create your event"></a>
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
                              <!-- Indicators -->
                              <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <?php $count = 0;
                                 foreach ($eventsFeature as $eventFeature) { 
                                    $sdStamp = strtotime($eventFeature->date_time);
                                    $dateStr = date("d",  $sdStamp);
                                    $MonthStr = date("M",  $sdStamp);
                                ?>
                                <div class="carousel-item <?php if($count==0){ echo "active"; } else{ echo " ";}?>">
                                    <img class="d-block w-100" src="assets/images-new/banner-image-2.png" data-color="lightblue" alt="First Image" style="height: 365px;">
                                    <div class="col-md-6 bannerImageOverlay banner2">
                                <div class="bannerText2">
                                    <div class="col-md-12 row">
                                        <div class="col-md-3">
                                            <h4> {{$dateStr}} <br> {{$MonthStr}} </h4>
                                        </div>

                                        <div class="col-md-9">
                                            <h4 class="text-left"> {{$eventFeature->title}} </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <p class="mt-4 ml-5" style="color: black;font-weight: 500;">{{$eventFeature->description}}</p>
                                </div>
                            </div>
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
                            <div class="card w-100">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mainTab">
                                        <li class="nav-item ml-4">
                                            <a class="nav-link active" data-toggle="tab" href="#contentTab"><span class="hidden-xs">All Content</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#eventsTab"><span class="hidden-xs">Events</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#videoTab"><span class="hidden-xs">Video</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#audioTab"><span class="hidden-xs">Audio</span></a>
                                        </li>
                                    </ul>

                                    <ul class="nav">
                                        <li class="nav-item ml-4">
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
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="row tab-pane active" id="contentTab">
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="col-md-12 row">
                                        <div class="col-md-4">
                                            <h4> All Content </h4>
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="row col-md-12 pl-0 pr-0">
                                        <?php $row_count = 1;
                                        foreach ($events as $event) { ?>
                                        <?php
                                        $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                        if (!empty($event->thumbnail)) {
                                            $logoUrl = $AwsUrl . $event->thumbnail;
                                        }
                                        ?>
                                        <div class="col-md-3">
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
                                                <a href="#"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;"></a>
                                                <span class="{{$freeEventClass}} mt-2">FREE</span>
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o"></i></span>
                                                <div class="card-body">
                                                    <div class="col-md-12 row pr-0">
                                                        <div class="pr-0 pl-1">
                                                            <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                                                        </div>
                                                        <div class="pl-4">
                                                            <h6> {{$event->title}} </h6>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    for ($x = 0; $x < 1; $x++) {  ?>
                                                    <a class="text-center" data-toggle="collapse" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down"></i></a>
                                                    <div id="heading<?php echo $row_count ?>" class="collapse" style="color: black;">
                                                        {{$event->description}}
                                                    </div>
                                                    <?php $row_count++; } ?>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="pl-2">
                                                            <?php
                                                            $profileLogo = "";
                                                            if(!is_null($event->user->profile_pic) && $event->user->profile_pic != ""){
                                                               $profileLogo = env("AWS_URL"). $event->user->profile_pic; ?>
                                                               <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                                                               <?php } else{ ?>
                                                               <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                                                               <?php } ?>
                                                           </div>
                                                           <div class="">
                                                            <h6 class="mt-3 ml-2"> {{$event->user->name}} </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <?php } ?>

                                        <?php $row_count = 1;
                                        foreach ($videos as $video) { ?>
                                        <div class="col-md-3">
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
                                                        <a href="{{$videoUrl}}" target="_blank"><video class="" src="{{$videoUrl}}" width="100%" height="100%"></video></a>
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
                                                            <a href="{{$url}}" target="_blank"><iframe width="230px" height="130px" src="{{$url}}"></iframe></a>
                                                            <?php  }
                                                        }
                                                        ?>
                                                        <!-- <a href="#"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;"></a> -->
                                                        <!-- <span class="{{$freeEventClass}} mt-2">FREE</span> -->
                                                        <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o"></i></span>
                                                        <div class="card-body">
                                                            <div class="col-md-12 pr-0">
                                                                <h6> {{$video->title}} </h6>
                                                            </div>

                                                            <?php $eventDesc = "";
                                            // $eventPrefix = "";
                                                            $eventLink = "";
                                                            $desc = "";
                                                            if(isset($video->event)){
                                                // $eventPrefix = "Event : ";
                                                // $eventDesc = $eventPrefix.$video->event->title;
                                                                $eventDesc = $video->event->description;
                                                            }
                                                            else{
                                                                $eventDesc = $video->description;
                                                            } 
                                                            ?>
                                                            <?php
                                                            for ($x = 0; $x < 1; $x++) {  ?>
                                                            <a class="text-center" data-toggle="collapse" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down"></i></a>
                                                            <div id="heading<?php echo $row_count ?>" class="collapse" style="color: black;">
                                                                {{$eventDesc}}
                                                            </div>
                                                            <?php $row_count++; } ?>

                                                            <hr>
                                                            <div class="row">
                                                                <div class="pl-2">
                                                                    <?php
                                                                    $profileLogo = "";
                                                                    if(!is_null($video->user->profile_pic) && $video->user->profile_pic != ""){
                                                                       $profileLogo = env("AWS_URL"). $video->user->profile_pic; ?>
                                                                       <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                                                                       <?php } else{ ?>
                                                                       <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                                                                       <?php } ?>
                                                                   </div>
                                                                   <div class="">
                                                                    <h6 class="mt-3 ml-2"> {{$video->user->name}} </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>

                                                 <?php $row_count = 1;
                                                foreach ($podcasts as $podcast) { ?>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <a href="#"><img src="assets/images-new/sample-image.png" class="" alt="" style="width: 100%;height: 130px;"></a>

                                                        <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o"></i></span>
                                                        <div class="card-body">
                                                            <div class="col-md-12 row pr-0">
                                                                <h6> {{$podcast->title}} </h6>
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
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="pl-2">
                                                                        <?php
                                                                        $profileLogo = "";
                                                                        if(!is_null($podcast->user->profile_pic) && $podcast->user->profile_pic != ""){
                                                                           $profileLogo = env("AWS_URL"). $podcast->user->profile_pic; ?>
                                                                           <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                                                                           <?php } else{ ?>
                                                                           <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                                                                           <?php } ?>
                                                                       </div>
                                                                       <div class="">
                                                                        <h6 class="mt-3 ml-2"> {{$podcast->user->name}} </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row tab-pane" id= "eventsTab">
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="col-md-12 row">
                                        <div class="col-md-4">
                                            <h4> Events</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="row col-md-12 pl-0 pr-0">
                                        <?php $row_count = 1;
                                        foreach ($events as $event) { ?>
                                        <?php
                                        $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                        if (!empty($event->thumbnail)) {
                                            $logoUrl = $AwsUrl . $event->thumbnail;
                                        }
                                        ?>
                                        <div class="col-md-3">
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
                                                <a href="#"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;"></a>
                                                <span class="{{$freeEventClass}} mt-2">FREE</span>
                                                <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o"></i></span>
                                                <div class="card-body">
                                                    <div class="col-md-12 row pr-0">
                                                        <div class="pr-0 pl-1">
                                                            <h6 class="text-uppercase"> {{$dateStr}} <br> {{$MonthStr}} </h6>
                                                        </div>
                                                        <div class="pl-4">
                                                            <h6> {{$event->title}} </h6>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    for ($x = 0; $x < 1; $x++) {  ?>
                                                    <a class="text-center" data-toggle="collapse" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down"></i></a>
                                                    <div id="heading<?php echo $row_count ?>" class="collapse" style="color: black;">
                                                        {{$event->description}}
                                                    </div>
                                                    <?php $row_count++; } ?>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="pl-2">
                                                            <?php
                                                            $profileLogo = "";
                                                            if(!is_null($event->user->profile_pic) && $event->user->profile_pic != ""){
                                                               $profileLogo = env("AWS_URL"). $event->user->profile_pic; ?>
                                                               <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                                                               <?php } else{ ?>
                                                               <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                                                               <?php } ?>
                                                           </div>
                                                           <div class="">
                                                            <h6 class="mt-3 ml-2"> {{$event->user->name}} </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row tab-pane" id= "videoTab">
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="col-md-12 row">
                                        <div class="col-md-4">
                                            <h4>Video</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-11 featuredContent mb-4">
                                    <div class="row col-md-12 pl-0 pr-0">

                                        <?php $row_count = 1;
                                        foreach ($videos as $video) { ?>
                                        <div class="col-md-3">
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
                                                        <a href="{{$videoUrl}}" target="_blank"><video class="" src="{{$videoUrl}}" width="100%" height="100%"></video></a>
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
                                                            <a href="{{$url}}" target="_blank"><iframe width="230px" height="130px" src="{{$url}}"></iframe></a>
                                                            <?php  }
                                                        }
                                                        ?>
                                                        <!-- <a href="#"><img src="{{$logoUrl}}" class="w-100" alt="" style="height: 130px;"></a> -->
                                                        <!-- <span class="{{$freeEventClass}} mt-2">FREE</span> -->
                                                        <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o"></i></span>
                                                        <div class="card-body">
                                                            <div class="col-md-12 pr-0">
                                                                <h6> {{$video->title}} </h6>
                                                            </div>

                                                            <?php $eventDesc = "";
                                            // $eventPrefix = "";
                                                            $eventLink = "";
                                                            $desc = "";
                                                            if(isset($video->event)){
                                                // $eventPrefix = "Event : ";
                                                // $eventDesc = $eventPrefix.$video->event->title;
                                                                $eventDesc = $video->event->description;
                                                            }
                                                            else{
                                                                $eventDesc = $video->description;
                                                            } 
                                                            ?>
                                                            <?php
                                                            for ($x = 0; $x < 1; $x++) {  ?>
                                                            <a class="text-center" data-toggle="collapse" data-target="#heading<?php echo $row_count ?>" style="display: block;"><i class="fa fa-chevron-down"></i></a>
                                                            <div id="heading<?php echo $row_count ?>" class="collapse" style="color: black;">
                                                                {{$eventDesc}}
                                                            </div>
                                                            <?php $row_count++; } ?>

                                                            <hr>
                                                            <div class="row">
                                                                <div class="pl-2">
                                                                    <?php
                                                                    $profileLogo = "";
                                                                    if(!is_null($video->user->profile_pic) && $video->user->profile_pic != ""){
                                                                       $profileLogo = env("AWS_URL"). $video->user->profile_pic; ?>
                                                                       <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                                                                       <?php } else{ ?>
                                                                       <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                                                                       <?php } ?>
                                                                   </div>
                                                                   <div class="">
                                                                    <h6 class="mt-3 ml-2"> {{$video->user->name}} </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="row tab-pane" id= "audioTab">
                                        <div class="col-md-11 featuredContent mb-4">
                                            <div class="col-md-12 row">
                                                <div class="col-md-4">
                                                    <h4>Audio</h4>
                                                </div>
                                                <div class="col-md-8">
                                                    <button class="btn dropdown-toggle locationDropDown text-capitalize" type="button" data-toggle="dropdown" aria-expanded="false" style=""><i aria-hidden="true" class="fa fa-location-arrow pr-2"></i>Everywhere</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-11 featuredContent mb-4">
                                            <div class="row col-md-12 pl-0 pr-0">

                                                <?php $row_count = 1;
                                                foreach ($podcasts as $podcast) { ?>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <a href="#"><img src="assets/images-new/sample-image.png" class="" alt="" style="width: 100%;height: 130px;"></a>

                                                        <span class="likeButtonSpan"><i aria-hidden="true" class="fa fa-heart-o"></i></span>
                                                        <div class="card-body">
                                                            <div class="col-md-12 row pr-0">
                                                                <h6> {{$podcast->title}} </h6>
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
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="pl-2">
                                                                        <?php
                                                                        $profileLogo = "";
                                                                        if(!is_null($podcast->user->profile_pic) && $podcast->user->profile_pic != ""){
                                                                           $profileLogo = env("AWS_URL"). $podcast->user->profile_pic; ?>
                                                                           <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                                                                           <?php } else{ ?>
                                                                           <img class="align-self-start profileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                                                                           <?php } ?>
                                                                       </div>
                                                                       <div class="">
                                                                        <h6 class="mt-3 ml-2"> {{$podcast->user->name}} </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                    <img src="assets/images-new/Community 1.jpg" class="w-100">
                                                </div>
                                            </div>
                                            <!-- <img src="assets/images-new/join-community.png" class="w-100"> -->
                                        </div>

                                    </div>
@endsection