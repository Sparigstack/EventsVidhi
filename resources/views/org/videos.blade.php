@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                       <i class="fa fa-table pt-3"></i> All Videos
                       <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/videos/new")}}">Add New Video</a></button>
                        <!-- <button id="" class="btn m-1 pull-right" style="border:1px solid transparent;"><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable-videos" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="42.5%">Title</th>
                                        <th width="42.5%">Description</th>
                                        <!-- <th class="max-w-table-200">Video URL</th> -->
                                        <!-- <th>Location</th> -->
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($videos as $video) { 
                                        $AwsUrl = env('AWS_URL');
                                        $videoUrl = "";
                                        if (!empty($video->url)) {
                                            if(substr( $video->url, 0, 8 ) != "https://"){
                                                $videoUrl = $AwsUrl . $video->url;
                                            }
                                            else{
                                                $videoUrl = $video->url;
                                            }
                                        }
                                        $backColor = "";
                                        if(isset($video->event)){
                                            $backColor = "background-color:#f4f4f4;";
                                        }
                                         ?>
                                        <tr class="parent" style="{{$backColor}}">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden"  class="deleteVideo" value="{{url('deleteVideo')}}">
                                            <td>{{$video->title}} </td>
                                            <?php $eventDesc = "";
                                            if(isset($video->event)){
                                                $eventDesc = "Event:".$video->event->title;
                                            }else{
                                                $eventDesc = $video->description;
                                            } ?>
                                            <td>{{$eventDesc}}</td>
                                            <!-- <td>{{$video->url}}</td> -->
                                            <!-- <td class="max-w-table-200">{{$videoUrl}}</td> -->
                                            <!-- <td> -->
                                                <?php
                                                // if ($event->is_online) {
                                                //     echo "Online";
                                                // } else {
                                                //     echo $event->address . ', ' . $event->city->name;
                                                // }
                                                ?>
                                            <!-- </td> -->
                                            <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit"  title="Edit Video" onclick="window.location='{{ url("org/videos/$video->id") }}'"></i>
                                                <a onclick="deleteVideo(this);" db-delete-id="{{$video->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Video"></i></a>
                                                <a href="{{$videoUrl}}" target="_blank"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;color:black;" class="fa fa-file-video-o" title="View Video"></i></a> 
                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th width="42.5%">Title</th>
                                        <th width="42.5%">Description</th>
                                        <!-- <th class="max-w-table-200">Video URL</th> -->
                                        <!-- <th>Location</th> -->
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('script')
<script src="{{asset('/js/VideoAndPodcast.js')}}" type="text/javascript"></script>
@endsection