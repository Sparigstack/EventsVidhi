@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $CardTitle = "Add New Podcast";
    $ActionCall = url('org/podcasts/store');
    $title = "";
    $desription = "";
    $podcastVideoEventId = 0;
    $linkedEventCheckced = "";

    if (!empty($podcast)) {
        $ActionCall = url('org/podcasts/edit/' . $podcast->id);
        $CardTitle = "Edit Podcast";
        $title = $podcast->title;
        $desription = $podcast->url;
        
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

                    <form class="dragFileForm" action="{{$ActionCall}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class='form-group'>
                            <label for='input_title'>Podcast Title</label>
                            <input type="text" class="form-control" id="input_title" name='input_title' value="{{  old('input_title', $title) }}" placeholder="Enter Podcast Title" required>
                        </div>
                        <div class='form-group'>
                            <label for='input_url'>Podcast URL</label>
                            <input type="text" class="form-control" id="input_url" name="input_url"  value="{{  old('input_url', $desription) }}" placeholder="Enter Podcast URL" required>
                        </div>

                        <div class="form-group">
                                <label for="BlankLabel"></label>
                                <div class="icheck-material-primary">
                                    <input onclick="UploadPodcastVideoBox()" type="checkbox" id="IsUploadVideo" name="IsUploadVideo" @if(old('IsUploadVideo')) checked @endif>
                                    <label for="IsUploadVideo">Or upload podcast</label>
                                </div>
                            </div>

                        <div class='parent' style='width: 100%;'>
                            <div class='form-group  d-none uploadPodcastBox'>
                                <label for='input_podfile'>Upload Podcast</label>
                                <div class='dragFileContainer'>
                                    <input type="file" id='input_podfile' name='input_podfile' multiple value="{{  old('input_podfile') }}" >
                                    <p>Drag your podcast here or click to upload</p>
                                </div>
                                <small class="text-danger">{{ $errors->first('input_podfile') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="BlankLabel"></label>
                                <input type="hidden" class="linkedEvent" name="linkedEvent" value="">
                                <div class="icheck-material-primary">
                                    <input onchange='showHideLinkEvent(this);' type="checkbox" id="IsLinkedEvent" name="IsLinkedEvent" @if(old('IsLinkedEvent', $linkedEventCheckced)) checked @endif>
                                    <label for="IsLinkedEvent"> Do you want to link this podcast with any Event?</label>
                                </div>
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
                        </div>


                        <button class="btn btn-primary px-5 pull-right" type="submit">Save Podcast</button>
                    </form>

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
                <div class="card-header">Recently Added Videos
                    <div class="card-action">
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
                    </div>
                </div>

                <ul class="list-group list-group-flush shadow-none">
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$810,000 . 04 Beds . 03 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$2,560,000 . 08 Beds . 07 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$910,300 . 03 Beds . 02 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$1,140,650 . 06 Beds . 03 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$1,140,650 . 06 Beds . 03 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$910,300 . 03 Beds . 02 Baths</small>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="card-footer text-center bg-transparent border-0">
                    <a href="javascript:void();">View all Videos</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('/js/customScript.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.dragFileForm input').change(function() {
            $('.dragFileForm p').text(this.files.length + " file(s) selected");
        });
        UploadPodcastVideoBox();
        showHideLinkEvent();
    });
</script>
@endsection