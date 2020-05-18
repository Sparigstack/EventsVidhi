@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                       <i class="fa fa-table pt-3"></i> All Videos
                        <!-- <button id="" class="btn m-1 pull-right" style="border:1px solid transparent;"><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable-videos" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Event Title</th>
                                        <th>Video URL</th>
                                        <!-- <th>Location</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($videos as $video) { 
                                         ?>
                                        <tr class="parent">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden"  class="deleteEvent" value="{{url('deleteEvent')}}">
                                            <td>{{$video->title}} </td>
                                            <td></td>
                                            <td>{{$video->url}}</td>
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
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" onclick="window.location='{{ url("org/videos/$video->id") }}'"></i>
                                                <a onclick="deleteVideo(this);" db-delete-id="{{$video->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash"></i></a> 
                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Event Title</th>
                                        <th>Video URL</th>
                                        <!-- <th>Location</th> -->
                                        <th>Action</th>
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
