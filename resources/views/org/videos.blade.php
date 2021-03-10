@extends('layouts.appOrg')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
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
                            <!-- <table id="default-datatable-videos" class="table table-bordered"> -->
                                <table id="default-datatable-videos" class="table" style="border-collapse: collapse !important;">
                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th width="42.5%" style="border-right:unset !important;">Icon</th>
                                        <th width="42.5%" style="border-right:unset !important;">Title</th>
                                        <th width="42.5%" style="border-right:unset !important;">Date & Time</th>
                                        <th width="42.5%" style="border-right:unset !important;">Event</th>
                                        <th width="42.5%" style="border-right:unset !important;">Size</th>
                                        <!-- <th class="max-w-table-200">Video URL</th> -->
                                        <!-- <th>Location</th> -->
                                        <th width="15%" style="border-right:unset !important;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $AwsUrl = env('AWS_URL');
                                    foreach ($videos as $video) {
                                        $videoUrl = "";
                                        if (!empty($video->url)) {
                                            if(substr($video->url, 0, 8 ) != "https://"){
                                                $videoUrl = $AwsUrl . $video->url;
                                            }
                                            else{
                                                $videoUrl = $video->url;
                                            }
                                        }
                                        $backColor = "";
                                        if(isset($video->event)){
                                            $backColor = "eventLinkedBg";
                                        }
                                         ?>
                                        <tr class="parent {{$backColor}}">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                            <input type="hidden"  class="deleteVideo" value="{{url('deleteVideo')}}">
                                            <td>
                                                <?php
                                                $AwsUrl = env('AWS_URL');
                                                $videoUrl = "";
                                                if (!empty($video->url)) {
                                                    if($video->url_type == 1){
                                                        $videoUrl = $AwsUrl . $video->url; ?>
                                                        <a href="{{$videoUrl}}" target="_blank"><video class="" src="{{$videoUrl}}" width="100px" height="100px"></video></a>
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
                                                <a href="{{$url}}" target="_blank"><iframe width="100" height="70" src="{{$url}}" style="pointer-events: none;"></iframe></a>
                                                <?php  }
                                            }
                                            ?>
                                            </td>
                                            <td>{{$video->title}} </td>
                                            <td>
                                                <?php
                                                $dateStr = "";

                                            $sdStamp = strtotime($video->created_at);
                                            // $sd = date("d M, yy", $sdStamp);
                                            $st = date('H:i A', $sdStamp);
                                    
                                            $dateStr = date("m/d/Y", $sdStamp) . ' ' . $st ;
                                            ?>
                                                {{$dateStr}} </td>
                                            <?php $eventDesc = "";
                                            $eventPrefix = "";
                                            $eventLink = "";
                                            $desc = "";
                                            if(isset($video->event)){
                                                $eventPrefix = "Event :";
                                                $eventDesc = $video->event->title;
                                            }
                                            else{
                                                // $desc = $video->description;
                                            } 
                                            ?>
                                            <td>
                                                <?php if(!empty($eventDesc)){
                                                    $eventId = $video->event->id;
                                                    ?>
                                                <b>{{$eventPrefix}}</b><a target="_blank" href="{{url('org/events/'.$eventId)}}"> {{$eventDesc}}</a>
                                                <?php
                                                } else { ?>
                                                    <!-- {{$desc}} -->
                                                <?php } ?>
                                                </td>
                                            <td>
                                                <?php 
                                                if($video->file_size != ''){
                                                    $DisplaySize=formatBytes($video->file_size); 
                                                    echo $DisplaySize;
                                                } 
                                                ?>
                                            </td>
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
                                            <!-- <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit"  title="Edit Video" onclick="window.location='{{ url("org/videos/$video->id") }}'"></i>
                                                <a onclick="deleteVideo(this);" db-delete-id="{{$video->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Video"></i></a>
                                                <a href="{{$videoUrl}}" target="_blank"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;color:black;" class="fa fa-file-video-o" title="View Video"></i></a> 
                                            </td> -->
                                            <td class="pt-4">
                                        <div class="card-action float-none">
                                            <div class="dropdown">
                                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" title="View More Actions">
                                                <i class="icon-options"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right topPosition">

                                                    <a class="dropdown-item backColorDropdownItem" href="{{ url("org/videos/$video->id") }}"> Edit </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="deleteVideo(this);" db-delete-id="{{$video->id}}"> Delete </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <!-- <thead>
                                    <tr>
                                        <th width="42.5%">Title</th>
                                        <th width="42.5%">Description</th> -->
                                        <!-- <th class="max-w-table-200">Video URL</th> -->
                                        <!-- <th>Location</th> -->
                                        <!-- <th width="15%">Action</th>
                                    </tr>
                                </thead> -->
                            </table>
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
            </div>
        </div>

    </div>
</div>

@endsection
@section('script')
<script src="{{asset('/js/VideoAndPodcast.js')}}" type="text/javascript"></script>
<!-- Data Tables -->
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
@endsection