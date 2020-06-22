@extends('layouts.appOrg')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                       <i class="fa fa-table pt-3"></i> Past Events
                        <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/events/new")}}">Add New Event</a></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
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
                                    <input type="hidden"  class="deleteEvent" value="{{url('deleteEvent')}}">
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
                                     <td class="{{$titleClass}}">{{$event->title}}{{$draftWord}} <br> {{$dateStr}} </td>
                                    <!-- <td class="max-w-table-100">{{$dateStr}}</td> -->
                                    <td>
                                        {{$event->category->name}}
                                    </td>
                                            <!-- <td>
                                                <a onclick="deleteEvent(this);" db-delete-id="{{$event->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash"></i></a>
                                                <a><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-eye"></i></a> 
                                            </td> -->

                                            <td class="pt-4">
                                        <div class="card-action float-none">
                                            <div class="dropdown">
                                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" title="View More Actions">
                                                <i class="icon-options"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right topPosition">
                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();"> Show </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>


                                        </tr>
                                    <?php }  ?>
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
            // ]
            ordering: false,

                aoColumnDefs: [
                            {
                            bSortable: false,
                            aTargets: [3]
                            }
                ],
        });
    });
</script>
@endsection
