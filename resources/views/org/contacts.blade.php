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
                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> All Contacts
                        <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/contacts/new")}}">Add New Contact</a></button>
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
                            </div>
                        <!-- </form> -->


                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable-contacts" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email Address</th>
                                        <th>Tags</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $contact) {
                                    ?>
                                        <tr class="parent">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                            <input type="hidden" class="deleteContact" value="{{url('deleteContact')}}">
                                            <input type="hidden" class="ApproveContact" value="{{url('org/contact/approve')}}">
                                            <td>{{$contact->first_name}} </td>
                                            <td>{{$contact->last_name}}</td>
                                            <td>{{$contact->email}}</td>
                                            <td> <?php $tagSplit = [];
                                                    foreach ($contact->tags as $tagName) {
                                                        $tagSplit[] = $tagName->name;
                                                    }
                                                    echo implode(", ", $tagSplit); ?>
                                            </td>
                                            <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" title="Edit Contact" onclick="window.location='{{ url("org/contacts/edit/".$contact->id) }}'"></i>
                                                <a onclick="deleteContact(this);" db-delete-id="{{$contact->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Contact"></i></a>
                                                <?php
                                                if (Auth()->user()->auto_approve_follower != 1 && $contact->is_approved != 1) { ?>
                                                    <a onclick="Approve(this);" data-id="{{$contact->id}}"><i style="font-family:fontawesome;font-style:normal;cursor:pointer;margin-left:5px;" class="fa fa-square-o" title="Approve"></i> </a>
                                                <?php }else { ?>
                                                    <a onclick="" data-id="{{$contact->id}}"><i style="font-family:fontawesome;font-style:normal;margin-left:5px;" class="fas fa-check-square" title="Approved"></i> </a>

                                                <?php } ?>

                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email Address</th>
                                        <th>Tags</th>
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

@section('script')
<script src="{{asset('/js/ContactAndTag.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Data Tables -->
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
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

        $('.custom-header').multiSelect({
            selectableHeader: "<div class='custom-header'>Selectable items</div>",
            selectionHeader: "<div class='custom-header'>Selection items</div>",
            selectableFooter: "<div class='custom-header'>Selectable footer</div>",
            selectionFooter: "<div class='custom-header'>Selection footer</div>"
        });
    });
</script>

@endsection