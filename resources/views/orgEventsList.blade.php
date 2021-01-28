@extends('layouts.appOrg')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php $v = "1.0.1"; ?>
<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> List of Events
                        <!-- <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <!-- <table id="default-datatable" class="table table-bordered"> -->
                            <table id="default-datatable" class="table" style="border-collapse: collapse !important;">
                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th>Event Title</th>
                                        <th style="width:100px;">Event Date & Time</th>
                                        <th style="width:100px;">Event Location</th>
                                        <th>Featured</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orgEvents as $orgEvent) { ?>
                                    <tr class="parent">
                                    <?php
                                    $dateStr = "";
                                    $splitString = "";

                                    $sdStamp = strtotime($orgEvent->date_time);
                                    $sd = date("d M, Y", $sdStamp);
                                    $st = date('H:i A', $sdStamp);

                                    $edStamp = strtotime($orgEvent->end_date_time);
                                    $ed = date("d M, Y", $edStamp);
                                    $et = date('H:i A', $edStamp);
                                    if ($sd == $ed) {
                                        $dateStr = date("d M, Y", $sdStamp) . ' ' . $st.' to ';
                                        $splitString = $et;
                                    } else {
                                        $dateStr = date("d M, Y", $sdStamp) . ' ' . $st.' to ';
                                        $splitString = date("d M, Y", $edStamp) . ' ' . $et;
                                    }
                                    ?>
                                    <td class="hoverEventTitle">{{$orgEvent->title}}</td>
                                    <td style="width:100px;">{{$dateStr}}<br>{{$splitString}}</td>
                                    <td style="width:100px;">
                                        @if($orgEvent->is_online == '1')
                                            Online
                                        @else
                                            {{$orgEvent->city}}, {{$orgEvent->country->name}}
                                        @endif
                                    </td>
                                    <input type="hidden" class="updateIsFeatured" value="{{url('updateIsFeaturedEvent')}}">
                                    <?php 
                                        $checked = "";
                                        $eventFeatureTrue = "0";
                                        if($orgEvent->is_featured == 1) {
                                            $checked = "checked";
                                            $eventFeatureTrue = "1";
                                        }
                                    ?>

                                    <td class="ml-5 pl-5"><input type="checkbox" class="isFeature" {{$checked}} data-id="{{$orgEvent->id}}" onclick="updateIsFeatured(this);" data-event="{{$eventFeatureTrue}}"></td>
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
<script src="{{asset('/js/customScript.js?v='.$v)}}" type="text/javascript"></script>
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
<script>
    $(document).ready(function () {
        var table = $('#default-datatable').DataTable({
            ordering: false,
            aoColumnDefs: [
            {
                bSortable: false,
                aTargets: [2]
            }
        ],
        });
    });
</script>
@endsection