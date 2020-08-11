@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $CardTitle = "Add New Podcast";
    $ActionCall = url('org/podcasts/store');
    $RedirectCall = url('org/podcasts');
    $title = "";
    $desription = "";
    $podcastVideoEventId = 0;
    $linkedEventCheckced = "";
    $podcastvideoDescription = "";

    if (!empty($podcast)) {
        $ActionCall = url('org/podcasts/edit/' . $podcast->id);
        $CardTitle = "Edit Podcast";
        $title = $podcast->title;
        $desription = $podcast->url;
        if(isset($podcast->description)){
            $podcastvideoDescription = $podcast->description;
        }
        
        if(isset($podcast->event)){
            $linkedEventCheckced = "checked";
            // $desription = $podcast->url;
            // $desription = "Event:".$podcast->event->title;
        }else{
            // $desription = $podcast->url;
            // $desription = $podcast->description;
        }
        if (!empty($podcast->event_id)) {
            $podcastVideoEventId = $podcast->event_id;
        }
    }
    ?>
    <div class="row">
        <div class="col-lg-6">
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

                    <form class="dragFileForm parent" action="{{$ActionCall}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id="hdnRedirect" value="{{$RedirectCall}}" />
                        <div class='form-group'>
                            <label for='input_title'>Podcast Title</label>
                            <input type="text" class="form-control" id="input_title" name='input_title' value="{{  old('input_title', $title) }}" placeholder="Enter Podcast Title" required>
                        </div>
                        <hr class="mt-5 mb-5">

                        <div class="form-group">
                                    <label for="BlankLabel"></label>
                                <input type="hidden" class="linkedEvent" name="linkedEvent" value="">
                                    <!-- <p> Do you want to link this podcast with any Event?</p> -->
                                    <label> Do you want to link this podcast with any Event?</label>
                                    <div class="row pl-3">
                                    <div class="icheck-material-primary">
                                        <input onchange='showHideLinkEvent(this);' type="radio" class="" id="yesEventLinked" name="IsLinkedEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif>
                                            <label for="yesEventLinked">Yes</label>
                                    </div>
                                    <div class="icheck-material-primary pl-2">
                                        <?php 
                                            $checkedRadio = "checked";
                                            if($podcastVideoEventId != 0){
                                                $checkedRadio = "";
                                            }
                                        ?>
                                        <input onchange='showHideLinkEvent(this);' type="radio" id="noEventLinked" name="IsLinkedEvent" {{$checkedRadio}}>
                                        <label for="noEventLinked">No</label>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group descriptionDiv">
                                            <!-- <label for="Description">Podcast Description</label> -->
                                            <p for="Description">Podcast Description</p>
                                            <textarea id="Description" name="Description" class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4">{{ old('Description', $podcastvideoDescription) }}</textarea>
                        </div>

                        <div id='linkEvent' class="form-group EventSelectionBox d-none">
                                <label for="EventToLink mb-0">Link To Event</label>
                                <select autocomplete="off" value="" name="EventToLink" id="EventToLink" class=" custom-select">
                                    <option value="">Select Event To Link</option>
                                    <?php
                                    foreach ($events as $event) {
                                        $IsSelected = "";
                                        if (!empty($podcast)) {
                                            if ($event->id == $podcastVideoEventId) {
                                                $IsSelected = "selected";
                                            }
                                        }
                                        //                                        $IsSelected = "";
                                        //                                        if ($event->id == $eventId) {
                                        //                                            $IsSelected = "selected";
                                        //                                        }
                                    ?>
                                        <option value="{{$event->id}}" {{$IsSelected}}  @if (old('EventToLink')==$event->id) selected="selected" @endif ><?php echo $event->title; ?> </option>
                                    <?php } ?>

                                </select>
                            </div>

                        <hr class="mt-5 mb-5">

                        <?php
                        $classChange = "d-none";
                        if(!empty($podcast)){
                            $classChange = "";
                        }?>
                        <div class='form-group mediaPodcastDiv {{$classChange}}'>
                            <?php
                                    $AwsUrl = env('AWS_URL');
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
                                <a href="{{$videoPodcastUrl}}" target="_blank" class="videoIframe"><audio controls><source src="{{$videoPodcastUrl}}" type="audio/ogg" class="col-lg-7 pr-0 pl-0"></audio></a>

                                            <?php 
                                            $dNoneClassPodcast = "d-none";
                                            if(!empty($podcast->url)){
                                                $dNoneClassPodcast = '';
                                            }
                                            ?>
                                                <div class="changePodcast {{$dNoneClassPodcast}}"><a type="button" id="ChangePodcastBtn">Change Podcast</a></div>
                        </div>

                        <div class="form-group {{$dnoneClass}} checkPodcastExist">
                            <label> You can either save your Youtube or Vimeo podcast URL OR you can upload your own podcast.</label>
                        </div>
                        <div class="form-group {{$dnoneClass}} checkPodcastExist">
                            <p for='input_url' class="float-left">Podcast URL</p><span style="font-size: 11px;font-weight: 600;">&nbsp;&nbsp;(YouTube or Vimeo url)</span>
                            <input type="text" class="form-control" id="input_url" onkeyup="pocastUrlCheck(this);" onchange="pocastUrlCheck(this);" name="input_url" value="{{  old('input_url', $desription) }}" placeholder="Enter Podcast URL" required>
                            <small class="text-danger urlError">{{ $errors->first('input_url') }}</small>
                            <!-- <label> You can either save your Youtube or Vimeo podcast URL OR you can upload your own podcast.</label> -->
                        </div>

                        <div class="form-group {{$dnoneClass}} checkPodcastExist">
                                <label for="BlankLabel"></label>
                                <div class="icheck-material-primary">
                                    <input onclick="UploadPodcastVideoBox()" type="checkbox" id="IsUploadPodcast" name="IsUploadPodcast" @if(old('IsUploadPodcast')) checked @endif>
                                    <label for="IsUploadPodcast">Or upload your own podcast</label>
                                </div>
                            </div>

                        <div class='parent' style='width: 100%;'>
                            <div class='form-group  d-none uploadPodcastBox'>
                                <!-- <label for='input_podfile'>Upload Podcast</label> -->
                                <p for='input_podfile'>Select Podcast</p>
                                <div class='dragFileContainer'>
                                    <input type="file" id='input_podfile' name='input_podfile' value="{{  old('input_podfile') }}" >
                                    <p class="dragFileText">Drag your podcast file here or click to upload</p>
                                </div>
                                <small class="text-danger podcastFileError"></small>
                                <!-- <small class="text-danger">{{ $errors->first('input_podfile') }}</small> -->
                            </div>
                            <div class="form-group podcastProgressBar d-none">
                                <div class="progress_upload">
                                    <div class="bar_upload"></div >
                                    <div class="percent_upload">0%</div >
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="BlankLabel"></label>
                                <input type="hidden" class="linkedEvent" name="linkedEvent" value="">
                                <div class="icheck-material-primary">
                                    <input onchange='showHideLinkEvent(this);' type="checkbox" id="IsLinkedEvent" name="IsLinkedEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif>
                                    <label for="IsLinkedEvent"> Do you want to link this podcast with any Event?</label>
                                </div>
                            </div> -->

                            <!-- <div class="form-group">
                                    <label for="BlankLabel"></label>
                                <input type="hidden" class="linkedEvent" name="linkedEvent" value="">
                                    <p> Do you want to link this podcast with any Event?</p>
                                    <div class="row pl-3">
                                    <div class="icheck-material-primary">
                                        <input onchange='showHideLinkEvent(this);' type="radio" class="" id="yesEventLinked" name="IsLinkedEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif>
                                            <label for="yesEventLinked">Yes</label>
                                    </div>
                                    <div class="icheck-material-primary pl-2">
                                        <?php 
                                            $checkedRadio = "checked";
                                            if($podcastVideoEventId != 0){
                                                $checkedRadio = "";
                                            }
                                        ?>
                                        <input onchange='showHideLinkEvent(this);' type="radio" id="noEventLinked" name="IsLinkedEvent" {{$checkedRadio}}>
                                        <label for="noEventLinked">No</label>
                                    </div>
                                </div>
                            </div> -->

                             <!-- <div class="form-group descriptionDiv">
                                            <label for="Description">Podcast Description</label>
                                            <textarea id="Description" name="Description" class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4">{{ old('Description', $podcastvideoDescription) }}</textarea>
                            </div> -->


                            <!-- <div id='linkEvent' class="form-group EventSelectionBox d-none">
                                <label for="EventToLink mb-0">Link To Event</label>
                                <select autocomplete="off" value="" name="EventToLink" id="EventToLink" class=" custom-select">
                                    <option value="">Select Event To Link</option>
                                    <?php
                                    foreach ($events as $event) {
                                        $IsSelected = "";
                                        if (!empty($podcast)) {
                                            if ($event->id == $podcastVideoEventId) {
                                                $IsSelected = "selected";
                                            }
                                        }
                                        //                                        $IsSelected = "";
                                        //                                        if ($event->id == $eventId) {
                                        //                                            $IsSelected = "selected";
                                        //                                        }
                                    ?>
                                        <option value="{{$event->id}}" {{$IsSelected}}  @if (old('EventToLink')==$event->id) selected="selected" @endif ><?php echo $event->title; ?> </option>
                                    <?php } ?>

                                </select>
                            </div> -->
                        </div>


                        <!-- <button class="btn btn-primary px-5 pull-right" type="submit">Save Podcast</button> -->
                        <?php
                        $showButton = "d-none";
                        if($desription != ""){
                            $showButton = "";
                        }
                        ?>
                        <button id="btnSavePodcast" class="{{$showButton}} btn btn-primary px-5 pull-right" type="submit">Save Podcast</button>
                    </form>

                    <a href="{{url('org/podcasts')}}"><button id="btnCancelPodcast" class="{{$showButton}} btn btn-light float-left">Cancel</button></a>

                    <!--                    <form class="row" method="post" action="{{$ActionCall}}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group col-lg-6">
                                                <label for="EventThumbnailImage">Upload your video</label>
                                                <p style="font-size: .7pc;">Video size must be less than 100mb </p>
                                                <input type="file" id="VideoFile" name="VideoFile" 
                                                       class="form-control" >
                                                <small class="text-danger">{{ $errors->first('VideoFile') }}</small>                            
                    
                                            </div>
                    
                                             <div class="form-group col-lg-6">
                                                <label for="input-5">Durations</label>
                                                <input type="time" id="" class="form-control">
                                            </div> 
                    
                    
                    
                    
                                            <div class="form-group col-lg-12">
                                                <button type="submit" class="btn btn-primary px-5 pull-right"> Save Video</button>
                                            </div>
                                        </form>-->
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header listItemsBottomBorder border-bottom-0">Recently Added Podcasts
                    <!-- <div class="card-action">
                        <div class="dropdown">
                            <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                <i class="icon-options"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void();">Action</a>
                                <a class="dropdown-item" href="javascript:void();">Another action</a>
                                <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void();">Separated link</a>
                            </div>
                        </div>
                    </div> -->
                </div>

                <ul class="list-group list-group-flush shadow-none">
                    <!-- <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$810,000 . 04 Beds . 03 Baths</small>
                            </div>
                        </div>
                    </li> -->
                    
                    <?php foreach ($RecentPodcasts as $Podcast) { ?>
                        <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                        <input type="hidden"  class="deletePodcast" value="{{url('deletePodcast')}}">
                        <li class="list-group-item listItemsBottomBorder parent">
                            <!-- <div class="media align-items-center"> -->
                                <div class="row align-items-center">
                                <?php
                                    $AwsUrl = env('AWS_URL');
                                        $videoPodcastUrl = "";
                                        if (!empty($Podcast->url)) {
                                            if(substr($Podcast->url, 0, 8 ) != "https://"){
                                                $videoPodcastUrl = $AwsUrl . $Podcast->url;
                                            }
                                            else{
                                                $videoPodcastUrl = $Podcast->url;
                                            }
                                        }
                                ?>
                                    
                                <!-- <a href="{{$videoPodcastUrl}}" target="_blank"><img src="{{asset('assets/images/podcast-icon.png')}}" alt="user avatar" class="customer-img rounded"></a> -->

                                <a href="{{$videoPodcastUrl}}" target="_blank"><audio controls><source src="{{$videoPodcastUrl}}" type="audio/ogg" class="col-lg-7 pr-0 pl-0"></audio></a>

                                <div class="media-body col-lg-5">
                                    <h6 class="mb-0">{{$Podcast->title}}</h6>
                                    <?php 
                                    $eventDesc = "";
                                    $eventPrefix = "";
                                    $eventLink = "";
                                    $desc = "";
                                    if(isset($Podcast->event)){
                                        $eventPrefix = "Event :";
                                        $eventDesc = $Podcast->event->title;
                                    }else{
                                        $desc = $Podcast->description;
                                    } 

                                    if(!empty($eventDesc)){
                                        $eventId = $Podcast->event->id;
                                    ?>
                                    <small class="small-font" style="display:block;"><b>{{$eventPrefix}}</b><a target="_blank" href="{{url('org/events/'.$eventId)}}"> {{$eventDesc}}</a></small>
                                    <?php } else { ?>
                                    <small class="small-font" style="display:block;">{{$desc}}</small>
                                    <?php } ?>
                                    <?php
                                    if($Podcast->file_size != ''){
                                        $DisplaySize=formatBytes($Podcast->file_size);  ?>
                                        <h7 class="">File Size :  <?php echo $DisplaySize; ?></h7>
                                   <?php } 
                                  ?>
                                </div>

                                <i title="Edit Podcast" aria-hidden="true" class="fa fa-edit mt-1 clickable" style="font-size: 25px;float: right;" onclick="window.location='{{ url("org/podcasts/$Podcast->id") }}'"></i>

                                  <i title="Remove Podcast" onclick="deletePodcast(this);" aria-hidden="true" class="fa fa-trash ml-1 mt-1 clickable" style="font-size: 25px;float: right;" db-delete-id="{{$Podcast->id}}"></i>

                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <div class="card-footer text-center bg-transparent border-0">
                    <a href="{{url('org/podcasts')}}">View all Podcasts</a>
                </div>

            </div>
        </div>
        <?php 
                            function formatBytes($size, $precision = 2)
                            {
                                $base = log($size, 1024);
                                $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');   
                                    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
                            } ?>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('/js/VideoAndPodcast.js')}}" type="text/javascript"></script>
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<!-- <script>
    $(document).ready(function() {
        $('.dragFileForm input').change(function() {
            $('.dragFileForm p').text(this.files.length + " file(s) selected");
        });
        UploadPodcastVideoBox();
        showHideLinkEvent();
    });
