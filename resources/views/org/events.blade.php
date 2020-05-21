@extends('layouts.appOrg')
@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container-fluid">
    <input type="text" class="PostUrl d-none" value="{{url("org/events/update")}}"/>
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> Upcoming Events
                        <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/events/new")}}">Add New Event</a></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Title</th>
                                        <th class="max-w-table-100">Date & Time</th>
                                        <th>Category</th>
                                        <th class="max-w-table-100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $event) {
                                        ?>
                                        <tr class="parent">
                                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden" class="deleteEvent" value="{{url('deleteEvent')}}">
                                    <?php
                                    $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                    if (!empty($event->thumbnail)) {
                                        $logoUrl = $AwsUrl . $event->thumbnail;
                                    }
                                    ?>
                                    <td><img style="max-width: 75px;" title="Event Logo" src="{{$logoUrl}}" </td> <?php
                                    $titleClass = "";
                                    $draftWord = "(Draft)";
                                    if ($event->is_live == 1) {
                                        $titleClass = "greenFont";
                                        $draftWord = "";
                                    }
                                    ?> <td class="{{$titleClass}}">{{$event->title}}{{$draftWord}} </td>

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
                                    <td class="max-w-table-100">{{$dateStr}}</td>
                                    <td>
                                        {{$event->category->name}}
                                    </td>
                                    <td class="max-w-table-100 text-center p-1 align-middle">
                                        <button  onclick="window.location ='{{ url("org/events/$event->id") }}'" type="button" class="btn btn-outline-success waves-effect waves-light secondary "> Edit </button>
                                        <button onclick="deleteEvent(this);" db-delete-id="{{$event->id}}"type="button" class="btn btn-outline-danger waves-effect waves-light secondary"> Delete </button>

                                        <?php if ($event->is_live != 0) { ?>
                                            <button type="button" onclick="UpdateEventStatus(this);" data-id="{{$event->id}}" status={{$event->is_live}} class="btn btn-outline-primary waves-effect waves-light secondary pauseButton"> Pause </button>
                                            <button type="button" onclick="UpdateEventStatus(this);" data-id="{{$event->id}}" status='3'  class="btn btn-outline-warning waves-effect waves-light secondary cancelButton"> Cancel </button>
                                        <?php } ?>



                                    </td>

                                    </tr>


                                    <?php
                                }
                                ?>


                                </tbody>

                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Title</th>
                                        <th class="max-w-table-100">Date & Time</th>
                                        <th>Category</th>
                                        <th class="max-w-table-100">Action</th>
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