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
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <table id="default-datatable-contacts" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="42.5%">Title</th>
                                        <th width="42.5%">Description</th>
                                        <!-- <th class="max-w-table-200">Contact URL</th> -->
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $contact) {
                                        $AwsUrl = env('AWS_URL');
                                        $videoContactUrl = "";
                                        if (!empty($contact->url)) {
                                            if(substr( $contact->url, 0, 8 ) != "https://"){
                                                $videoContactUrl = $AwsUrl . $contact->url;
                                            }
                                            else{
                                                $videoContactUrl = $contact->url;
                                            }
                                        }
                                        $backColor = "";
                                        if(isset($contact->event)){
                                            $backColor = "eventLinkedBg";
                                        }
                                         ?>
                                        <tr class="parent {{$backColor}}">
                                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                    <input type="hidden"  class="deleteContact" value="{{url('deleteContact')}}">
                                            <td>{{$contact->title}} </td>
                                            <?php $eventDesc = "";
                                            $eventPrefix = "";
                                            $eventLink = "";
                                            $desc = "";
                                            if(isset($contact->event)){
                                                $eventPrefix = "Event :";
                                                $eventDesc = $contact->event->title;
                                            }else{
                                                $desc = $contact->description;
                                            } ?>
                                            <td>
                                                <?php if(!empty($eventDesc)){
                                                    $eventId = $contact->event->id;
                                                    ?>
                                                <b>{{$eventPrefix}}</b><a target="_blank" href="{{url('org/events/'.$eventId)}}"> {{$eventDesc}}</a>
                                                <?php
                                                } else { ?>
                                                    {{$desc}}
                                                <?php } ?>
                                                </td>
                                            <!-- <td>{{$contact->url}}</td> -->
                                            <!-- <td class="max-w-table-200">{{$videoContactUrl}}</td> -->
                                            <td>
                                                <i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-edit" title="Edit Contact" onclick="window.location='{{ url("org/contacts/".$contact->id) }}'"></i>
                                                <a onclick="deleteContact(this);" db-delete-id="{{$contact->id}}"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;" class="fas fa-trash" title="Delete Contact"></i></a>
                                                <a href="{{$videoContactUrl}}" target="_blank"><i style="font-family:fontawesome; font-style:normal; cursor:pointer; margin-left:5px;color:black;" class="fa fa-file-video-o" title="View Contact"></i></a> 
                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th width="42.5%">Title</th>
                                        <th width="42.5%">Description</th>
                                        <!-- <th class="max-w-table-200">Contact URL</th> -->
                                        <!-- <th>Location</th> -->
                                        <th width="15%">Action</th>
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
