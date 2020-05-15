@extends('layouts.appOrg')

@section('content')
<div class="container-fluid mt-3 createEventContainer">
    <?php
    $CardTitle = "Add New Event";
    $title = "";
    $categoryID = 0;
    $desription = "";
    $address = "";
    $cityID = 0;
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
    }

    ?>
    <h5 class="mb-3">{{$CardTitle}}</h5>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-info nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabe-13"><span class="hidden-xs">Details</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabe-14"><span class="hidden-xs">Participants</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabe-15"><span class="hidden-xs">Promote</span></a>
                    </li>
                </ul>

                <div class="row">
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
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" value="{{ old('title',$title) }}" name="title" placeholder="Enter Event Title" required>
                            <small class="text-danger">{{ $errors->first('title') }}</small>
                        </div>


                        <div class="form-group col-lg-6">
                            <label>Select Categories</label>
                            <select class="form-control multiple-select" multiple="multiple" name="category" id="category" required>
                                <?php foreach ($categories as $category) {
                                    if (!empty($event)) {
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
                                        }
                                    }

                                ?>
                                    <option value="{{old('category',$category->id)}}" {{$IsSelected}} @if (old('category')==$category->id) selected="selected" @endif ><?php echo $category->name; ?> </option>
                                <?php } ?>
                            </select>
                            <small class="text-danger">{{ $errors->first('category') }}</small>
                            <textarea id="HiddenCategoyID" name="HiddenCategoyID" required class="form-controld d-none" title="HiddenCategoyID" placeholder="HiddenCategoyID" autocomplete="off" rows="4">{{$MultSelectTags}}</textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="Description">Description</label>
                            <textarea id="Description" name="Description" required class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4">{{ old('Description', $desription) }}</textarea>
                            <small class="text-danger">{{ $errors->first('Description') }}</small>
                        </div>
                    </div>
                </div>
        </div>
    </div>

            <div class="row">
                <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="locationDetails col-lg-12 mt-3">
                            <h5> Location Details </h5>
                        </div>

                        <div class="form-group col-12 mt-3">
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsOnline" name="IsOnline" {{$IsOnline}}  @if( is_array(old('IsOnline')) && in_array(1, old('IsOnline'))) checked @endif onclick="IsOnlineEvent(this);">
                                <label for="IsOnline">Is this event online?</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">

                            <input type="text" id="EventUrl" value="{{  old('EventUrl', $EventUrl) }}" name="EventUrl" class="form-control {{$HiddenEventUrl}}" title="Event Url" placeholder="Event Website Url" autocomplete="off" rows="0" value="">
                        </div>


                        <div class="form-group col-lg-12">
                            <label for="Address">Address</label>
                            <input type="text" id="Address" name="Address" {{$readonly}} class="form-control" title="Address" placeholder="Address" autocomplete="off" rows="0" value="{{  old('Address', $address) }}">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="selectionCategory">City</label>
                            <select autocomplete="off" value="{{ old('city') }}" name="city" id="city" class=" custom-select" {{$disabled}}>
                                <option value="0">Select City</option>
                                <?php foreach ($cities as $city) {
                                    $IsSelected = "";
                                    if ($city->id == $cityID) {
                                        $IsSelected = "selected";
                                    }
                                ?>
                                    <option value="{{$city->id}}" {{$IsSelected}} @if (old('city')==$city->id) selected="selected" @endif ><?php echo $city->name; ?> </option>
                                <?php } ?>

                            </select>
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
                                <input type='text' value="{{  old('EventDateTime', $EventDate) }}" class="form-control date" autocomplete="off" name="EventDateTime" id="EventDateTime" required />

                            </div>
                            <small class="text-danger">{{ $errors->first('EventDateTime') }}</small>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="EventDateTime">Event End Date & Time</label>
                            <div class='input-group' id=''>
                                <input type='text' value="{{  old('EventEndDateTime', $EventEndDate) }}" class="form-control date" autocomplete="off" name="EventEndDateTime" id="EventEndDateTime" required />

                            </div>
                            <small class="text-danger">{{ $errors->first('EventEndDateTime') }}</small>
                        </div>

                        <div class="row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label for="BlankLabel"></label>
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsPublic" name="IsPublic" {{$IsPublic}}>
                                <label for="IsPublic"> Is this Public Event?</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="BlankLabel"></label>
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsPaid" name="IsPaid" {{$IsPaid}}>
                                <label for="IsPaid">Is this Paid Event?</label>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                        <div class="additionalDetails col-lg-12  mt-3">
                            <h5> Additional Details </h5>
                        </div>

                        <div class="col-lg-12 row">
                        <div class="form-group col-lg-6">
                            <label for="EventBannerImage">Banner Image (optional)</label>
                            <p style="font-size: .7pc;">Image size must be less than or eqaul to 1MB and Dimension should be 468 &#10005; 200</p>
                            <input type="file" accept="image/*" id="EventBannerImage" name="EventBannerImage" class="form-control files" onchange="document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('bannerImage').classList.remove('d-none');">
                            <small class="text-danger">{{ $errors->first('EventBannerImage') }}</small>
                            <div class="text-danger d-none SizeError" id='SizeErrorBannerImage'>Image size must be less than or eqaul to 1MB</div>
                            <img id="bannerImage" class="d-none mt-2 imageRadius w-100" alt="your image" width="100" height="100" />

                        </div>
                        <div class="form-group col-lg-6">
                            <label for="EventThumbnailImage">Thumbnail Image (optional)</label>
                            <p style="font-size: .7pc;">Image size must be less than or eqaul to 1MB and Dimension should be 1280 &#10005; 720</p>
                            <input type="file" accept="image/*" id="EventThumbnailImage" name="EventThumbnailImage" class="form-control files" onchange="document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('thumbnailImage').classList.remove('d-none');">
                            <small class="text-danger">{{ $errors->first('EventThumbnailImage') }}</small>
                            <div class="text-danger d-none SizeError" id='SizeErrorBannerImage'>Image size must be less than or eqaul to 1MB</div>
                            <img id="thumbnailImage" class="d-none m-2 imageRadius" alt="your image" width="100" height="100" />
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

                        <!-- <div class="form-group col-lg-6">
                            <label for="input-5">Durations</label>
                            <input type="time" id="" class="form-control">
                        </div> -->

                        <!-- <div class="form-group col-lg-12">
                            <button type="submit" id="Submit" class="btn btn-primary px-5 pull-right"> Save Event</button>
                        </div>
                    </form> -->
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    <!-- </div> -->
    </div>
    </div>
    </div>
    <div class="form-group col-lg-12">
        <button type="submit" id="Submit" class="btn btn-primary px-5 pull-right"> Save Event</button>
    </div>
</form>
</div>
@endsection

@section('script')
<script src="{{asset('/js/customScript.js')}}" type="text/javascript"></script>
@endsection