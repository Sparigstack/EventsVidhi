@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
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

                        <form method="" action="contacts/1">
                                <!-- {{ csrf_field() }} -->
                            <div class="row p-1 mb-3">
                                <div class="col-sm-12 col-lg-6 col-md-6">
                                        <!-- <label>Search Tags</label> -->
                                        
                                         <select class="form-control multiple-select" name="tagSelection[]" id="tagSelection" multiple="multiple">
                                          <?php  foreach($tagList as $tagLists){  ?>
                                            <option value="{{$tagLists->id}}">{{$tagLists->name}}</option>
                                          <?php } ?>
                                        </select>
                                        <!-- <input type="text" class="form-control" placeholder="" value="" name="search" id="search"> -->
                                </div>

                                <div class="col-sm-12 col-lg-4 col-md-4">
                                    <button type="submit" class="btn btn-primary">Search Tags</button>
                                </div>
                            </div>
                        </form>


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
                                    <input type="hidden"  class="deleteContact" value="{{url('deleteContact')}}">
                                            <td>{{$contact->first_name}} </td>
                                            <td>{{$contact->last_name}}</td>
                                            <td>{{$contact->email}}</td>
                                            <td> <?php $tagSplit = []; 
                                             foreach($contact->tags as $tagName){
                                               $tagSplit[] = $tagName->name;
                                            }
                                            echo implode(", ",$tagSplit); ?>
                                            </td>
                                            <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" title="Edit Contact" onclick="window.location='{{ url("org/contacts/".$contact->id) }}'"></i>
                                                <a onclick="deleteContact(this);" db-delete-id="{{$contact->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Contact"></i></a>              
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

<script>
$(document).ready(function() {

    $('.multiple-select').select2({
                placeholder: "Select tags",
                allowClear: true
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
