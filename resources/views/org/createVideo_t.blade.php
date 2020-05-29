@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $CardTitle = "Add New Video";
    $ActionCall = url('org/videos/store_demo');
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>testing upload demo</h5>
                    </div>
                    <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="dragFileForm_demo" action="{{$ActionCall}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class='parent' style='width: 100%;'>
                            <div class='form-group  uploadVideoBox'>
                                <label for='input_vidfile'>Upload Video</label>
                                <input type="file" id='vid_file' name='vid_file' value="{{  old('vid_file') }}">
                                <small class="text-danger">{{ $errors->first('vid_file') }}</small>
                            </div>
                        </div>
                        <button class="btn btn-primary px-5 pull-right" type="submit">Save Video</button>
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

    </div>
</div>
@endsection

@section('script')
<script src="{{asset('/js/VideoAndPodcast.js')}}" type="text/javascript"></script>


@endsection