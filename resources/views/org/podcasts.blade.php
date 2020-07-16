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
                       <i class="fa fa-table pt-3"></i> All Podcasts
                       <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/podcasts/new")}}">Add New Podcast</a></button>
                        <!-- <button id="" class="btn m-1 pull-right" style="border:1px solid transparent;"><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable-podcasts" class="table" style="border-collapse: collapse !important;">
                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th width="42.5%" style="border-right:unset !important;">Title</th>
                                        <!-- <th width="42.5%" style="border-right:unset !important;">Description</th> -->
                                        <!-- <th class="max-w-table-200">Podcast URL</th> -->
                                        <th width="42.5%" style="border-right:unset !important;">Date & Time</th>
                                        <th width="42.5%" style="border-right:unset !important;">Event</th>
                                        <th width="42.5%" style="border-right:unset !important;">Size</th>
                                        <th width="15%" style="border-right:unset !important;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($podcasts as $podcast) {
                                        $AwsUrl = env('AWS_URL');
                                        $videoPodcastUrl = "";
                                        if (!empty($podcast->url)) {
                                            if(substr( $podcast->url, 0, 8 ) != "https://"){
                                                $videoPodcastUrl = $AwsUrl . $podcast->url;
                                            }
                                            else{
                                                $videoPodcastUrl = $podcast->url;
                                            }
                                        }
                                        $backColor = "";
                                        if(isset($podcast->event)){
                                            $backColor = "eventLinkedBg";
                                        }
                                         ?>
                                        <tr class="parent {{$backColor}}">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden"  class="deletePodcast" value="{{url('deletePodcast')}}">
                                            <td>{{$podcast->title}} </td>
                                            <td>
                                            <?php
                                                $dateStr = "";

                                            $sdStamp = strtotime($podcast->created_at);
                                            // $sd = date("d M, yy", $sdStamp);
                                            $st = date('H:i A', $sdStamp);
                                    
                                            $dateStr = date("m/d/Y", $sdStamp) . ' ' . $st ;
                                            ?>
                                                {{$dateStr}} 
                                            </td>
                                            <?php $eventDesc = "";
                                            $eventPrefix = "";
                                            $eventLink = "";
                                            $desc = "";
                                            if(isset($podcast->event)){
                                                $eventPrefix = "Event :";
                                                $eventDesc = $podcast->event->title;
                                            }else{
                                                // $desc = $podcast->description;
                                            } ?>
                                            <td>
                                                <?php if(!empty($eventDesc)){
                                                    $eventId = $podcast->event->id;
                                                    ?>
                                                <b>{{$eventPrefix}}</b><a target="_blank" href="{{url('org/events/'.$eventId)}}"> {{$eventDesc}}</a>
                                                <?php
                                                } else { ?>
                                                    <!-- {{$desc}} -->
                                                <?php } ?>
                                                </td>
                                            <!-- <td>{{$podcast->url}}</td> -->
                                            <!-- <td class="max-w-table-200">{{$videoPodcastUrl}}</td> -->
                                            <td>
                                                <?php 
                                                if($podcast->file_size != ''){
                                                    $DisplaySize=formatBytes($podcast->file_size); 
                                                    echo $DisplaySize;
                                                } 
                                                ?>
                                            </td>
                                            <td class="pt-4">
                                        <div class="card-action float-none">
                                            <div class="dropdown">
                                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" title="View More Actions">
                                                <i class="icon-options"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right topPosition">

                                                    <a class="dropdown-item backColorDropdownItem" href="{{ url("org/podcasts/$podcast->id") }}"> Edit </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="deletePodcast(this);" db-delete-id="{{$podcast->id}}"> Delete </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                            <!-- <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" title="Edit Podcast" onclick="window.location='{{ url("org/podcasts/".$podcast->id) }}'"></i>
                                                <a onclick="deletePodcast(this);" db-delete-id="{{$podcast->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Podcast"></i></a>
                                                <a href="{{$videoPodcastUrl}}" target="_blank"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;color:black;" class="fa fa-file-video-o" title="View Podcast"></i></a> 
                                            </td> -->
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <!-- <thead>
                                    <tr>
                                        <th width="42.5%">Title</th>
                                        <th width="42.5%">Description</th> -->
                                        <!-- <th class="max-w-table-200">Podcast URL</th> -->
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