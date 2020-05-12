@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Upcoming Events</div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                    <?php foreach ($user->events as $event) { ?>
                                        <tr>

                                            <td>{{$event->title}} </td>
                                            <td>{{$event->category->name}}</td>
                                            <td>{{$event->date_time}}</td>
                                            <td><?php
                                                if ($event->is_online) {
                                                    echo "online";
                                                } else {
                                                    echo $event->address . ', ' . $event->city->name;
                                                }
                                                ?></td>
                                            <td><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit"></i> <i  style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash"></i> </td>
                                        </tr>
<?php } ?>

                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Time</th>
                                        <th>Location</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>    
</div>

@endsection
