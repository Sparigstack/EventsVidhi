@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php

    use App\Video;

$CardTitle = "Add New Video";
    $ActionCall = url('org/videos/store');
    $RedirectCall = url('org/videos');
    $title = "";
    $desription = "";
    $videoEventId = 0;
    $linkedEventCheckced = "";
    $videoDescription = "";

    if (!empty($video)) {
        $ActionCall = url('org/videos/edit/' . $video->id);
        $CardTitle = "Edit Video";
        $title = $video->title;
        $desription = $video->url;
        if (isset($video->description)) {
            $videoDescription = $video->description;
        }
        // $desription = $video->description;
        // if (!empty($video->desription)) {
        //     $desription = $video->desription;
        // }
        if (isset($video->event)) {
            $linkedEventCheckced = "checked";
            // $desription = $video->url;
            // $desription = "Event:".$video->event->title;
        } else {
            // $desription = $video->url;
            // $desription = $video->description;
        }
        if (!empty($video->event_id)) {
            $videoEventId = $video->event_id;
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
                            <label for='input_title'>Video Title</label>
                            <input type="text" class="form-control" id="input_title" name='input_title' value="{{  old('input_title', $title) }}" placeholder="Enter Video Title" required>
                        </div>
                        <hr class="mt-5 mb-5">
                        <div class="form-group">
                            <label for="BlankLabel"></label>
                            <input type="hidden" class="linkedEvent" name="linkedEvent" value="">
                            <label> Do you want to link this video with any Event?</label>
                            <div class="row pl-3">
                                <div class="icheck-material-primary">
                                    <input onchange='showHideLinkEvent(this);' type="radio" class="" id="yesEventLinked" name="IsLinkedEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif>
                                           <label for="yesEventLinked">Yes</label>
                                </div>
                                <div class="icheck-material-primary pl-2">
                                    <?php
                                    $checkedRadio = "checked";
                                    if ($videoEventId != 0) {
                                        $checkedRadio = "";
                                    }
                                    ?>
                                    <input onchange='showHideLinkEvent(this);' type="radio" id="noEventLinked" name="IsLinkedEvent" {{$checkedRadio}}>
                                    <label for="noEventLinked">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group descriptionDiv">
                            <p for="Description">Video Description</p>
                            <textarea id="Description" name="Description" class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4">{{ old('Description', $videoDescription) }}</textarea>
                        </div>
                        <div id='linkEvent' class="form-group EventSelectionBox d-none">
                            <!-- <label for="EventToLink mb-0">Link To Event</label> -->
                            <select autocomplete="off" value="" name="EventToLink" id="EventToLink" class="custom-select">
                                <option value="">Select Event To Link</option>
                                <?php
                                foreach ($events as $event) {
                                    $IsSelected = "";
                                    if (!empty($video)) {
                                        if ($event->id == $videoEventId) {
                                            $IsSelected = "selected";
                                        }
                                    }
                                    //                                        $IsSelected = "";
                                    //                                        if ($event->id == $eventId) {
                                    //                                            $IsSelected = "selected";
                                    //                                        }
                                    ?>
                                    <option value="{{$event->id}}" {{$IsSelected}} @if (old('EventToLink')==$event->id) selected="selected" @endif ><?php echo $event->title; ?> </option>
                                <?php } ?>

                            </select>
                        </div>
                        <hr class="mt-5 mb-5">

                        <div class='form-group iframeVideoDiv'>
                            <?php
                                $AwsUrl = env('AWS_URL');
                                $videoUrl = "";
                                $dnoneClass = "";
                                if (!empty($video)) {
                                    $dnoneClass = "d-none";
                                    if($video->url_type == 1){
                                        $videoUrl = $AwsUrl . $video->url; ?>
                                        <a href="{{$videoUrl}}" target="_blank"><video class="videoIframeFile" src="{{$videoUrl}}"></video></a>
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
                                                <a href="{{$url}}" target="_blank" class="videoIframe"><iframe src="{{$url}}"></iframe></a>
                                            <?php  } ?>
                                            <?php 
                                            $dNoneClassVideo = "d-none";
                                            if(!empty($video->url)){
                                                $dNoneClassVideo = '';
                                            }
                                            ?>
                                                <div class="changeVideo {{$dNoneClassVideo}}"><a type="button" id="ChangeVideoBtn">Change Video</a></div>
                                     <?php   }
                                    ?>
                        </div>

                        <div class="form-group {{$dnoneClass}} checkVideoExist">
                            <label> You can either save your Youtube or Vimeo video URL OR you can upload your own video.</label>
                        </div>
                        

                        <div class='form-group {{$dnoneClass}} checkVideoExist'>
                            <p for='input_url' class="float-left">Video URL</p><span style="font-size: 11px;font-weight: 600;">&nbsp;&nbsp;(YouTube or Vimeo url)</span>
                            <input type="text" class="form-control" id="input_url" onkeyup="videoUrlCheck(this);" onchange="videoUrlCheck(this);" name="input_url" value="{{  old('input_url', $desription) }}" placeholder="Enter Video URL" required>
                            <small class="text-danger urlError">{{ $errors->first('input_url') }}</small>
                        </div>

                        <div class="form-group {{$dnoneClass}} checkVideoExist">
                            <div class="icheck-material-primary">
                                <input onclick="UploadVideoBoxVideoCon(this);" type="checkbox" id="IsUploadVideo" name="IsUploadVideo" @if(old('IsUploadVideo')) checked @endif>
                                       <label for="IsUploadVideo">Or upload your own video</label>
                            </div>
                        </div>

                        <div class='parent' style='width: 100%;'>
                            <div class='form-group  d-none uploadVideoBox'>
                                <p for='input_vidfile'>Select Video</p>
                                <div class='dragFileContainer'>
                                    <input type="file" id='input_vidfile' name='input_vidfile' value="{{  old('input_vidfile') }}">
                                    <p class="dragFileText">Drag your video file here or click in this area.</p>
                                </div>
                                <small class="text-danger videoFileError"></small>
                                <!-- <small class="text-danger">{{ $errors->first('input_vidfile') }}</small> -->
                            </div>
                            <div class="form-group progressBar d-none">
                                <div class="progress_upload">
                                    <div class="bar_upload"></div>
                                    <div class="percent_upload">0%</div>
                                </div>
                            </div>
                            <!-- <div class="form-group"> -->
                            <!-- <label for="BlankLabel"></label>
                             <input type="hidden" class="linkedEvent" name="linkedEvent" value=""> -->
                            <!-- <div class="icheck-material-primary"> -->
                            <!-- <input onchange='showHideLinkEvent(this);' type="checkbox" id="IsLinkedEvent" name="IsLinkedEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif> -->

                            <!-- <input onchange='showHideLinkEvent(this);' type="radio" id="IsLinkedEvent" name="IsLinkedEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif> Yes
                                    <input onchange='showHideLinkEvent(this);' type="radio" id="noEvent" name="noEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif> No -->

                            <!-- <label for="IsLinkedEvent"> Do you want to link this video with any Event?</label> -->
                            <!-- </div> -->

                            <!-- </div> -->


                        </div>
                        <?php
                        $showButton = "d-none";
                        if($desription != ""){
                            $showButton = "";
                        }
                        ?>
                        <!-- <button id="btnCancelVideo" class="d-none btn btn-light px-5 float-left" type="submit">Cancel</button> -->
                        <button id="btnSaveVideo" class="{{$showButton}} btn btn-primary px-5 pull-right" type="submit">Save Video</button>
                    </form>

                    <a href="{{url('org/videos')}}"><button id="btnCancelVideo" class="{{$showButton}} btn btn-light float-left">Cancel</button></a>

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
                <div class="card-header listItemsBottomBorder border-bottom-0">Recently Added Videos
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
                    <?php foreach ($RecentVideos as $Video) { ?>
                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input type="hidden"  class="deleteVideo" value="{{url('deleteVideo')}}">
                        <li class="list-group-item listItemsBottomBorder parent">
                            <div class="media align-items-center">
                                <?php
                                    $AwsUrl = env('AWS_URL');
                                        $videoUrl = "";
                                        if (!empty($Video->url)) {
                                            if($Video->url_type == 1){
                                                $videoUrl = $AwsUrl . $Video->url; ?>
                                                <a href="{{$videoUrl}}" target="_blank"><video class="" src="{{$videoUrl}}" width="100px" height="100px"></video></a>
                                         <?php   }
                                            else{
                                                $videoUrl = $Video->url;
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
                                                <a href="{{$url}}" target="_blank"><iframe width="100" height="70" src="{{$url}}"></iframe></a>
                                          <?php  }
                                        }
                                ?>
                                    
                                <!-- <a href="{{$videoUrl}}" target="_blank"><img src="{{asset('assets/images/video-icon.png')}}" alt="user avatar" class="customer-img rounded"></a> -->

                                

                                <div class="media-body ml-3">
                                    <h6 class="mb-0">{{$Video->title}}</h6>
                                    <?php 
                                    $eventDesc = "";
                                    $eventPrefix = "";
                                    $eventLink = "";
                                    $desc = "";
                                    if(isset($Video->event)){
                                        $eventPrefix = "Event :";
                                        $eventDesc = $Video->event->title;
                                    }else{
                                        $desc = $Video->description;
                                    } 

                                    if(!empty($eventDesc)){
                                        $eventId = $Video->event->id;
                                    ?>
                                    <small class="small-font" style="display:block;"><b>{{$eventPrefix}}</b><a target="_blank" href="{{url('org/events/'.$eventId)}}"> {{$eventDesc}}</a></small>
                                    <?php } else { ?>
                                    <small class="small-font" style="display:block;">{{$desc}}</small>
                                    <?php } ?>
                                    
                                    <?php
                                    if($Video->file_size != ''){
                                        $DisplaySize=formatBytes($Video->file_size);  ?>
                                        <h7 class="">File Size :  <?php echo $DisplaySize; ?></h7>
                                   <?php } 
                                  ?>

    <i title="Remove Video" onclick="deleteVideo(this);" aria-hidden="true" class="fa fa-trash ml-2 mt-1 clickable" style="font-size: 25px;float: right;" db-delete-id="{{$Video->id}}"></i>
    <i title="Edit Video" aria-hidden="true" class="fa fa-edit ml-3 mt-1 clickable" style="font-size: 25px;float: right;" onclick="window.location='{{ url("org/videos/$Video->id") }}'"></i>
                                </div>

                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <div class="card-footer text-center bg-transparent border-0">
                    <a href="{{url('org/videos')}}">View all Videos</a>
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
</div>
@endsection

@section('script')
<script src="{{asset('/js/VideoAndPodcast.js')}}" type="text/javascript"></script>
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script>
(function () {

                                        var bar = $('.bar_upload');
                                        var percent = $('.percent_upload');
                                        //var status = $('#status');

                                        $('.dragFileForm').ajaxForm({
                                            beforeSend: function () {
                                                var url = $("#input_url").val();
                                                // regexp =  /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
                                                // regexp =  /https:\/\/(?:www.)?(?:(vimeo).com\/(.*)|(youtube).com\/watch\?v=(.*?)&)/;
                                                regexp = /^(http:\/\/|https:\/\/)(vimeo\.com|youtu\.be|www\.youtube\.com)\/([\w\/]+)([\?].*)?$/;
                                                // if(url.match(regexp)){
                                                //     $('.urlError').text('The input url format is invalid.');
                                                //         return false;
                                                // }
                                                
                                                var validExtensions = ['mov','mp4','wmv','flv','avi']; //array of valid extensions
        var fileName = $("#input_vidfile").val();
        var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
                                                // if (regexp.test(url) || $.inArray(fileNameExt, validExtensions) != -1)
                                                // {
                                                    if (url.match(regexp) || $.inArray(fileNameExt, validExtensions) != -1)
                                                    {
                                                    $('.dragFileForm').find('.progressBar').removeClass('d-none');
                                                    //status.empty();
                                                    var percentVal = '0%';
                                                    //var posterValue = $('input[name=input_vidfile]').fieldValue();
                                                    bar.width(percentVal)
                                                    percent.html(percentVal);
                                                }
                                                else
                                                {
                                                    if(url != ''){
                                                        $('.urlError').text('The input url format is invalid.');
                                                        return false;
                                                    } 
                                                    else{
                                                        $('.videoFileError').text('The video file must be a file of type: mov, mp4, wmv, flv, avi.');
                                                        return false;
                                                    }
                                                    
                                                }

                                                // $('.dragFileForm').find('.progressBar').removeClass('d-none');
                                                // //status.empty();
                                                // var percentVal = '0%';
                                                // //var posterValue = $('input[name=input_vidfile]').fieldValue();
                                                // bar.width(percentVal)
                                                // percent.html(percentVal);
                                            },
                                            uploadProgress: function (event, position, total, percentComplete) {
                                                //$('.dragFileForm').find('.progressBar').removeClass('d-none');
                                                var percentVal = percentComplete + '%';
                                                bar.width(percentVal);
                                                percent.html(percentVal);
                                                if(!$('.dragFileForm').find('.progressBar').hasClass('d-none')){
                                                if (percentComplete == 100) {
                                                    LoaderStart();
                                                    var interval = setInterval(function mak() {
                                                        clearInterval(interval);
                                                        window.location.href = $('#hdnRedirect').val();
                                                        LoaderStop();
                                                    }, 5000);
                                                    // window.location.href = $('#hdnRedirect').val();
                                                }
                                            }
                                                // LoaderStart();
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