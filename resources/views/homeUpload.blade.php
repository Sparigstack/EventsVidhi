@extends('layouts.app')

@section('content')
<div class="container">
    <?php $ActionCall = url('home/store'); ?>
    <!--    <form class="dragFileForm" action="{{$ActionCall}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class='parent' style='width: 100%;'>
                <div class='form-group  uploadVideoBox'>
                    <label for='userFile'>Upload Video</label>
                    <div class='dragFileContainer'>
                        <input type="file" id='input_vidfile' name='userFile' value="{{  old('userFile') }}">
                        <p>Drag your video file here or click in this area.</p>
                    </div>
                    <small class="text-danger">{{ $errors->first('userFile') }}</small>
                </div>
            </div>
    
    
            <button class="btn btn-primary px-5 pull-right" type="submit">Save Video</button>
        </form>-->

    <div id="uploader">
        <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
    </div>
</div>
@endsection

