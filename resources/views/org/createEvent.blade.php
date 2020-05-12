@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $CardTitle = "Add New Event";
    $title = "";
    $categoryID = 0;
    $desription = "";
    $address = "";
    $cityID = 0;
    $EventDate = "";
    $IsPublic = "";
    $IsOnline = "";
    $IsPaid = "";
    $IsSelected = "";
    $disabled="";
    $readonly="";
    $ActionCall=url('org/events/store');

    if (!empty($event)) {
        $ActionCall=url('org/events/edit/'.$event->id);
        $CardTitle = "Edit Event";
        $title = $event->title;
        $desription = $event->description;
        $address = $event->address;
        $EventDate = $event->date_time;
        $categoryID = $event->category_id;
        $cityID = $event->city_id;
       
        if($event->is_public){
            $IsPublic="checked";
        }
        if($event->is_online){
            $IsOnline="checked";
            $disabled="disabled='true'";
            $readonly="readonly='true'";
        }
        if($event->is_paid){
            $IsPaid="checked";
        }
    }

    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>{{$CardTitle}}</h5>
                    </div>
                    <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form class="row" method="post" action="{{$ActionCall}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="basicDetails col-lg-12">
                            <h5> Basic Details </h5>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" value="{{$title}}" name="title" placeholder="Enter Event Title">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="selectionCategory">Category</label>
                            <select autocomplete="off" name="category" id="category" class=" custom-select">
                                <option value="0">Select Category</option>
                                <?php foreach ($categories as $category) {
                                    if ($category->id == $categoryID) {
                                        $IsSelected = "selected";
                                    }
                                ?>
                                    <option value="{{$category->id}}" {{$IsSelected}}><?php echo $category->name; ?> </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="Description">Description</label>
                            <textarea id="Description" name="Description" class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4">{{$desription}}</textarea>
                        </div>

                        <div class="locationDetails col-lg-12 mt-3">
                            <h5> Location Details </h5>
                        </div>

                        <div class="form-group col-12">
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsOnline" name="IsOnline" {{$IsOnline}} onclick="IsOnlineEvent(this);">
                                <label for="IsOnline">Is this event Online event?</label>
                            </div>
                        </div>


                        <div class="form-group col-lg-6">
                            <label for="Address">Address</label>
                            <input type="text" id="Address" name="Address" {{$readonly}} value="{{$address}}" class="form-control" title="Address" placeholder="Address" autocomplete="off" rows="0">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="selectionCategory">City</label>
                            <select autocomplete="off" name="city" id="city" class=" custom-select" {{$disabled}}>
                                <option value="0">Select City</option>
                                <?php foreach ($cities as $city) {
                                    $IsSelected = "";
                                    if ($city->id == $cityID) {
                                        $IsSelected = "selected";
                                    }
                                ?>
                                    <option value="{{$city->id}}" {{$IsSelected}}><?php echo $city->name; ?> </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="eventSchedule col-lg-12 mt-3">
                            <h5> Event Schedule </h5>
                        </div>

                        <div class="form-group col-lg-4">
                            <!-- col-lg-2 -->
                            <label for="EventDateTime">Event Date</label>
                            <!-- <input type="date" id="EventDateTime" name="EventDateTime" class="form-control"> -->
                            <div class='input-group' id='EventDateTime'>
                                <input type='text' value="{{$EventDate}}" class="form-control date" name="EventDateTime" id="EventDateTime" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <!-- datetime-local -->
                        </div>
                        <!-- <div class="form-group col-lg-2">
                            <label for="StartTime">Start Time</label>
                            <select autocomplete="off" name="StartTime" id="StartTime" class=" custom-select">
                                <option value="0">Start Time</option>
                                <?
                                for ($hours = 0; $hours < 24; $hours++) // the interval for hours is '1'
                                    for ($mins = 0; $mins < 60; $mins += 30) // the interval for mins is '30'
                                        echo '<option>' . str_pad($hours, 2, '0', STR_PAD_LEFT) . ':'
                                            . str_pad($mins, 2, '0', STR_PAD_LEFT) . '</option>';
                                ?>

                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="EndTime">End Time</label>
                            <select autocomplete="off" name="EndTime" id="EndTime" class=" custom-select">
                                <option value="0">End Time</option>


                            </select>
                        </div> -->

                        <div class="form-group col-3 mt-2">
                            <label for="BlankLabel"></label>
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsPublic" name="IsPublic" {{$IsPublic}}>
                                <label for="IsPublic"> Is this Public Event?</label>
                            </div>
                        </div>
                        <div class="form-group col-3 mt-2">
                            <label for="BlankLabel"></label>
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsPaid" name="IsPaid" {{$IsPaid}}>
                                <label for="IsPaid">Is this Paid Event?</label>
                            </div>
                        </div>

                        <div class="additionalDetails col-lg-12  mt-3">
                            <h5> Additional Details </h5>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="EventBannerImage">Banner Image (optional)</label>
                            <input type="file" id="EventBannerImage" name="EventBannerImage" class="form-control" onchange="document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('bannerImage').classList.remove('d-none');">
                            <small class="text-danger">{{ $errors->first('EventBannerImage') }}</small>
                            <img id="bannerImage" class="d-none mt-2 imageRadius w-100" alt="your image" width="100" height="100" />

                        </div>
                        <div class="form-group col-lg-6">
                            <label for="EventThumbnailImage">Thumbnail Image (optional)</label>
                            <input type="file" id="EventThumbnailImage" name="EventThumbnailImage" class="form-control" onchange="document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('thumbnailImage').classList.remove('d-none');">
                            <small class="text-danger">{{ $errors->first('EventThumbnailImage') }}</small>
                            <img id="thumbnailImage" class="d-none m-2 imageRadius" alt="your image" width="100" height="100" />

                        </div>

                        <!-- <div class="form-group col-lg-6">
                            <label for="input-5">Durations</label>
                            <input type="time" id="" class="form-control">
                        </div> -->




                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary px-5 pull-right"> Save Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('/js/customScript.js')}}" type="text/javascript"></script>
@endsection