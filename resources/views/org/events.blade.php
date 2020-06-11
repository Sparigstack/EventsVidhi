@extends('layouts.appOrg')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container-fluid">
    <input type="text" class="PostUrl d-none" value="{{url("org/events/update")}}"/>
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">

                <!-- Custom url popup -->
                <div class="modal fade" id="openCustomUrlPopup" style="display:none;padding:17px!important;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header pb-2 pt-3" style="font-size:25px;">
                                <label for="title">Set custom URL</label>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <!-- <div class="col-lg-12">
                                    <label for="title">Custom URL for Social Media</label>
                                </div> -->
                                <?php 
                                $CustomHumanReadableUrl = "";
                                $FinalUrl = "";  
                                ?>
                                <div class="col-lg-12 row">
                                    <div class="pt-2 pr-1">
                                        <!-- <span>{{env('APP_URL_Custom')}}</span> -->
                                        <p for="custom_url" style="font-weight: 300;">https://www.panelhive.com/</p>
                                        <!-- <span></span> -->
                                        <!-- <input type="text" class="form-control p-0 " style="border:none;" value="{{$CustomHumanReadableUrl}}" onkeyup="ChangeCustomUrl(this);" id="CustomUrl" name="CustomUrl" autocomplete="off"> -->
                                    </div>

                                    <div class="pl-0">
                                        <!-- <div class="form-group col-lg-12"> -->
                                            <input type="text" class="form-control " value="{{$CustomHumanReadableUrl}}" onkeyup="ChangeCustomUrl(this);" id="CustomUrl" name="CustomUrl" autocomplete="off">
                                        <!-- </div> -->
                                        
                                    </div>
                                </div>

                                    <div class="row form-group pl-3 pt-2">
                                        <!-- <div class="col-lg-10 p-1" id="HumanFriendlyUrl" data="{{env('APP_URL_Custom')}}"> -->
                                        <div class="col-lg-10 p-1" id="HumanFriendlyUrl" data="https://www.panelhive.com/...">
                                            Preview URL: https://www.panelhive.com/{{$FinalUrl}}

                                        </div>

                                    <div class="col-lg-2 pt-1">
                                        <a onclick="copyHumanFriendlyUrl(this);"><i style="cursor:pointer; margin-left:5px;font-size:20px;" class="fa fa-copy" title="Copy to Clipboard"></i></a>
                                    </div>

                                    <div class='copied'></div>

                                </div>

                                <?php if (!empty($CustomHumanReadableUrl)) { ?>
                                            <div class="pull-right">
                                                <a target="_blank" href="https://facebook.com"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-facebook-official" title=""></i></a>
                                                <a target="_blank" href="https://twitter.com/"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-twitter" title=""></i></a>
                                                <a target="_blank" href="https://www.linkedin.com/"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-linkedin" title=""></i></a>
                                            </div>
                                <?php    } ?>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Custom url popup -->

                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> Upcoming Events
                        <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/events/new")}}">Add New Event</a></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <!-- <table id="default-datatable" class="table table-bordered"> -->
                            <table id="default-datatable" class="table" style="border-collapse: collapse !important;">
                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th style="width:80px;">Logo</th>
                                        <th>Title</th>
                                        <!-- <th class="max-w-table-100">Date & Time</th> -->
                                        <th>Category</th>
                                        <th class="max-w-table-100"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $event) {
                                        ?>
                                        <tr class="parent">
                                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden" class="deleteEvent" value="{{url('deleteEvent')}}">
                                    <input type="hidden" class="copyEvent" value="{{url('copyEvent')}}">
                                    <?php
                                    $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                    if (!empty($event->thumbnail)) {
                                        $logoUrl = $AwsUrl . $event->thumbnail;
                                    }
                                    ?>
                                    <td><img class="speakerImgSize rounded" style="" title="Event Logo" src="{{$logoUrl}}" </td> <?php
                                    $titleClass = "";
                                    $draftWord = "(Draft)";
                                    if ($event->is_live == 1) {
                                        $titleClass = "greenFont";
                                        $draftWord = "";
                                    }
                                    ?>
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
                                     <td class="{{$titleClass}} pt-4">{{$event->title}}{{$draftWord}} <br> {{$dateStr}} </td>

                                    
                                    <!-- <td class="max-w-table-100">{{$dateStr}}</td> -->
                                    <td class="pt-4">
                                        {{$event->category->name}}
                                    </td>
                                    <!-- <td class="max-w-table-100 text-center p-1 align-middle">
                                        <button  onclick="window.location ='{{ url("org/events/$event->id") }}'" type="button" class="btn btn-outline-success waves-effect waves-light secondary "> Edit </button>
                                        <button onclick="deleteEvent(this);" db-delete-id="{{$event->id}}"type="button" class="btn btn-outline-danger waves-effect waves-light secondary"> Delete </button>
                                        <button onclick="copyEvent(this);" db-event-id="{{$event->id}}"type="button" class="btn btn-outline-success waves-effect waves-light secondary"> Copy </button>

                                        <?php if ($event->is_live != 0) { ?>
                                            <button type="button" onclick="UpdateEventStatus(this);" data-id="{{$event->id}}" status={{$event->is_live}} class="btn btn-outline-primary waves-effect waves-light secondary pauseButton"> Pause </button>
                                            <button type="button" onclick="UpdateEventStatus(this);" data-id="{{$event->id}}" status='3'  class="btn btn-outline-warning waves-effect waves-light secondary cancelButton"> Cancel </button>
                                        <?php } ?>



                                    </td> -->

                                    <td class="pt-4">
                                        <div class="card-action float-none">
                                            <div class="dropdown">
                                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" title="View More Actions">
                                                <i class="icon-options"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right topPosition">
                                                    <a class="dropdown-item backColorDropdownItem" href="{{ url("org/events/$event->id") }}"> Edit </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="deleteEvent(this);" db-delete-id="{{$event->id}}"> Delete </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="copyEvent(this);" db-event-id="{{$event->id}}"> Copy </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" data-toggle="modal" data-target="#openCustomUrlPopup"> Custom URL </a>

                                                    <?php if ($event->is_live != 0) { ?>
                                                    <a class="dropdown-item pauseButton backColorDropdownItem" href="javascript:void();" onclick="UpdateEventStatus(this);" data-id="{{$event->id}}" status='{{$event->is_live}}'> Pause </a>
                                                    <a class="dropdown-item backColorDropdownItem cancelButton" href="javascript:void();" onclick="UpdateEventStatus(this);" data-id="{{$event->id}}" status='3'> Cancel </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>


                            </tbody>

                                <!-- <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Title</th>
                                        <th class="max-w-table-100">Date & Time</th>
                                        <th>Category</th>
                                        <th class="max-w-table-100">Action</th>
                                    </tr>
                                </thead> -->
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
<script src="{{asset('/js/Events.js')}}" type="text/javascript"></script>
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
<script>
    $(document).ready(function () {
        var table = $('#default-datatable').DataTable({
            // columnDefs: [
            //     {orderable: false, targets: 4},
            // ],
            // bFilter: false,
                                                    ordering: false,

                                                    aoColumnDefs: [
                                                    {
                                                    bSortable: false,
                                                            aTargets: [3]
                                                    }
                                                    ],
                                                    // style_cell={'boxShadow': '0 0'},

        });
    });
</script>
@endsection