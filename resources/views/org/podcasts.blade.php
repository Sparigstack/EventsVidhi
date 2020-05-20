@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                       <i class="fa fa-table pt-3"></i> All Podcasts
                        <!-- <button id="" class="btn m-1 pull-right" style="border:1px solid transparent;"><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable-podcasts" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Podcast URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($podcasts as $podcast) { 
                                         ?>
                                        <tr class="parent">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden"  class="deletePodcast" value="{{url('deletePodcast')}}">
                                            <td>{{$podcast->title}} </td>
                                            <?php $eventDesc = "";
                                            if(isset($podcast->event)){
                                                $eventDesc = "Event:".$podcast->event->title;
                                            }else{
                                                $eventDesc = $podcast->description;
                                            } ?>
                                            <td>{{$eventDesc}}</td>
                                            <td>{{$podcast->url}}</td>
                                            <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" onclick="window.location='{{ url("org/podcasts/".$podcast->id) }}'"></i>
                                                <a onclick="deletePodcast(this);" db-delete-id="{{$podcast->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash"></i></a> 
                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Podcast URL</th>
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
