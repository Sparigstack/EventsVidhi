@extends('layouts.appOrg')
@section('css')
<link href="{{ asset('assets/plugins/jquery-multi-select/multi-select.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<!-- datetimepicker -->
<link href="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.css') }}" rel="stylesheet">
@endsection
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
    // $stateId = 0;
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
    $profilePicUrl = "";
    $profilePicHidden = "d-none";
    $BannerUrl = "";
    $BannerHidden = "d-none";
    $AwsUrl = "https://panelhiveus.s3.us-west-1.amazonaws.com/";
    $IsLive = "";
    $activeClass = "active";
    $activeShow = "show";
    $event_id = 0;
    $CustomHumanReadableUrl = "";
    $city = "";
    $state = "";
    $FinalUrl = "";
    $timezoneChangeId = 0;
    if (!empty($event)) {
        $event_id = $event->id;
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
        if(!empty($timezoneId)){
            $timezoneChangeId = $event->timezone->id;
        }
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
        } else {
            $countryId = $event->country_id;
            $city = $event->city;
            $state = $event->state;
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
            // $IsLive = "checked";
            $IsLive = "true";
        }
        if (!empty($event->custom_url)) {
            $CustomHumanReadableUrl = $event->custom_url;
            $FinalUrl = env('APP_URL_Custom'). $event->custom_url;
        }
    }
    $IsLocationFields = "disabled";
    if ($IsOnline != "checked") {
        $IsLocationFields = "";
    }
    if (!empty($speaker)) {
        if (!empty($speaker->profilePic)) {
            $profilePicUrl = $AwsUrl . $speaker->profilePic;
            $profilePicHidden = "";
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
                    <?php if (!empty($event) && $event->is_paid == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#TicketsTab"><span class="hidden-xs">Tickets</span></a>
                        </li>
                    <?php    } ?>

                    <li class="nav-item">
                        <a class="nav-link
                        <?php if ($tabe == 3) {
                            echo "active";
                        } ?>
                        " data-toggle="tab" href="#tabe-15"><span class="hidden-xs">Participants</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link
                        <?php if ($tabe == 2) {
                            echo "active";
                        } ?>
                        " data-toggle="tab" href="#tabe-16"><span class="hidden-xs">Speakers</span></a>
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
                                <div class="card-body pb-0">
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
                                        <input type="hidden" class="eventsPage" value="{{url('org/events')}}">
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
                                                <input type="hidden" name="eventBannerPic" class="eventBannerPic" value="{{$BannerUrl}}">
                                                <div class="dragFileContainer" id="dragfile" style="text-align:center;">
                                                    <input type="file" accept="image/*" id="EventBannerImage" name="EventBannerImage" class="form-control files">
                                                    <!-- <img id="bannerImage" src="{{$BannerUrl}}" class="{{$BannerHidden}} imageRadius w-100" alt="your image" width="100" /> -->
                                                    <img id="bannerImage" src="{{$BannerUrl}}" class="{{$BannerHidden}} bannerRadius w-100" alt="your image" width="100" />
                                                    <?php
                                                    if (empty($BannerUrl)) { ?>
                                                        <p id="TempText">Drop your image here or click to upload.</p>
                                                    <?php } ?>
                                                       
                                                </div>
                                                
                                                <small class="text-danger">{{ $errors->first('EventBannerImage') }}</small>
                                                <div class="text-danger d-none SizeError" id='SizeErrorBannerImage'>Image size must be less than or eqaul to 4MB</div>



                                            </div>
                                            <?php 
                                            $dNoneClass = "d-none";
                                            if(!empty($event->banner)){
                                                $dNoneClass = '';
                                            }
                                            ?>
                                                <div class="removebtn {{$dNoneClass}}"><a type="button" id="RemoveImgBtn">Remove Banner</a></div>
                                        </div>

                                        <div class="form-group col-lg-12 row">

                                            <div class="form-group col-lg-6">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" value="{{ old('title',$title) }}" name="title" placeholder="Enter Event Title" required>
                                                <small class="text-danger">{{ $errors->first('title') }}</small>
                                                <label for="EventSelection" class="mt-4 pt-2">Event Type</label>
                                                <select required autocomplete="off" value="{{ old('eventType') }}" name="eventType" id="eventType" class=" custom-select">
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
                                                    <?php $IsSelected = "";
                                                    if (!empty($event)) {
                                                        foreach ($categories as $category) {

                                                            // foreach ($event->eventCategory as $EventCategory) {
                                                            $IsSelected = "";

                                                            foreach ($event->categories as $EventCategory) {

                                                                if ($category->id == $EventCategory->id) {
                                                                    $IsSelected = "selected";
                                                                    if ($checkCount == "no") {
                                                                        $MultSelectTags .= strval($category->id);
                                                                    } else {
                                                                        $MultSelectTags .= "," . $category->id;
                                                                    }
                                                                    $checkCount = "yes";
                                                                }
                                                            }

                                                    ?>
                                                            <option value="{{old('category',$category->id)}}" {{$IsSelected}} @if (old('category')==$category->id) selected="selected" @endif ><?php echo $category->name; ?> </option>
                                                        <?php }
                                                    } else {
                                                        foreach ($categories as $category) {
                                                        ?>
                                                            <option value="{{old('category',$category->id)}}" @if (old('category')==$category->id) selected="selected" @endif ><?php echo $category->name; ?> </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('category') }}</small>
                                                <textarea id="HiddenCategoyID" name="HiddenCategoyID" required class="form-controld d-none" title="HiddenCategoyID" placeholder="HiddenCategoyID" autocomplete="off" rows="4">{{ old('HiddenCategoyID', $MultSelectTags) }} </textarea>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label for="EventThumbnailImage">Thumbnail Image (optional)</label>
                                                <p style="font-size: .7pc;">Preferred image size is 420 &#10005; 360 px and maximum 4MB allowed.</p>
                                                <!-- <input type="file" accept="image/*" id="EventThumbnailImage" name="EventThumbnailImage" class="form-control files" onchange="document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('thumbnailImage').classList.remove('d-none');"> -->
                                                <input type="hidden" name="eventThumbPic" class="eventThumbPic" value="{{$ThumnailUrl}}">

                                                <div class="dragFileContainer thumbNailContainer m-auto" style="display: flex;justify-content: center;">
                                                    <input type="file" accept="image/*" id="EventThumbnailImage" name="EventThumbnailImage" class="form-control files">
                                                    <img id="thumbnailImage" src="{{$ThumnailUrl}}" class="{{$ThumbNailHidden}} imageRadius" alt="your image" width="100" />

                                                    <?php
                                                    if (empty($ThumnailUrl)) { ?>
                                                        <p id="TempTextThumb">Drop your image here or click to upload.</p>
                                                    <?php } ?>
                                                </div>

                                                <small class="text-danger">{{ $errors->first('EventThumbnailImage') }}</small>
                                                <div class="text-danger d-none SizeError" id='SizeErrorBannerImage'>Image size must be less than or eqaul to 4MB</div>
                                                <?php 
                                            $dNoneClassThumb = "d-none";
                                            if(!empty($event->thumbnail)){
                                                $dNoneClassThumb = '';
                                            }
                                            ?>
                                                <div class="removethumbnail {{$dNoneClassThumb}}"><a type="button" id="RemoveThumbnailBtn">Remove Thumbnail</a></div>

                                            </div>

                                        </div>




                                        <div class="form-group col-lg-12">
                                            <label for="Description">Description</label>
                                            <textarea id="Description" name="Description" required class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4">{{ old('Description', $desription) }}</textarea>
                                            <small class="text-danger">{{ $errors->first('Description') }}</small>
                                        </div>
                                        <?php $isPhysicalAddressReq = "required";
                                        $isOnlineUrlReq = "";
                                        if ($event_id != 0 && $IsOnline == "checked") {
                                            $isPhysicalAddressReq = "";
                                            $isOnlineUrlReq = "required";
                                        }
                                        ?>

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
                                                        <input {{$isOnlineUrlReq}} type="url" id="EventUrl" value="{{  old('EventUrl', $EventUrl) }}" name="EventUrl" class="form-control {{$HiddenEventUrl}}" title="Event Url" placeholder="Online Event Url" autocomplete="off" rows="0" value="">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="Address1">Address Line 1</label>
                                                        <input type="text" id="Address1" {{$disabled}} name="Address1" class="form-control" title="Address Line 1" placeholder="Address Line 1" autocomplete="off" rows="0" value="{{  old('Address1', $address) }}">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="Address2">Address Line 2</label>
                                                        <input type="text" id="Address2" {{$disabled}} name="Address2" class="form-control" title="Address Line 2" placeholder="Address Line 2" autocomplete="off" rows="0" value="{{  old('Address2', $address2) }}">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="city">City</label>
                                                        <input type="text" {{$isPhysicalAddressReq}} autocomplete="off" value="{{  old('city', $city) }}" name="city" id="city" class="form-control" {{$disabled}} placeholder="Enter City" />
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <input type="hidden" class="getCity" value="{{url('getCity')}}">
                                                        <label for="state">State</label>
                                                        <input type="text" {{$isPhysicalAddressReq}} autocomplete="off" value="{{ old('state',$state) }}" name="state" id="state" class="form-control" {{$disabled}} placeholder="Enter State" />
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="PostalCode">Postal code</label>
                                                        <input id="txtChar" type="text"  onkeypress="return isNumberKey(event)"  maxlength="6" id="PostalCode" {{$disabled}} name="PostalCode" class="form-control PostalCode" title="Postal Code" placeholder="Postal Code" autocomplete="off" rows="0" value="{{  old('PostalCode', $PostalCode) }}">
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <input type="hidden" class="getState" value="{{url('getState')}}">
                                                        <label for="country">Country</label>
                                                        <select {{$isPhysicalAddressReq}} autocomplete="off" value="{{ old('country') }}" name="country" id="country" class=" custom-select" {{$disabled}}>
                                                            <option value>Select Country</option>
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

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="eventSchedule col-lg-12 mt-3">
                                                        <h5> Event Schedule </h5>
                                                    </div>

                                                    <input type="hidden" class="eventStartDateChange" value="{{$EventDate}}">
                                                    <input type="hidden" class="eventEndDateChange" value="{{$EventEndDate}}">
                                                    <input type="hidden" class="eventTimezoneChange" value="{{$timezoneChangeId}}">

                                                    <div class="form-group col-lg-12">
                                                        <label for="EventDateTime">Event Start Date & Time</label>
                                                        <div class='input-group' id=''>
                                                            <input type='text'  value="{{  old('EventDateTime', $EventDate) }}" placeholder="16/05/2020 10:28 AM" class="form-control date readOnlyStartDate" required autocomplete="off" name="EventDateTime" id="EventDateTime" onchange="removeDisable();" />

                                                        </div>
                                                        <small class="text-danger">{{ $errors->first('EventDateTime') }}</small>
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="EventDateTime">Event End Date & Time</label>
                                                        <div class='input-group' id=''>
                                                            <input type='text'readonly="readonly" value="{{  old('EventEndDateTime', $EventEndDate) }}" placeholder="16/05/2020 11:28 AM" class="form-control date" autocomplete="off" name="EventEndDateTime" id="EventEndDateTime" required disabled="" />

                                                        </div>
                                                        <small class="text-danger">{{ $errors->first('EventEndDateTime') }}</small>
                                                    </div>

                                                    <div class="form-group col-lg-12">
                                                        <label for="cityTimezone mb-0">Time zone</label>
                                                        <select required autocomplete="off" value="{{ old('cityTimezone') }}" name="cityTimezone" id="cityTimezone" class=" custom-select">
                                                            <option value>Select Time Zone</option>
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
                                                            <!-- <label for="BlankLabel"></label> -->
                                                            <!-- <div class="icheck-material-primary">
                                                                <input type="checkbox" id="IsPublish" {{$IsLive}} name="IsPublish" @if(old('IsPublish')) checked @endif>
                                                                <label for="IsPublish"> Do you want to publish this event?</label>
                                                            </div> -->
                                                            <!-- <input type="hidden" class="publishEvent" name="IsPublish" value="{{$IsLive}}">
                                                            <button type="button" class="btn btn-primary mr-2 mt-2 publishButton" name="IsPublish" value="" id="publishButton" onclick="isPublishEvent(this);">Publish</button>
                                            <button type="button" class="btn btn-primary mt-2 draftButton" id="draftButton" value="" onclick="isPublishEvent(this);"> Save as Draft</button> -->
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
                                                                <input type="radio" id="ItIsFree" onclick="IsPaidAlert(this);" value="true" name="IsFree" <?php if (!empty($event)) {
                                                                                                                                                                if ($event->is_paid == 0) {
                                                                                                                                                                    echo "checked";
                                                                                                                                                                }
                                                                                                                                                            } else {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } ?>>
                                                                <label for="ItIsFree">Free</label>
                                                            </div>
                                                            <div class="icheck-material-primary icheck-inline">
                                                                <input type="radio" onclick="IsPaidAlert(this);" id="ItIsPaid" value="false" name="IsFree" <?php if (!empty($event)) {
                                                                                                                                                                if ($event->is_paid == 1) {
                                                                                                                                                                    echo "checked";
                                                                                                                                                                }
                                                                                                                                                            } ?>>
                                                                <label for="ItIsPaid">Paid</label>
                                                            </div>
                                                        </div>

                                                        <div class="alert alert-info m-0 PaidAlertBox d-none" role="alert">
                                                            <div class="alert-message pt-1 pb-1">
                                                                <span>You will get options for setting price tiers with Tickets once you save changes for this Event.</span>
                                                            </div>
                                                        </div>

                                                        <br>
                                                        <!-- <div class="form-group col-lg-12">
                                                            <label for="title">Custom URL</label>
                                                            <div class="form-control" style="display: flex;align-items:center;height:54px;">
                                                                <span style="display: flex;align-items: center;">{{env('APP_URL_Custom')}}</span>
                                                                <input type="text" class="form-control p-0 " style="border:none;" value="{{$CustomHumanReadableUrl}}" onkeyup="ChangeCustomUrl(this);" id="CustomUrl" name="CustomUrl" autocomplete="off">
                                                            </div>


                                                            <div class="row form-group pl-3">
                                                                <div class="col-lg-10 p-1" id="HumanFriendlyUrl" data="{{env('APP_URL_Custom')}}">
                                                                     {{$FinalUrl}}

                                                                </div>

                                                                <div class="col-lg-2 pt-1">
                                                                    <a onclick="copyHumanFriendlyUrl(this);"><i style="cursor:pointer; margin-left:5px;font-size:20px;" class="fa fa-copy" title="Copy to Clipboard"></i></a>
                                                                </div>

                                                                <div class='copied'></div>

                                                            </div>

                                                            <?php if (!empty($CustomHumanReadableUrl)) { ?>
                                                                <div class="pull-right">
                                                                    <a target="_blank" href="https://facebook.com"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-facebook-official" title=""></i></a>
                                                                    <a target="_blank" href="https://twitter.com/"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-twitter" title=""></i></a>
                                                                    <a target="_blank" href="https://www.linkedin.com/"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-linkedin" title=""></i></a>
                                                                </div>
                                                            <?php    } ?>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group col-lg-12">
                                            <!-- <button type="submit" id="Submit" class="btn btn-primary px-5 pull-right"> Save Event</button> -->
                                            <button type="submit" class="btn btn-primary mr-2 publishButton pull-right" name="IsPublish" value="" id="publishButton">Publish Event</button>
                                            <button type="submit" class="btn btn-primary mr-2 draftButton pull-right" id="draftButton" value=""> Save as Draft</button>
                                            <a class="pull-right" href="{{url('org/events')}}"><button type="button" class="btn btn-light mr-2">Cancel</button></a>
                                        </div>

                                </div>
                                </form>
                                <div id="confirmBox">
    <div class="message"></div>
    <span class="button yes">Yes</span>
    <span class="button no">No</span>
</div>
                                <!-- <div class="form-group col-lg-12 pr-5">
                                        <a class="pull-right" href="{{url('org/events')}}"><button class="btn btn-light">Cancel</button></a>
                                    </div> -->

                            </div>
                        </div>

                        <!-- </form> -->


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
                                            foreach ($videos as $video) { ?>

                                                <ul class="list-group parent list-group-flush mb-2">
                                                    <li class="list-group-item">
                                                        <div class="media align-items-center">
                                                            <div class="media-body ml-3 d-flex" style="align-items: center;">
                                                                <?php $AwsUrl = env('AWS_URL');
                                                                    $videoUrl = "";
                                                                    $url = "";
                                                                    $explodeUrl = "";
                                                                    $getLastWord = "";
                                                                    if (!is_null($video->url_type)) {
                                                                        if ($video->url_type == 1) {
                                                                            $videoUrl = $AwsUrl . $video->url; ?>
                                                                            <a class="pull-left" href="{{$videoUrl}}" target="_blank"><video class="pull-left" src="{{$videoUrl}}" width="100px" height="100px"></video></a>
                                                                    <?php    } else {
                                                                            $url = $video->url;
                                                                            if(strpos($url, 'youtube') !== false){
                                                                                $explodeUrl = explode('=', $url);
                                                                            }else{
                                                                            $explodeUrl = explode('/', $url);
                                                                            }
                                                                             
                                                $getLastWord = array_pop($explodeUrl);
                                                if(strpos($url, 'youtube') !== false){
                                                    $videoUrl = "https://www.youtube.com/embed/" . $getLastWord;
                                                }else{
                                                    $videoUrl = "https://player.vimeo.com/video/" . $getLastWord;
                                                }
                                                ?>
                                                <a class="pull-left" href="{{$videoUrl}}" target="_blank"><iframe width="100" height="70" src="{{$videoUrl}}" class="pull-left"></iframe></a>
                                                                      <?php  }
                                                                    } ?>
                                                                <!-- <a class="pull-left" href="{{$videoUrl}}" target="_blank"><video class="pull-left" src="{{$videoUrl}}" width="100px" height="100px"></video></a> -->
                                                                
                                                                <h6 class="pull-left ml-3" class="mb-0"><?php echo $video->title; ?></h6>
                                                                
<!--                                                                <small class="small-font">
                                                                    
                                                                    {{$videoUrl}}</small>-->
                                                            </div>
                                                            <div data-id="<?php echo $video->id; ?>" onclick="RemoveSingleVideo(this);" Type="video" UrlType="<?php echo $video->url_type; ?>" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php } ?>
                                            <?php
                                            foreach ($podcasts as $podcast) { ?>

                                                <ul class="list-group parent list-group-flush mb-2">
                                                    <li class="list-group-item">
                                                        <div class = "media align-items-center">
                                                            <h6 class="ml-3 col-lg-12 text-left" class="mb-0"><?php echo $podcast->title; ?></h6>
                                                        </div>
                                                        <div class="media align-items-center">
                                                            <div class="media-body ml-3 d-flex" style="align-items: center;">
                                                                <?php $AwsUrl = env('AWS_URL');
                                                                    $podcastvideoUrl = "";
                                                                    if (!is_null($podcast->url_type)) {
                                                                        if ($podcast->url_type == 1) {
                                                                            $podcastvideoUrl = $AwsUrl . $podcast->url;
                                                                        } else {
                                                                            $podcastvideoUrl = $podcast->url;
                                                                        }
                                                                    } ?>
                                                                
<!--                                                                <h6 class="mb-0"><?php echo $podcast->title ?></h6>
                                                                <small class="small-font">
                                                                    
                                                                    {{$podcastvideoUrl}}</small>-->
                                                                
                                                                <a class="pull-left" href="{{$podcastvideoUrl}}" target="_blank"><audio controls><source src="{{$podcastvideoUrl}}" type="audio/ogg"></audio>
                                                                    </a>
                                                                
                                                                <!-- <h6 class="pull-left ml-3" class="mb-0"><?php echo $podcast->title ?></h6> -->
                                                            </div>
                                                            <div data-id="<?php echo $podcast->id; ?>" onclick="RemoveSingleVideo(this);" Type="podcast" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                        </div>
                                                    </li>
                                                </ul>
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
                                                    <small class="text-danger urlError"></small>
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
                                                            <input id='video_file' name='video_file' type="file">
                                                            <p>Drag your video file here or click in this area.</p>
                                                        </div>
                                                    </div>
                                                    <small class="text-danger VideoInvalid"></small>
                                                </div>

                                                <div class="form-group progressBar d-none">
                                                    <div class="progress_upload">
                                                        <div class="bar_upload"></div>
                                                        <div class="percent_upload">0%</div>
                                                    </div>
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
                                                    <input type="text" class="form-control" id="input_title" name='input_title' value="{{  old('input_title') }}" placeholder="Enter Podcast Title" required>
                                                </div>
                                                <div class='form-group videoUrl PodcastUrl'>
                                                    <label for='input_url'>Podcast URL</label><span style="font-size: 11px;font-weight: 600;">&nbsp;&nbsp;(YouTube or Vimeo url)</span>
                                                    <input type="text" class="form-control" id="input_url" name="input_url" value="{{  old('input_url') }}" placeholder="Enter Podcast URL" required>
                                                    <small class="text-danger podcastUrlError"></small>
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
                                                            <input id='podcast_video_file' name='podcast_video_file' type="file">
                                                            <p>Drag your podcast file here or click in this area.</p>
                                                        </div>
                                                        <small class="text-danger PodcastInvalid"></small>
                                                    </div>

                                                    <div class="form-group podcastProgressBar d-none">
                                                    <div class="progress_upload">
                                                        <div class="bar_upload"></div>
                                                        <div class="percent_upload">0%</div>
                                                    </div>
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
                        <?php } else { ?>
                            <div class="text-center m-4"><label class="">Please save basic details to add media</label></div>
                        <?php } ?>
                    </div>

                    <div class="parent row
                    <?php if ($tabe == 3) {
                        echo "active";
                    } ?>
                     tab-pane " id="tabe-15">
                        <div class="text-center m-4"><label class="">This feature is coming soon</label></div>

                    </div>

                    <?php if (!empty($event) && $event->is_paid == 1) { ?>
                        <div class="parent row tab-pane " id="TicketsTab">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body row">
                                        <div id="uploadedTickets" class="col-lg-12 m-auto p-0">
                                            <?php
                                            foreach ($tickets as $ticket) { ?>
                                                <div class="parent">
                                                    <ul class="list-group parent list-group-flush TicketList mb-2 col-lg-8">
                                                        <li class="list-group-item">
                                                            <div class="media align-items-center">

                                                                <div class="media-body ml-3">
                                                                    <h6 class="mb-0">{{$ticket->name}} -- {{$ticket->quantity}} tickets, ${{$ticket->price}}/ticket</h6>
                                                                    <?php
                                                                    $old_date = $ticket->sales_end;
                                                                    $old_date_timestamp = strtotime($old_date);
                                                                    $new_date = date('l, F d y h:i:s', $old_date_timestamp);
                                                                    ?>
                                                                    <small class="small-font">End's on - {{$new_date}}</small>

                                                                </div>
                                                                <div data-id="<?php echo $ticket->id; ?>" onclick="EditSingleTicket(this);" Type="file" UrlType="" class="mr-2"><i class="fa icon fas fa-edit clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                                <div data-id="<?php echo $ticket->id; ?>" onclick="RemoveSingleTicket(this);" Type="file" UrlType="" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="col-lg-8 m-auto">
                                            <div class="card AddTicketContainer d-none">
                                                <!-- <div class="card-header">Add Ticket</div> -->
                                                <div class="card-body">
                                                    <form class="AddTicketForm row" method="post" enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" class="AddTicketUrl d-none" value="{{url('org/events/ticket/store')}}">
                                                        <input type="hidden" class="editEventTickets" value="{{url('org/events/editTicket')}}">
                                                        <input type="hidden" class="updateTicket" value="{{url('org/events/updateTicket')}}" name="updateTicket">
                                                        <input type="text" class="TicketEventID d-none" id="TicketEventID" name="TicketEventID" value="{{$event->id}}">
                                                        <input type="hidden" class="ticketId" value="" name="ticketId">
                                                        <input type="hidden" class="removeEventTickets" value="{{url('org/events/deleteTicket')}}">
                                                        <div class="form-group col-lg-12">
                                                            <label for="TicketName">Name</label>
                                                            <input type="text" class="form-control" id="TicketName" value="" name="TicketName" placeholder="Name" required>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="TicketQuantity">Quantity</label>
                                                            <input type="number" class="form-control" id="TicketQuantity" value="" name="TicketQuantity" placeholder="Quantity" required>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="TicketPrice">Price</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">$</span>
                                                                </div>
                                                                <input type="number" class="form-control" id="TicketPrice" value="" step="0.01" name="TicketPrice" placeholder="Price" required>

                                                            </div>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="SalesStart">Sale's Start Date &amp; Time</label>
                                                            <div class="input-group" id="">
                                                                <input type="text" value="" placeholder="05/16/2020 10:28 AM" class="form-control date" autocomplete="off" name="SalesStart" id="SalesStart" required>

                                                            </div>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="SalesEnd">Sale's End Date &amp; Time</label>
                                                            <div class="input-group" id="">
                                                                <input type="text" value="" placeholder="05/16/2020 10:28 AM" class="form-control date" autocomplete="off" name="SalesEnd" id="SalesEnd" required>

                                                            </div>
                                                            <small class="text-danger"></small>
                                                        </div>
                                                        <div class="col-lg-12"><button type="submit" id="AddTicketSubmitButton" data-id="" class="btn btn-primary pull-right mr-2 AddTicketSubmitButton">Save Ticket</button>
                                                            <!-- <div class="btn btn-primary m-2 pull-right">Cancel</div> -->
                                                            <input type="button" id="ticketCancelButton" data-id="" class="btn btn-primary pull-right mr-2" value="Cancel" onclick="showTicketListing(this);">
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                            <div class="text-center col-lg-12 mt-4">
                                                <button type="button" id="ticketButton" class="btn btn-outline-primary btn-round waves-effect waves-light m-1" onclick="uploadTicket(this);">Add Ticket</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php    } ?>



                    <div class="speakers row tab-pane <?php if ($tabe == 2) {
                                                            echo "active";
                                                        } ?>" id="tabe-16">
                        <?php if ($IsNew == false) { ?>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="uploadedSpeakers" class="col-lg-12 m-auto p-0">
                                            <?php
                                            foreach ($speakers as $speaker) { ?>
                                                <div class="parent">
                                                    <ul class="list-group parent list-group-flush speakerList mb-2">
                                                        <li class="list-group-item">
                                                            <div class="media align-items-center">
                                                                <?php
                                                                $profileurl = "";
                                                                if ($speaker->profile_pic) {
                                                                    $pic = $speaker->profile_pic;
                                                                    $profileurl = env('AWS_URL') . $pic;
                                                                } else {
                                                                    $profileurl = "https://via.placeholder.com/110x110";
                                                                }
                                                                ?>
                                                                <img src="{{$profileurl}}" alt="user avatar" class="speakerImgSize rounded">
                                                                <div class="media-body ml-3">
                                                                    <h6 class="mb-0">{{$speaker->name}}</h6>
                                                                    <small class="small-font">{{$speaker->organization}} - {{$speaker->description}}</small>

                                                                </div>
                                                                <div data-id="<?php echo $speaker->id; ?>" onclick="EditSingleSpeaker(this);" Type="file" UrlType="" class="mr-2"><i class="fa icon fas fa-edit clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                                <div data-id="<?php echo $speaker->id; ?>" onclick="RemoveSingleSpeaker(this);" Type="file" UrlType="" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                </div>
                                            <?php } ?>
                                        </div>

                                        <input type="hidden" name="_token" value="bk1OhavN4UAzV8S98BIoRMOxciaSsCWi3X6j8YAf">

                                        <div class="card col-lg-12 p-4 speakerContainer d-none m-auto parent">
                                            <form class="SaveSpeaker" id="SaveSpeaker" name="SaveSpeaker" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" class="addSpeakers" value="{{url('org/events/speaker/store')}}">
                                                <input type="hidden" class="editEventSpeakers" value="{{url('org/events/editSpeaker')}}">
                                                <input type="hidden" class="updateSpeaker" value="{{url('org/events/updateSpeaker')}}">
                                                <input type="hidden" class="speakerId" value="" name="speakerId">
                                                <input type="hidden" class="removeEventSpeakers" value="{{url('org/events/deleteSpeaker')}}">
                                                <input type="text" name="EventToLinkId" id="EventToLink" class="d-none" value="{{$event->id}}" />

                                                <div class="form-group col-lg-12 row">
                                                    <div class="form-group col-lg-6">
                                                        <label for="profilePicImage">Profile Pic</label>
                                                        <input type="hidden" name="eventSpeakerPic" class="eventSpeakerPic" value="">
                                                        <div class="dragFileContainer thumbNailContainer SpeakerProfilePicDiv" style="display: flex;justify-content: center;">
                                                            <input type="file" accept="image/*" id="EventProfilePicImage" name="profilePicImageUpload" class="form-control files" picvalue="">
                                                            <img id="profilePicImage" src="" class="d-none imageRadius w-100 {{$profilePicHidden}}" alt="your image" width="100" value="">
                                                            <p class="picText">Drop your image here or click to upload.</p>
                                                            <!-- <p id="TempTextThumb" class="TempTextPic">Drop your image here or click to upload.</p> -->
                                                        </div>

                                                <div class="text-danger d-none SizeError" id='SizeErrorBannerImage'>Image size must be less than or eqaul to 4MB</div>
                                                <?php 
                                            $dNoneClassProfile = "d-none";
                                            if(!empty($speaker->profile_pic)){
                                                $dNoneClassProfile = '';
                                            }
                                            ?>
                                                        <div class="removeprofilepic {{$dNoneClassProfile}}"><a type="button" id="RemoveProfileBtn">Remove Profile Pic</a></div>
                                                    </div>


                                                    <div class="form-group col-lg-6">
                                                        <!-- <label for="speakerTitle">Title</label>
                                                        <input type="text" class="form-control mb-2" id="speakerTitle" value="" name="speakerTitle" placeholder="Enter Title" required="">
                                                        <small class="text-danger"></small> -->

                                                        <label for="speakerFirstName">Name</label>
                                                        <input type="text" class="form-control mb-2" id="speakerFirstName" value="" name="speakerFirstName" placeholder="Enter Name" required="">
                                                        <small class="text-danger"></small>

                                                        <label for="speakerTitle">Title</label>
                                                        <input type="text" class="form-control mb-2" id="speakerTitle" value="" name="speakerTitle" placeholder="Enter Title" required="">
                                                        <small class="text-danger"></small>

                                                        <label for="speakerOrganization">Organization</label>
                                                    <input type="text" class="form-control" id="speakerOrganization" value="" name="speakerOrganization" placeholder="Enter Organization" required="">
                                                    <small class="text-danger"></small>

                                                        <!-- <label for="speakerLastName">Last Name</label>
                                                        <input type="text" class="form-control" id="speakerLastName" value="" name="speakerLastName" placeholder="Enter Last Name" required="">
                                                        <small class="text-danger"></small> -->

                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-12">
                                                    <label for="speakerDesc">Description</label>
                                                    <textarea id="speakerDesc" name="speakerDesc" required="" class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4"></textarea>
                                                    <small class="text-danger"></small>
                                                </div>

                                                <!-- <div class="form-group col-lg-12">
                                                    <label for="speakerOrganization">Organization</label>
                                                    <input type="text" class="form-control" id="speakerOrganization" value="" name="speakerOrganization" placeholder="Enter Organization" required="">
                                                    <small class="text-danger"></small>
                                                </div> -->

                                                <div class="form-group col-lg-12">
                                                    <label for="speakerLinkedinUrl">LinkedIn URL</label>
                                                    <input type="url" class="form-control" id="speakerLinkedinUrl" value="" name="speakerLinkedinUrl" placeholder="Enter LinkedIn Url">
                                                    <small class="text-danger"></small>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button type="submit" id="speakerSubmitButton" data-id="" class="btn btn-primary px-5 pull-right"> Save Speaker</button>

                                                    <input type="button" id="speakerCancelButton" data-id="" class="btn btn-primary pull-right mr-2" value="Cancel" onclick="showSpeakerListing(this);">
                                                </div>
                                            </form>
                                        </div>

                                        <div class="text-center col-lg-12 mt-4">
                                            <button type="button" id="speakerButton" class="btn btn-outline-primary btn-round waves-effect waves-light m-1" onclick="uploadSpeaker(this);">Add Speaker</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="text-center m-4"><label class="">Please save basic details to add speakers</label></div>
                        <?php } ?>

                    </div>

                </div>
                <!-- <div class="parent row tab-pane" id="tabe-15">

                </div> -->


            </div>



        </div>






    </div>

</div>
<!--</div>
</div>
</div>-->
@endsection

@section('script')
<script src="{{asset('/js/Events.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- datetimepicker -->
<script src="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.single-select').select2();

        $('.multiple-select').select2({
            placeholder: "Select categories",
            allowClear: true
        });
        var MultiSlectCounter = 0;
        $('.multiple-select').on('select2:select', function(e) {
            console.log(e.params.data.id);
            if (MultiSlectCounter == 0) {
                $('#HiddenCategoyID').append(e.params.data.id);
            } else {
                $('#HiddenCategoyID').append("," + e.params.data.id);
            }

            MultiSlectCounter += 1;
        });
        $('.multiple-select').on('select2:unselecting', function(e) {
            console.log(e.params.args.data.id);
            var str = $('#HiddenCategoyID').val();
            var res = str.replace(e.params.args.data.id, "");
            $('#HiddenCategoyID').empty();
            $('#HiddenCategoyID').append(res);
        });


        //multiselect start

        //        $('#my_multi_select1').multiSelect();
        //        $('#my_multi_select2').multiSelect({
        //            selectableOptgroup: true
        //        });
        //
        //        $('#my_multi_select3').multiSelect({
        //            selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        //            selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        //            afterInit: function(ms) {
        //                var that = this,
        //                    $selectableSearch = that.$selectableUl.prev(),
        //                    $selectionSearch = that.$selectionUl.prev(),
        //                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
        //                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';
        //
        //                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        //                    .on('keydown', function(e) {
        //                        if (e.which === 40) {
        //                            that.$selectableUl.focus();
        //                            return false;
        //                        }
        //                    });
        //
        //                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        //                    .on('keydown', function(e) {
        //                        if (e.which == 40) {
        //                            that.$selectionUl.focus();
        //                            return false;
        //                        }
        //                    });
        //            },
        //            afterSelect: function() {
        //                this.qs1.cache();
        //                this.qs2.cache();
        //            },
        //            afterDeselect: function() {
        //                this.qs1.cache();
        //                this.qs2.cache();
        //            }
        //        });
        //
        //        $('.custom-header').multiSelect({
        //            selectableHeader: "<div class='custom-header'>Selectable items</div>",
        //            selectionHeader: "<div class='custom-header'>Selection items</div>",
        //            selectableFooter: "<div class='custom-header'>Selectable footer</div>",
        //            selectionFooter: "<div class='custom-header'>Selection footer</div>"
        //        });


    });
</script>
@endsection