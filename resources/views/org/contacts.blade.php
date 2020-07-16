@extends('layouts.appOrg')
@section('css')
<link href="{{ asset('assets/plugins/jquery-multi-select/multi-select.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="container-fluid">
<?php
$checkCount = "no";
$MultSelectTags = "";
// $ActionCall = url('org/contacts/' . $tag_ids);
?>
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">

                <!-- Email popup -->
                <div class="modal fade" id="openEmailPopup" style="display:none;padding:17px!important;" aria-hidden="true">
                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header pb-2 pt-3" style="font-size:25px;">
                                <label for="title">Send Email</label>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <div class="col-lg-12 row mb-2">
                                    <div class="col-lg-4 pr-0">
                                        <label for="emailTemplate" class="mt-2"> Email Template: </label>
                                    </div>
                                    <div class="col-lg-8 pl-0">
                                        <select required autocomplete="off" name="emailTemplate" id="emailTemplate" class="form-control custom-select">
                                            <option value>Select Email Template</option>
                                            <option value="1">Email Template 1</option>
                                            <option value="2">Email Template 2</option>
                                            <option value="3">Email Template 3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 row">
                                    <div class="col-lg-4 pr-0">
                                        <label for="emailSubject" class="mt-2"> Enter Subject: </label>
                                    </div>
                                    <div class="col-lg-8 pl-0">
                                        <input type="text" value="" id="emailSubject" name="emailSubject" class="form-control" autocomplete="off" required="">
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-0">
                                        <button id="" class="btn m-1 btn-primary pull-right mr-4 mt-2">Send</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Email popup -->

                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> All Contacts
                        <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/contacts/new")}}">Add New Contact</a></button>
                        <button id="" class="btn m-1 pull-right btn-success" style=""><a href="{{url("org/contacts/export")}}">Export Contact's</a></button>
                        <!-- <button id="" class="btn m-1 pull-right" style="border:1px solid transparent;"><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <input type="hidden" class="urlString" value="{{url('org/my_contacts')}}">

                        <!-- <form action=""> -->
                            <!-- {{ csrf_field() }} -->
                            <div class="row p-1 mb-3">
                                <div class="col-sm-12 col-lg-6 col-md-6">
                                    <!-- <label>Search Tags</label> -->

                                    <select class="form-control multiple-select" name="tagSelection[]" id="tagSelection" multiple="multiple">
                                        <?php $tagIdsArr = explode(',', $tag_ids);
                                        foreach ($tagList as $tag) {
                                        $IsSelected = "";  ?>

                                        <?php  foreach ($tagIdsArr as $tag_id) {

                                            if ($tag_id == $tag->id) {
                                                $IsSelected = "selected";
                                                if ($checkCount == "no") {
                                                    $MultSelectTags .= strval($tag->id);
                                                } else {
                                                    $MultSelectTags .= "," . $tag->id;
                                                }
                                                $checkCount = "yes";
                                            }

                                ?>

                                        <?php } ?>

                                      

                                        <option value="{{$tag->id}}" {{$IsSelected}}>{{$tag->name}}</option>

                                            
                                        <?php } ?>
                                    </select>

                                    <textarea id="HiddenCategoyID" name="HiddenCategoyID" required class="form-controld d-none" title="HiddenCategoyID" placeholder="HiddenCategoyID" autocomplete="off" rows="4">{{$MultSelectTags}} </textarea>
                                    <!-- <input type="text" class="form-control" placeholder="" value="" name="search" id="search"> -->
                                </div>

                                <div class="col-sm-12 col-lg-4 col-md-4">
                                    <!-- <button type="submit" class="btn btn-primary">Search Tags</button> -->
                                    <!-- <button onclick="tagsSelect(this);" class="btn btn-primary">Search Tags</button> -->
                                    <button onclick="tagsSelect(this);" class="btn m-1" aria-hidden="true" style="background-color:#6c757d29;"></i>Search Tags</button>
                                </div>

                                <!-- <div class="col-sm-12 col-lg-2 col-md-2">
                                    <div class="dropdown">
                                        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown"><button class="btn btn-outline-primary m-1 pull-right">Bulk Actions</button></a>
                                        <div class="dropdown-menu dropdown-menu-right bulkActionDropDown">
                                            <a class="dropdown-item backColorDropdownItem" href="">Email</a>
                                        </div>
                                    </div>
                                </div> -->

                            </div>
                        <!-- </form> -->


                        <div class="table-responsive" id="default-datatable_wrapper">
                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <!-- <table id="default-datatable-contacts" class="table table-bordered"> -->
                            <table id="default-datatable-contacts" class="table" style="border-collapse: collapse !important;">

                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th><!-- <button style="margin-bottom: 10px" class="btn btn-primary" data-url="{{url('deleteSelectedContacts')}}" onclick="deleteSelectedContact(this);">Delete All Selected</button> --></th>
                                        <th>Profile Pic</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email Address</th>
                                        <th>Tags</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $contact) {
                                    ?>
                                        <tr class="parent">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                            <input type="hidden" class="deleteContact" value="{{url('deleteContact')}}">
                                            <input type="hidden" class="ApproveContact" value="{{url('org/contact/approve')}}">
                                            <input type="hidden" class="deleteSelectedContacts" value="{{url('deleteSelectedContacts')}}">
                                            <td style="padding-top:40px;"><input type="checkbox" class="sub_chk" data-id="{{$contact->id}}"></td>
                                            <td><img class="speakerImgSize rounded"title="Profile Pic" src="{{env('AWS_URL') . 'no-image-logo.jpg'}}"> </td>
                                            <td>{{$contact->first_name}} </td>
                                            <td>{{$contact->last_name}}</td>
                                            <td>{{$contact->email}}</td>
                                            <td> <?php $tagSplit = [];
                                                    foreach ($contact->tags as $tagName) {
                                                        $tagSplit[] = $tagName->name;
                                                    }
                                                    echo implode(", ", $tagSplit); ?>
                                            </td>
                                            
                                            <!-- <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" title="Edit Contact" onclick="window.location='{{ url("org/contacts/edit/".$contact->id) }}'"></i>
                                                <a onclick="deleteContact(this);" db-delete-id="{{$contact->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Contact"></i></a>
                                                <?php if(Auth()->user()->auto_approve_follower != 1 ){
                                                if ($contact->is_approved != 1) { ?>
                                                    <a onclick="Approve(this);" data-id="{{$contact->id}}"><i style="font-family:fontawesome;font-style:normal;cursor:pointer;margin-left:5px;" class="fa fa-square-o" title="Approve"></i> </a>
                                                <?php }else { ?>
                                                    <a onclick="" data-id="{{$contact->id}}"><i style="font-family:fontawesome;font-style:normal;margin-left:5px;" class="fas fa-check-square" title="Approved"></i> </a>

                                                <?php }} ?>

                                            </td> -->

                                            <td>
                                                <div class="card-action float-none">
                                            <div class="dropdown">
                                                <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" title="View More Actions">
                                                <i class="icon-options"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right topPosition">

                                                <a class="dropdown-item backColorDropdownItem" href="{{ url('org/contacts/edit/'.$contact->id) }}">Edit</a>

                                                <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="deleteContact(this);" db-delete-id="{{$contact->id}}">Delete</a>

                                                <?php if(Auth()->user()->auto_approve_follower != 1 ){
                                                if ($contact->is_approved != 1) { ?>
                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="Approve(this);" data-id="{{$contact->id}}"> Approve </a>
                                                <?php }else { ?>
                                                    <a class="dropdown-item backColorDropdownItem" href="javascript:void();" onclick="" data-id="{{$contact->id}}">Approved</a>

                                                <?php }} ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <!-- <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email Address</th>
                                        <th>Tags</th>
                                        <th>Action</th>
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
<script src="{{asset('/js/ContactAndTag.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Data Tables -->
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/pdfmake.min.js')}}"></script>
<script>
    $(document).ready(function() {

        $('.multiple-select').select2({
            placeholder: "Select tags",
            allowClear: true
        });

        var MultiSlectCounter = 0;
        $('.multiple-select').on('select2:select', function(e) {
            console.log(e.params.data.id);
            if (MultiSlectCounter == 0) {
                $('#HiddenCategoyID').append(e.params.data.id);
            } else {
                $('#HiddenCategoyID').append("," + e.params.data.id);
            }

            MultiSlectCounter += 1;
        });
        $('.multiple-select').on('select2:unselecting', function(e) {
            console.log(e.params.args.data.id);
            var str = $('#HiddenCategoyID').val();
            var res = str.replace(e.params.args.data.id, "");
            $('#HiddenCategoyID').empty();
            $('#HiddenCategoyID').append(res);
        });

        // $('.custom-header').multiSelect({
        //     selectableHeader: "<div class='custom-header'>Selectable items</div>",
        //     selectionHeader: "<div class='custom-header'>Selection items</div>",
        //     selectableFooter: "<div class='custom-header'>Selectable footer</div>",
        //     selectionFooter: "<div class='custom-header'>Selection footer</div>"
        // });
    });
</script>

@endsection