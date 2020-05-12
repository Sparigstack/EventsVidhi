@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Upcoming Events</div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Time</th>
                                        <th>Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($user->events as $event) { 
                                        if($event->date_time >= date('Y-m-d',strtotime(now()))){ ?>
                                        <tr class="parent">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden"  class="deleteEvent" value="{{url('deleteEvent')}}">
                                            <td>{{$event->title}} </td>
                                            <td>{{$event->category->name}}</td>
                                            <td>{{$event->date_time}}</td>
                                            <td><?php
                                                if ($event->is_online) {
                                                    echo "Online";
                                                } else {
                                                    echo $event->address . ', ' . $event->city->name;
                                                }
                                                ?></td>
                                            <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" onclick="window.location='{{ url("org/events/$event->id") }}'"></i>
                                                <a onclick="deleteEvent(this);" db-delete-id="{{$event->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash"></i></a> 
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Time</th>
                                        <th>Location</th>
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

<<<<<<< HEAD
=======
@section('script')
<script>
    $(document).ready(function() {
        //Default data table
        $('#default-datatable').DataTable({
            ordering: false
        });
    });
</script>

@endsection
>>>>>>> 55c34f621b0a96a29b3ddc452497f424dd3e193f
