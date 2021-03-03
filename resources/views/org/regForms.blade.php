<?php $v = "1.0.1"; ?>
@extends('layouts.appOrg')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                       <i class="fa fa-table pt-3"></i> All Registration Forms
                       <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/regForm/new")}}">Add Registration Form</a></button>
                        <!-- <button id="" class="btn m-1 pull-right" style="border:1px solid transparent;"><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <!-- <table id="default-datatable-videos" class="table table-bordered"> -->
                                <table id="default-datatable-formRegister" class="table" style="border-collapse: collapse !important;">
                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th style="border-right:unset !important;">Title</th>
                                        <th> Events attached to Forms </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regFormResults as $regFormResult)
                                   <tr class="parent">
                                        <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                        <input type="hidden"  class="deleteRegForm" value="{{url('deleteRegForm')}}">
                                        <td>{{$regFormResult->title}}</td>
                                        <td>{{$regFormResult->eventTitle}}</td>

                                        <td>
                                        <div class="card-action float-none">
                                            <div class="dropdown">
                                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" title="View More Actions">
                                                <i class="icon-options"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right topPosition">

                                                    <a class="dropdown-item backColorDropdownItem" href="{{ url("org/regForm/$regFormResult->id") }}"> Edit </a>

                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="deleteRegForm(this);" db-delete-id="{{$regFormResult->id}}"> Delete </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
<!-- Data Tables -->
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>

<script src="{{asset('/js/regForms.js?v='.$v)}}" type="text/javascript"></script>
@endsection