</script> -->

<script>
    (function () {

        var bar = $('.bar_upload');
        var percent = $('.percent_upload');
        //var status = $('#status');

        $('.dragFileForm').ajaxForm({
            beforeSend: function () {
                var url = $("#input_url").val();
                // regexp =  /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
                var validExtensions = ['mp3','m4a','wma']; //array of valid extensions
                var fileName = $("#input_podfile").val();
                var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
                // if (regexp.test(url) || $.inArray(fileNameExt, validExtensions) != -1)
                if ((url != '' || $.inArray(fileNameExt, validExtensions) != -1) && (!$(".checkPodcastExist").hasClass('d-none')))
                {
                    $('.podcastFileError').text('');
                    $('.dragFileForm').find('.podcastProgressBar').removeClass('d-none');
                    //status.empty();
                    var percentVal = '0%';
                    //var posterValue = $('input[name=input_vidfile]').fieldValue();
                    bar.width(percentVal)
                    percent.html(percentVal);
                }
                else
                {
                    if(url != ''){
                        // $('.urlError').text('The input url format is invalid.');
                        // return false;
                        
                    } else{
                        alert("The podcast video file must be a file of type: mpga, m4a, wma.");
                        $('.podcastFileError').text('The podcast video file must be a file of type: mpga, m4a, wma.');
                        clearInterval(auto_refresh);
                        // return false;
                    }
                    // $('.urlError').text('The input url format is invalid.');
                    // return;
                }
                // $('.dragFileForm').find('.podcastProgressBar').removeClass('d-none');
                // //status.empty();
                // var percentVal = '0%';
                // // var posterValue = $('input[name=input_podfile]').fieldValue();
                // bar.width(percentVal)
                // percent.html(percentVal);                
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
                if(!$('.dragFileForm').find('.podcastProgressBar').hasClass('d-none')){
                if (percentComplete == 100) {
                                                    LoaderStart();
                                                    var interval = setInterval(function mak() {
                                                        clearInterval(interval);
                                                        window.location.href = $('#hdnRedirect').val();
                                                        LoaderStop();
                                                    }, 5000);
                // LoaderStart();
            }
        } else if(!$("#ChangePodcastBtn").hasClass('d-none')){
                                                LoaderStart();
                                                window.location.href = $('#hdnRedirect').val();
                                                        LoaderStop();
                                            }
                                            else{
                                                
                                            }
            },
            // success: function () {
            //     LoaderStop();
            //     var percentVal = 'Redirecting..';
            //     bar.width(percentVal);
            //     percent.html(percentVal);
            // },
            // complete: function (xhr) {
            //     //status.html(xhr.responseText);
            //     //alert('Uploaded Successfully');

            //     window.location.href = $('#hdnRedirect').val();
            // }
        });

    })();
</script>
@endsection