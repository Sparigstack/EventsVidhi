@extends('layouts.appOrg')
@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> Upcoming Events
                        <button id="" class="btn m-1 pull-right" style="border:1px solid transparent;"><a href="{{url("org/events/new")}}">Add New Event</a></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Title</th>
                                        <th class="max-w-table-date">Date & Time</th>
                                        <th>Category</th>                                        
<!--                                        <th>Location</th>-->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $event) {
                                        ?>
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
                                                <a onclick="window.location='{{ url("org/events/$event->id,1") }}'"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-file-video-o"></i></a> 
                                            </td>
                                        </tr>
                                    <?php }  ?>

                                    <td><?php
                                        $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                        if (!empty($event->thumbnail)) {
                                            $logoUrl = $AwsUrl . $event->thumbnail;
                                        }
                                        ?><img style="max-width: 75px;" title="Event Logo" src="{{$logoUrl}}" </td>
                                        <?php
                                        $titleClass = "";
                                        $draftWord = "(Draft)";
                                        if ($event->is_live == 1) {
                                            $titleClass = "greenFont";
                                            $draftWord = "";
                                        }
                                        ?>
                                    <td class="{{$titleClass}}">{{$event->title}}{{$draftWord}} </td>

                                    <?php
                                    $dateStr = "";

                                    $sdStamp = strtotime($event->date_time);
                                    $sd = date("d M, yy", $sdStamp);
                                    $st = date('H:i A', $sdStamp);

                                    $edStamp = strtotime($event->end_date_time);
                                    $ed = date("d M, yy", $edStamp);
                                    $et = date('H:i A', $edStamp);
                                    if ($sd == $ed) {
                                        $dateStr = date("d M, yy", $sdStamp) . ' ' . $st . ' to ' . $et;
                                    } else {
                                        $dateStr = date("d M, yy", $sdStamp) . ' ' . $st . ' to ' . date("d M, yy", $edStamp) . ' ' . $et;
                                    }
                                    ?>
                                    <td class="max-w-table-date">{{$dateStr}}</td>
                                    <td>{{$event->category->name}}</td>
    <!--                                    <td><?php
//                                        if ($event->is_online) {
//                                            echo "Online";
//                                        } else {
//                                            echo $event->address . ', ' . $event->city->name;
//                                        }
                                    ?></td>-->
                                    <td>
                                        <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" onclick="window.location ='{{ url("org/events/$event->id") }}'"></i>
                                        <a onclick="deleteEvent(this);" db-delete-id="{{$event->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash"></i></a> 
                                        <a onclick="window.location ='{{ url("org/events/$event->id") }}'" db-delete-id="{{$event->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-file-video-o"></i></a> 
                                    </td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Title</th>
                                        <th class="max-w-table-date">Date & Time</th>
                                        <th>Category</th>

<!--                                        <th>Location</th>-->
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
