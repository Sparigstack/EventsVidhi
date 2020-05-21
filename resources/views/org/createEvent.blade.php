@extends('layouts.appOrg')

@section('content')
<div class="container-fluid mt-3 createEventContainer">
    <?php
    $CardTitle = "Add New Event";
    $title = "";
    $categoryID = 0;
    $desription = "";
    $address = "";
    $address2 = "";
    $PostalCode = "";
    $cityID = 0;
    $countryId = 0;
    $stateId = 0;
    $timezoneId = 0;
    $EventDate = "";
    $EventEndDate = "";
    $IsPublic = "";
    $IsOnline = "";
    $IsPaid = "";
    $IsSelected = "";
    $disabled = "";
    $readonly = "";
    $EventUrl = "";
    $HiddenEventUrl = "d-none";
    $ActionCall = url('org/events/store');
    $MultSelectTags = "";
    $checkCount = "no";
    $eventTypeID = 0;
    $ThumnailUrl = "";
    $ThumbNailHidden = "d-none";
    $BannerUrl = "";
    $BannerHidden = "d-none";
    $AwsUrl = "https://panelhiveus.s3.us-west-1.amazonaws.com/";
    $IsLive = "";
    $activeClass = "active";
    $activeShow = "show";

    if (!empty($event)) {
        $ActionCall = url('org/events/edit/' . $event->id);
        $CardTitle = "Edit Event";
        $title = $event->title;
        $desription = $event->description;
        $address = $event->address;
        $EventDate = $event->date_time;
        $EventEndDate = $event->end_date_time;
        $categoryID = $event->category_id;
        $cityID = $event->city_id;
        // $countryId = $event->country_id;
        // $stateId = $event->state_id;
        $timezoneId = $event->timezone_id;
        if (!empty($event->address_line2)) {
            $address2 = $event->address_line2;
        }
        if (!empty($event->postal_code)) {
            $PostalCode = $event->postal_code;
        }
        if ($event->is_public) {
            $IsPublic = "checked";
        }
        if ($event->is_online) {
            $IsOnline = "checked";
            $disabled = "disabled='true'";
            $readonly = "readonly='true'";
            $HiddenEventUrl = "";
            $EventUrl = $event->online_event_url;;
        }
        if ($event->is_paid) {
            $IsPaid = "checked";
        }
        if (!empty($event->event_type_id)) {
            $eventTypeID = $event->event_type_id;
        }
        if (!empty($event->thumbnail)) {
            $ThumnailUrl = $AwsUrl . $event->thumbnail;
            $ThumbNailHidden = "";
        }
        if (!empty($event->banner)) {
            $BannerUrl = $AwsUrl . $event->banner;
            $BannerHidden = "";
        }
        if ($event->is_live == 1) {
            $IsLive = "checked";
        }
    }

    ?>
    <h5 class="mb-3">{{$CardTitle}}</h5>
    <div class="row">
        <div class="card w-100">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-info nav-justified">
                    <li class="nav-item">
                        <a class="nav-link 
                        <?php if ($tabe == 0) {
                            echo "active";
                        } ?>
                        " data-toggle="tab" href="#tabe-13"><span class="hidden-xs">Details</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link
                        <?php if ($tabe == 1) {
                            echo "active";
                        } ?>
                        " data-toggle="tab" href="#tabe-14"><span class="hidden-xs">Media</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabe-15"><span class="hidden-xs">Participants</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabe-16"><span class="hidden-xs">Promote</span></a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="row tab-pane 
                    <?php
                    if ($tabe == 0) {
                        echo "active";
                    } ?>
                    " id="tabe-13">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <!-- <h5>{{$CardTitle}}</h5> -->
                                    </div>
                                    <!-- <hr> -->
                                    @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <form class="row" ID="EventSaveForm" name="EventSaveForm" onsubmit="return ValidateEventForm(this)" method="post" action="{{$ActionCall}}" enctype="multipart/form-data">
                                        <!-- <input type="text" value="{{$ActionCall}}"> -->
                                        {{ csrf_field() }}
                                        <div class="basicDetails col-lg-12">
                                            <h5> Basic Details </h5>
                                        </div>

                                        <div class="col-lg-12 row mt-2">
                                            <div class="form-group col-lg-12">
                                                <label for="EventBannerImage">Banner Image (optional)</label>
                                                <p style="font-size: .7pc;">Preferred image size is 845 &#10005; 445 px and maximum 4MB allowed.</p>
                                                <!-- <input type="file" accept="image/*" id="EventBannerImage" name="EventBannerImage" class="form-control files" onchange="document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('bannerImage').classList.remove('d-none');"> -->
                                                <div class="dragFileContainer">
                                                    <input type="file" accept="image/*" id="EventBannerImage" name="EventBannerImage" class="form-control files">
                                                    <img id="bannerImage" src="{{$BannerUrl}}" class="{{$BannerHidden}} imageRadius w-100" alt="your image" width="100" />
                                                    <?php
                                                    if (empty($BannerUrl)) { ?>
                                                        <p id="TempText">Drop your image here or click to upload.</p>
                                                    <?php } ?>

                                                </div>
                                                <small class="text-danger">{{ $errors->first('EventBannerImage') }}</small>
                                                <div class="text-danger d-none SizeError" id='SizeErrorBannerImage'>Image size must be less than or eqaul to 4MB</div>



                                            </div>

                                        </div>

                                        <div class="form-group col-lg-12 row">
                                            <div class="form-group col-lg-6">
                                                <label for="EventThumbnailImage">Thumbnail Image (optional)</label>
                                                <p style="font-size: .7pc;">Preferred image size is 420 &#10005; 360 px and maximum 4MB allowed.</p>
                                                <!-- <input type="file" accept="image/*" id="EventThumbnailImage" name="EventThumbnailImage" class="form-control files" onchange="document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('thumbnailImage').classList.remove('d-none');"> -->

                                                <div class="dragFileContainer thumbNailContainer" style="display: flex;justify-content: center;">
                                                    <input type="file" accept="image/*" id="EventThumbnailImage" name="EventThumbnailImage" class="form-control files">
                                                    <img id="thumbnailImage" src="{{$ThumnailUrl}}" class="{{$ThumbNailHidden}} imageRadius" alt="your image" width="100" />

                                                    <?php
                                                    if (empty($ThumnailUrl)) { ?>
                                                        <p id="TempTextThumb">Drop your image here or click to upload.</p>
                                                    <?php } ?>
                                                </div>

                                                <small class="text-danger">{{ $errors->first('EventThumbnailImage') }}</small>
                                                <div class="text-danger d-none SizeError" id='SizeErrorBannerImage'>Image size must be less than or eqaul to 4MB</div>

                                            </div>


                                            <div class="form-group col-lg-6">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" value="{{ old('title',$title) }}" name="title" placeholder="Enter Event Title" required>
                                                <small class="text-danger">{{ $errors->first('title') }}</small>
                                                <label for="EventSelection" class="mt-4 pt-2">Event Type</label>
                                                <select autocomplete="off" value="{{ old('eventType') }}" name="eventType" id="eventType" class=" custom-select">
                                                    <option value>Select Event Type</option>
                                                    <?php foreach ($eventTypes as $eventType) {
                                                        $IsSelected = "";
                                                        if (!empty($event)) {
                                                            if ($eventType->id == $eventTypeID) {
                                                                $IsSelected = "selected";
                                                            }
                                                        }
                                                    ?>
                                                        <option value="{{$eventType->id}}" {{$IsSelected}} @if (old('eventType')==$eventType->id) selected="selected" @endif ><?php echo $eventType->name; ?> </option>
                                                    <?php } ?>

                                                </select>

                                                <label class="mt-4 pt-2">Select Categories</label>
                                                <select class="form-control multiple-select" multiple="multiple" name="category" id="category" required>
                                                    <?php if (!empty($event)) {
                                                        $IsSelected = "";
                                                        foreach ($categories as $category) {

                                                            foreach ($event->eventCategory as $EventCategory) {

                                                                if ($category->id == $EventCategory->category_id) {
                                                                    $IsSelected = "selected";
                                                                    if ($checkCount == "no") {
                                                                        $MultSelectTags .= strval($category->id);
                                                                    } else {
                                                                        $MultSelectTags .= "," . $category->id;
                                                                    }
                                                                    $checkCount = "yes";
                                                                } else {
                                                                    $IsSelected = "";
                                                                }

                                                    ?>
                                                                <option value="{{old('category',$category->id)}}" {{$IsSelected}} @if (old('category')==$category->id) selected="selected" @endif ><?php echo $category->name; ?> </option>
                                                            <?php }
                                                        }
                                                    } else {
                                                        foreach ($categories as $category) {
                                                            ?>
                                                            <option value="{{old('category',$category->id)}}" {{$IsSelected}} @if (old('category')==$category->id) selected="selected" @endif ><?php echo $category->name; ?> </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('category') }}</small>
                                                <textarea id="HiddenCategoyID" name="HiddenCategoyID" required class="form-controld d-none" title="HiddenCategoyID" placeholder="HiddenCategoyID" autocomplete="off" rows="4">{{ old('HiddenCategoyID', $MultSelectTags) }} </textarea>
                                            </div>
                                        </div>




                                        <div class="form-group col-lg-12">
                                            <label for="Description">Description</label>
                                            <textarea id="Description" name="Description" required class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4">{{ old('Description', $desription) }}</textarea>
                                            <small class="text-danger">{{ $errors->first('Description') }}</small>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="locationDetails col-lg-12 mt-3 pt-2">
                                                        <h5> Location Details </h5>
                                                    </div>

                                                    <div class="form-group col-12 mt-4">
                                                        <div class="icheck-material-primary">
                                                            <input type="checkbox" id="IsOnline" name="IsOnline" {{$IsOnline}} @if(old('IsOnline')) checked @endif onclick="IsOnlineEvent(this);">
                                                            <label for="IsOnline">Is this event online?</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-12">

                                                        <input type="text" id="EventUrl" value="{{  old('EventUrl', $EventUrl) }}" name="EventUrl" class="form-control {{$HiddenEventUrl}}" title="Event Url" placeholder="Online Event Url" autocomplete="off" rows="0" value="">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <input type="hidden" class="getState" value="{{url('getState')}}">
                                                        <label for="selectionCategory">Country</label>
                                                        <select autocomplete="off" value="{{ old('country') }}" name="country" id="country" class=" custom-select" {{$disabled}} onchange="getState(this);">
                                                            <option value="0">Select Country</option>
                                                            <?php foreach ($countries as $country) {
                                                                $IsSelected = "";
                                                                if ($country->id == $countryId) {
                                                                    $IsSelected = "selected";
                                                                }
                                                            ?>
                                                                <option value="{{$country->id}}" {{$IsSelected}} @if (old('country')==$country->id) selected="selected" @endif ><?php echo $country->name; ?> </option>
                                                            <?php } ?>

                                                        </select>
                                                        <img src="{{ asset('assets/images/busy.gif') }}" class="loader-icon float-right d-none" alt="logo icon">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <input type="hidden" class="getCity" value="{{url('getCity')}}">
                                                        <label for="selectionCategory">State</label>
                                                        <select autocomplete="off" value="{{ old('state') }}" disabled name="state" id="state" class=" custom-select" {{$disabled}} onchange="getCity(this);">
                                                            <option value>Select State</option>


                                                        </select>
                                                        <img src="{{ asset('assets/images/busy.gif') }}" class="loader-icon float-right d-none" alt="logo icon">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="selectionCategory">City</label>
                                                        <select autocomplete="off" value="{{ old('city') }}" name="city" id="city" disabled class="custom-select" {{$disabled}} onchange="ShowAddressFields(this);">
                                                            <option>Select City</option>
                                                            <?php if (!empty($event)) {
                                                                foreach ($cities as $city) {
                                                                    $IsSelected = "";
                                                                    if ($city->id == $cityID) {
                                                                        $IsSelected = "selected";
                                                                    }
                                                            ?>
                                                                    <option value="{{$city->id}}" {{$IsSelected}} @if (old('city')==$city->id) selected="selected" @endif ><?php echo $city->name; ?> </option>
                                                            <?php }
                                                            } ?>

                                                        </select>
                                                    </div>


                                                    <div class="form-group col-lg-12">
                                                        <label for="Address1">Address Line 1</label>
                                                        <input type="text" id="Address1" disabled name="Address1" {{$readonly}} class="form-control" title="Address Line 1" placeholder="Address Line 1" autocomplete="off" rows="0" value="{{  old('Address1', $address) }}">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="Address2">Address Line 2</label>
                                                        <input type="text" id="Address2" disabled name="Address2" {{$readonly}} class="form-control" title="Address Line 2" placeholder="Address Line 2" autocomplete="off" rows="0" value="{{  old('Address2', $address2) }}">
                                                    </div>


                                                    <div class="form-group col-lg-12">
                                                        <label for="PostalCode">Postal code</label>
                                                        <input type="text" id="PostalCode" disabled name="PostalCode" {{$readonly}} class="form-control" title="Postal Code" placeholder="Postal Code" autocomplete="off" rows="0" value="{{  old('PostalCode', $PostalCode) }}">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="eventSchedule col-lg-12 mt-3">
                                                        <h5> Event Schedule </h5>
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="EventDateTime">Event Start Date & Time</label>
                                                        <div class='input-group' id=''>
                                                            <input type='text' value="{{  old('EventDateTime', $EventDate) }}" placeholder="05/16/2020 10:28 AM" class="form-control date" autocomplete="off" name="EventDateTime" id="EventDateTime" required />

                                                        </div>
                                                        <small class="text-danger">{{ $errors->first('EventDateTime') }}</small>
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="EventDateTime">Event End Date & Time</label>
                                                        <div class='input-group' id=''>
                                                            <input type='text' value="{{  old('EventEndDateTime', $EventEndDate) }}" placeholder="05/16/2020 11:28 AM" class="form-control date" autocomplete="off" name="EventEndDateTime" id="EventEndDateTime" required />

                                                        </div>
                                                        <small class="text-danger">{{ $errors->first('EventEndDateTime') }}</small>
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="cityTimezone mb-0">Timezone</label>
                                                        <select autocomplete="off" value="{{ old('cityTimezone') }}" name="cityTimezone" id="cityTimezone" class=" custom-select">
                                                            <option value="0">Select Timezone</option>
                                                            <?php
                                                            foreach ($cityTimeZones as $timeZones) {
                                                                $IsSelected = "";
                                                                if ($timeZones->id == $timezoneId) {
                                                                    $IsSelected = "selected";
                                                                }
                                                            ?>
                                                                <option value="{{$timeZones->id}}" {{$IsSelected}} @if (old('cityTimezone')==$timeZones->id) selected="selected" @endif ><?php echo $timeZones->name; ?> </option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-lg-12 pl-0">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="col-lg-12 mt-3">
                                                            <h5>Publish Event Info </h5>
                                                        </div>
                                                        <div class="form-group col-lg-12">
                                                            <label for="BlankLabel"></label>
                                                            <div class="icheck-material-primary">
                                                                <input type="checkbox" id="IsPublish" {{$IsLive}} name="IsPublish" @if(old('IsPublish')) checked @endif>
                                                                <label for="IsPublish"> Do you want to publish this event?</label>
                                                            </div>
                                                        </div><br>

                                                        <div class="form-group col-lg-12">
                                                            <label for="BlankLabel">Is this event public?</label><br>
                                                            <div class="icheck-material-primary icheck-inline">
                                                                <input type="radio" id="inline-radio-primary" value="true" name="IsPublic" <?php if (!empty($event)) {
                                                                                                                                                if ($event->is_public == 1) {
                                                                                                                                                    echo "checked";
                                                                                                                                                }
                                                                                                                                            } else {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>
                                                                <label for="inline-radio-primary">Public</label>
                                                            </div>
                                                            <div class="icheck-material-primary icheck-inline">
                                                                <input type="radio" id="inline-radio-info" value="false" name="IsPublic" <?php if (!empty($event)) {
                                                                                                                                                if ($event->is_public == 0) {
                                                                                                                                                    echo "checked";
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                                <label for="inline-radio-info">Registrants</label>
                                                            </div>
                                                        </div><br>

                                                        <div class="form-group col-lg-12">
                                                            <label for="BlankLabel">Is this event free or paid?</label><br>
                                                            <div class="icheck-material-primary icheck-inline">
                                                                <input type="radio" id="ItIsFree" value="true" name="IsFree" <?php if (!empty($event)) {
                                                                                                                                    if ($event->is_paid == 0) {
                                                                                                                                        echo "checked";
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                    echo "checked";
                                                                                                                                } ?>>
                                                                <label for="ItIsFree">Free</label>
                                                            </div>
                                                            <div class="icheck-material-primary icheck-inline">
                                                                <input type="radio" id="ItIsPaid" value="false" name="IsFree" <?php if (!empty($event)) {
                                                                                                                                    if ($event->is_paid == 1) {
                                                                                                                                        echo "checked";
                                                                                                                                    }
                                                                                                                                } ?>>
                                                                <label for="ItIsPaid">Paid</label>
                                                            </div>
                                                        </div><br>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group col-lg-12">
                                            <button type="submit" id="Submit" class="btn btn-primary px-5 pull-right"> Save Event</button>
                                        </div>
                                </div>
                            </div>
                        </div>

                        </form>

                    </div>
                    <div class="parent videos row tab-pane
                    <?php if ($tabe == 1) {
                        echo "active";
                    } ?>
                    " id="tabe-14">
                        <?php if ($IsNew == false) { ?>
                            {{ csrf_field() }}
                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input type="hidden" class="addEventVideos" value="{{url('org/events/videos/store')}}">
                            <input type="hidden" class="addPodCastVideos" value="{{url('org/events/podcast/store')}}">
                            <input type="hidden" class="RemoveEventVideos" value="{{url('org/events/deleteVideo')}}">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body row">
                                       
                                        <div id="UploadedVideos" class="col-lg-8 m-auto p-0">
                                        <?php
                                            foreach($videos as $video){?>
                                                    
                                                    <ul class="list-group parent list-group-flush mb-2">
                                                        <li class="list-group-item"><div class="media align-items-center">
                                                            <div class="media-body ml-3"><h6 class="mb-0"><?php echo $video->title ?></h6>
                                                            <small class="small-font">
                                                              <?php  $AwsUrl = env('AWS_URL');
                                                                    $videoUrl = "";
                                                                if (!empty($video->url)) {
                                                                    if(substr( $video->url, 0, 8 ) != "https://"){
                                                                    $videoUrl = $AwsUrl . $video->url;
                                                                }
                                                            else{
                                                                $videoUrl = $video->url;
                                                            } 
                                                        }?>
                                                            {{$videoUrl}}</small></div>
                                                            <div data-id="<?php echo $video->id?>" onclick="RemoveSingleVideo(this);" Type="video" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                        </div></li></ul>
                                            <?php } ?>
                                            <?php
                                            foreach($podcasts as $podcast){?>
                                                    
                                                    <ul class="list-group parent list-group-flush mb-2">
                                                        <li class="list-group-item"><div class="media align-items-center">
                                                            <div class="media-body ml-3"><h6 class="mb-0"><?php echo $podcast->title ?></h6>
                                                            <small class="small-font">
                                                                <?php  $AwsUrl = env('AWS_URL');
                                                                    $podcastvideoUrl = "";
                                                                if (!empty($podcast->url)) {
                                                                    if(substr( $podcast->url, 0, 8 ) != "https://"){
                                                                    $podcastvideoUrl = $AwsUrl . $podcast->url;
                                                                }
                                                            else{
                                                                $podcastvideoUrl = $podcast->url;
                                                            } 
                                                        }?>
                                                                {{$podcastvideoUrl}}</small></div>
                                                            <div data-id="<?php echo $podcast->id?>" onclick="RemoveSingleVideo(this);" Type="podcast" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                        </div></li></ul>
                                            <?php } ?>

                                        </div>
                                        <div class="card p-4 col-lg-8 UploadVideoContainer parent d-none m-auto">
                                            <form class="" ID="SaveVideoAjax" name="SaveVideoAjax" method="post" enctype="multipart/form-data">
                                                <!-- <input type="text" value="{{$ActionCall}}"> -->
                                                {{ csrf_field() }}
                                                <input type="text" name="EventToLink" id="EventToLink" class="d-none" value="{{$event->id}}" />
                                                <button class="btn btn-primary d-none RemoveVideo" style="position: absolute;right: -132px;top:29px;">Remove Video</button>
                                                <div class='form-group  videoTitle'>
                                                    <label for='input_title'>Video Title</label>
                                                    <input type="text" class="form-control" id="input_title" name='input_title' value="{{  old('input_title') }}" placeholder="Enter Video Title" required>
                                                </div>
                                                <div class='form-group videoUrl'>
                                                    <label for='input_url'>Video URL</label><span style="font-size: 11px;font-weight: 600;">&nbsp;&nbsp;(YouTube or Vimeo url)</span>
                                                    <input type="text" class="form-control" id="input_url" name="input_url" value="{{  old('input_url') }}" placeholder="Enter Video URL" required>
                                                </div>
                                                <div class="form-group videoUploadBox">
                                                    <label for="BlankLabel"></label>
                                                    <div class="icheck-material-primary">
                                                        <input onclick="UploadVideoBox(this)" type="checkbox" id="IsUploadVideo" name="IsUploadVideo" @if(old('IsUploadVideo')) checked @endif>
                                                        <label for="IsUploadVideo">Or upload video</label>
                                                    </div>
                                                </div>

                                                <div class='parent' style='width: 100%;'>
                                                    <div class='form-group  d-none uploadVideoBox'>
                                                        <div class='dragFileContainer'>
                                                            <input id='video_file' name='video_file' type="file" multiple>
                                                            <p>Drag your video file here or click in this area.</p>
                                                        </div>
                                                    </div>
                                                    <small class="text-danger VideoInvalid"></small>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button type="submit" id="videoSubmitButton" data-id="{{$event->id}}" class="btn btn-primary px-5 pull-right"> Save Video</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card p-4 col-lg-8 UploadPodCastContainer parent d-none m-auto">
                                            <form class="" ID="SavePodCastAjax" name="SavePodCastAjax" method="post" enctype="multipart/form-data">
                                                <!-- <input type="text" value="{{$ActionCall}}"> -->
                                                {{ csrf_field() }}
                                                <input type="text" name="EventToLink" id="EventToLink" class="d-none" value="{{$event->id}}" />
                                                <button class="btn btn-primary d-none RemoveVideo" style="position: absolute;right: -132px;top:29px;">Remove Video</button>
                                                <div class='form-group  videoTitle'>
                                                    <label for='input_title'>Podcast Title</label>
                                                    <input type="text" class="form-control" id="input_title" name='input_title' value="{{  old('input_title') }}" placeholder="Enter Video Title" required>
                                                </div>
                                                <div class='form-group videoUrl'>
                                                    <label for='input_url'>Podcast URL</label><span style="font-size: 11px;font-weight: 600;">&nbsp;&nbsp;(YouTube or Vimeo url)</span>
                                                    <input type="text" class="form-control" id="input_url" name="input_url" value="{{  old('input_url') }}" placeholder="Enter Video URL" required>
                                                </div>
                                                <div class="form-group videoUploadBox">
                                                    <label for="BlankLabel"></label>
                                                    <div class="icheck-material-primary">
                                                        <input onclick="UploadVideoBox(this)" type="checkbox" class="PodCastUpload" id="IsUploadPodCast" name="IsUploadPodCast" @if(old('IsUploadVideo')) checked @endif>
                                                        <label for="IsUploadPodCast">Or upload podcast</label>
                                                    </div>
                                                </div>

                                                <div class='parent' style='width: 100%;'>
                                                    
                                                    <div class='form-group  d-none uploadPodcastVideo'>
                                                        <div class='dragFileContainer'>
                                                            <input id='podcast_video_file' name='podcast_video_file' type="file" multiple>
                                                            <p>Drag your podcast file here or click in this area.</p>
                                                        </div>
                                                        <small class="text-danger PodcastInvalid"></small>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button type="submit" id="videoSubmitButton" data-id="{{$event->id}}" class="btn btn-primary px-5 pull-right"> Save Podcast</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row w-100 mt-2 mb-4">
                                        <div class="text-center col-lg-12">
                                            <button type="button" id="videoButton" class="btn btn-outline-primary btn-round waves-effect waves-light m-1" onclick="uploadVideo(this);">Add Video</button>
                                            <button type="button" id="podcastVideoButton" class="btn btn-outline-primary btn-round waves-effect waves-light m-1" onclick="uploadVideo(this);">Add Podcast</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                <?php } else { ?>
                    <div class="text-center m-4"><label class="">Please save basic details to add media</label></div>
                <?php } ?>

                </div>
            </div>



        </div>






    </div>
</div>
</div>
</div>
</div>
@endsection

@section('script')
<script src="{{asset('/js/Events.js')}}" type="text/javascript"></script>
<!-- <script>
    $(document).ready(function() {
        $('#EventBannerImage').change(function() {
            $('#TempText').remove();
            document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);
            document.getElementById('bannerImage').classList.remove('d-none');
        });

        $('#EventThumbnailImage').change(function() {
            $('#TempTextThumb').remove();
            document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);
            document.getElementById('thumbnailImage').classList.remove('d-none');
        });

        $('#video_file').change(function() {
            $(this).parent().find('p').text(this.files.length + " file(s) selected");
        });
        $('#podcast_video_file').change(function() {
            $(this).parent().find('p').text(this.files.length + " file(s) selected");
        });


    });
</script> -->
@endsection