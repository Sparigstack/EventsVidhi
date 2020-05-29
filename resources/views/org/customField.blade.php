@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
    <?php
    $ActionCall = url('org/tags/store');
    ?>
    <div class="Data-Table">
        <input type="hidden" id="deleteTag" class="deleteTag" value="{{url('org/tags/delete')}}" />
        <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-table pt-3"></i> Add Custom Fields
                    </div>
                    <div class="card-body">
                        <form class="row CustomFieldForm" id="CustomFieldForm" action="{{url('org/customfield/store')}}" method="post">
                            <input type="hidden" class="addCustomField" value="{{url('org/customfield/store')}}">
                            {{ csrf_field() }}

                            <div class='form-group col-lg-4'>
                                <label for='tagName'>Custom Type Name</label>
                                <input type="text" class="form-control" id="name" name='name' value="{{  old('name') }}" placeholder="Custom Type Name" required>
                                <small class="text-danger tagInvalid"></small>
                            </div>
                            <div class='form-group col-lg-4'>
                                <label for='DisplayType'>Display Type</label>
                                <select name="DisplayType" id="DisplayType" autocomplete="off" class="custom-select">
                                    <option>Display Type</option>
                                    <option value="1">Text</option>
                                    <option value="2">Numeric</option>
                                    <option value="3">Date</option>
                                </select>
                                <small class="text-danger tagInvalid"></small>
                            </div>
                            <div class="col-lg-4 pt-4 mt-2 pl-0"><button type="submit" class="btn btn-primary pull-right">Save</button></div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-table pt-3"></i> All Custom Fields
                        <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                        <input type="hidden" class="deleteCustomField d-none" value="{{url('org/customfield/delete')}}">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable-CustomgField" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Custom Type Name</th>
                                        <th>Display Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($customFields as $customField) { ?>
                                        <tr class="parent">

                                            <td>{{$customField->name}} </td>
                                            <td><?php if ($customField->type == 1) {
                                                    echo "Text";
                                                } elseif ($customField->type == 2) {
                                                    echo "Numeric";
                                                } elseif ($customField->type == 3) {
                                                    echo "Date";
                                                } ?></td>
                                            <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" title="Edit Custom Field"></i>
                                                <a ><i db-delete-id="{{$customField->id}}" onclick="DeleteCustomField(this);" style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Custom Field"></i></a>
                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>Custom Type Name</th>
                                        <th>Display Type</th>
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
<script>
    $(document).ready(function() {
        var contactsTable = $('#default-datatable-CustomgField').DataTable({
            columnDefs: [{
                orderable: false,
                targets: 2
            }, ]
        });
    });

    (function() {

        var bar = $('.bar_upload');
        var percent = $('.percent_upload');
        //var status = $('#status');

        $('.CustomFieldForm').ajaxForm({
            beforeSend: function() {
                LoaderStart();
            },
            success: function(response) {
                location.reload();
                LoaderStop();
                // if (response.error != '') {
                //     $('.tagInvalid').append(response.error.tagName);
                //     alert(response.error.tagName);
                //     LoaderStop();
                // } else {
                //     $("#tagName").val('');
                //     // $("#allTags").append(response.tagName);
                //     $("#allTags").append('<option value="' + response.id + '" selected="selected">' + response.tagName + '</option>');
                //     LoaderStop();
                // }
            }
        });

    })();
</script>
@endsection