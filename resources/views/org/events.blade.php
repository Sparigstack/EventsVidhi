@extends('layouts.appOrg')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container-fluid">
    <input type="hidden" class="eventsPage d-none" value="{{url("org/events")}}"/>
    <input type="text" class="PostUrl d-none" value="{{url("org/events/update")}}"/>
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">

                <!-- Custom url popup -->
                <div class="modal fade" id="openCustomUrlPopup" style="display:none;padding:17px!important;" aria-hidden="true">
                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input class="eventId" type="hidden" value="">
                    <input class="saveCustomUrl" type="hidden" value="{{url("saveCustomUrl")}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header pb-2 pt-3" style="font-size:25px;">
                                <label for="title" class="headerTitle"></label>
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
                                <div class="col-lg-12 row pr-0">
                                    <div class="pt-2 pr-0 col-lg-12">
                                        <!-- <span>{{env('APP_URL_Custom')}}</span> -->
                                        <p for="custom_url" class="float-left" style="font-weight: 300;margin:.3rem 0;">https://www.panelhive.com/</p>
                                        <input type="text" class="float-left" value="" onkeyup="ChangeCustomUrl(this);" id="CustomUrl" name="CustomUrl" autocomplete="off" required="" style="padding:0.175rem .75rem;">
                                        <!-- <span></span> -->
                                        <!-- <input type="text" class="form-control p-0 " style="border:none;" value="{{$CustomHumanReadableUrl}}" onkeyup="ChangeCustomUrl(this);" id="CustomUrl" name="CustomUrl" autocomplete="off"> -->
                                    </div>

                                    <!-- <div class="pl-0 pr-0 col-lg-4"> -->
                                        <!-- <div class="form-group col-lg-12"> -->
                                            <!-- <input type="text" class="form-control " value="" onkeyup="ChangeCustomUrl(this);" id="CustomUrl" name="CustomUrl" autocomplete="off" required=""> -->
                                        <!-- </div> -->
                                        
                                    <!-- </div> -->

                                    <div class="col-lg-12 mb-0">
                                        <button id="" class="btn m-1 btn-primary pull-right mr-4" style="" onclick="saveCustomUrl(this);">Save</button>
                                    </div>

                                    <div class="text-danger pl-2 pb-2 d-none" id='customUrlDuplicate'>Event name is already taken, please choose another.</div>
                                </div>

                                    <div class="row form-group pl-3 mr-3">
                                        <!-- <div class="col-lg-10 p-1" id="HumanFriendlyUrl" data="{{env('APP_URL_Custom')}}"> -->
                                        <div class="textPreview"> Preview URL:  </div>
                                        <div class="col-lg-10 p-1" id="HumanFriendlyUrl" data="https://www.panelhive.com/...">
                                             https://www.panelhive.com/...{{$FinalUrl}}
                                        </div>

                                    <div class="col-lg-2 pt-1">
                                        <a onclick="copyHumanFriendlyUrl(this);"><i style="cursor:pointer; margin-left:5px;font-size:20px;" class="fa fa-copy" title="Copy to Clipboard"></i></a>
                                    </div>

                                    <div class='copied'></div>

                                </div>

                                            <div class="col-lg-12 socialMediaLinks pull-right mb-2 mr-4 pr-4">
                                                <a target="_blank" href="https://www.linkedin.com/" class="pull-right"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-linkedin" title=""></i></a>
                                                
                                                <a target="_blank" href="https://twitter.com/" class="pull-right"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-twitter" title=""></i></a>
                                                
                                                <a target="_blank" href="https://facebook.com" class="pull-right"><i style="cursor:pointer; margin-left:5px;font-size:20px;color:#656464;" class="fa fa-facebook-official" title=""></i></a>
                                            </div>
                                    <!-- </div> -->

                                    <div class="greenFont pl-2 pb-2 d-none" id='successMessage'> Event URL is saved successfully, you can share it on your social media or other platforms.</div>

                                    <!-- <div class="form-group">
                                        <button id="" class="btn m-1 pull-right btn-primary" style="" onclick="saveCustomUrl(this);">Save</button>
                                    </div> -->

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
                        <div class="table-responsive" id="default-datatable_wrapper" style="overflow-x: visible;">
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
                                    $sd = date("d M, Y", $sdStamp);
                                    $st = date('H:i A', $sdStamp);

                                    $edStamp = strtotime($event->end_date_time);
                                    $ed = date("d M, Y", $edStamp);
                                    $et = date('H:i A', $edStamp);
                                    if ($sd == $ed) {
                                        $dateStr = date("d M, Y", $sdStamp) . ' ' . $st . ' to ' . $et;
                                    } else {
                                        $dateStr = date("d M, Y", $sdStamp) . ' ' . $st . ' to ' . date("d M, Y", $edStamp) . ' ' . $et;
                                    }
                                    ?>
                                     <td class="{{$titleClass}} pt-4"><a href="{{ url("org/eventPreview/$event->id") }}" style="color:inherit;">{{$event->title}}{{$draftWord}} <br> {{$dateStr}} </a></td>

                                    
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
                                                    <input type="hidden" class="eventCustomUrl" value="{{$event->custom_url}}">

                                                    <a class="dropdown-item backColorDropdownItem" href="{{ url("org/events/$event->id") }}"> Edit </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="deleteEvent(this);" db-delete-id="{{$event->id}}"> Delete </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="copyEvent(this);" db-event-id="{{$event->id}}"> Copy </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" data-toggle="modal" data-target="#openCustomUrlPopup" event-title="{{$event->title}}" db-event-id="{{$event->id}}" onclick="addCustomUrl(this);"> Custom URL </a>

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