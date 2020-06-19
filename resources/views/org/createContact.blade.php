@extends('layouts.appOrg')
@section('css')
<link href="{{ asset('assets/plugins/jquery-multi-select/multi-select.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.css') }}" rel="stylesheet">
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
</link>

@endsection
@section('content')
<div class="container-fluid">
    <?php
    $CardTitle = "Add New Contact";
    $ActionCall = url('org/contacts/store');
    $RedirectCall = url('org/contacts');
    $firstname = "";
    $lastname = "";
    $email = "";
    $contactNumber = "";
    // $IsSelected = "";
    $MultSelectTags = "";
    $checkCount = "no";
    if (!empty($contact)) {
        $ActionCall = url('org/contacts/update/' . $contact->id);
        $CardTitle = "Edit Contact";
        $firstname = $contact->first_name;
        $lastname = $contact->last_name;
        $email = $contact->email;
        if (!empty($contact->contact_number)) {
            $contactNumber = $contact->contact_number;
        }
    }
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>{{$CardTitle}}</h5>
                    </div>
                    <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="newContactForm" action="{{$ActionCall}}" method="post">
                        {{ csrf_field() }}
                        <!--  <input type="hidden" id="hdnRedirect" value="{{$RedirectCall}}" /> -->
                        <div class='form-group'>
                            <label for='firstName'>First Name</label>
                            <input type="text" class="form-control" id="firstName" name='firstName' value="{{  old('firstName', $firstname) }}" placeholder="Enter First Name" required>
                        </div>
                        <div class='form-group'>
                            <label for='lastName'>Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="{{  old('lastName', $lastname) }}" placeholder="Enter Last Name" required>
                        </div>
                        <div class='form-group'>
                            <label for='emailAddress'>Email Address</label>
                            <input type="text" class="form-control" id="emailAddress" name="emailAddress" value="{{  old('emailAddress', $email) }}" placeholder="Enter Email Address" required>
                        </div>
                        <div class='form-group'>
                            <label for='ContactNumber'>Contact Number</label>
                            <input type="text" class="form-control" id="ContactNumber" name="ContactNumber" value="{{  old('ContactNumber', $contactNumber) }}" placeholder="Enter Contact Number">
                        </div>

                        <div class="form-group">

                            <label class="">Select Tags</label>
                            <input type="text" id="TagSelectionInput" class="TagSelectionInput form-control" placeholder="Select Tags" />
                            <img src="{{ asset('assets/images/busy.gif') }}" class="busyIcon d-none pull-right" alt="">
                            <div class="CurrentSelectedTags row  ml-1 mr-1 mt-2 pb-3 pt-1" style="background-color: #cccccc42;">

                            </div>

                            <small class="text-danger">{{ $errors->first('tags') }}</small>

                            <textarea id="HiddenCategoyID" name="HiddenCategoyID" required class="form-controld d-none" title="HiddenCategoyID" placeholder="HiddenCategoyID" autocomplete="off" rows="4">{{ old('HiddenCategoyID', $MultSelectTags) }} </textarea>
                        </div>

                        <div class="customFieldsContainer">


                            <?php
                            $value = "";
                            foreach ($customFields as $customField) {
                                $ConvertedName = str_replace(' ', '', $customField->name);
                                if (!empty($ContactCustomFields)) {
                                    foreach ($ContactCustomFields as $ContactCustomField) {
                                        if ($ContactCustomField->customfield_id == $customField->id) {
                                            if ($customField->type == 1) {
                                                $value = $ContactCustomField->string_value;
                                            } elseif ($customField->type == 2) {
                                                $value = $ContactCustomField->int_value;
                                            } else {
                                                $value = $ContactCustomField->date_value;
                                            }
                                        }
                                    }
                                }
                            ?>
                                <div class='form-group'>
                                    <label for=''>{{$customField->name}}</label>
                                    <?php if ($customField->type == 3) { ?>
                                        <input type='text' value="{{$value}}" placeholder="05/16/2020 10:28 AM" class="form-control date" autocomplete="off" name="{{$ConvertedName}}" id="{{$ConvertedName}}" />
                                    <?php } else { ?>
                                        <input type="text" class="form-control" id="{{$ConvertedName}}" name="{{$ConvertedName}}" value="{{$value}}" placeholder="Enter {{$customField->name}}">
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>


                        <button class="btn btn-primary px-5 pull-right" type="submit">Save Contact</button>
                    </form>
                    <div class="form-group">
                        <a href="{{url('org/my_contacts')}}"><button class="btn btn-light">Cancel</button></a>
                    </div>
                    <div class="newFieldsContainer">
                        <div id="newCustomField0" class="row parent CustomFieldForm d-none" id="CustomFieldForm">
                            <input type="hidden" class="addCustomField" value="{{url('org/customfield/store')}}">
                            {{ csrf_field() }}

                            <div class='form-group col-lg-5'>
                                <!--<label for='tagName'>New Field Name</label>-->
                                <input type="text" class="form-control fieldName" value="{{  old('name') }}" placeholder="New Field Name" required>
                                <small class="text-danger tagInvalid"></small>
                            </div>
                            <div class='form-group col-lg-5'>
                                <!--<label for='DisplayType'>Display Type</label>-->
                                <select name="DisplayType" autocomplete="off" class="custom-select fieldType">
                                    <option>Field Type</option>
                                    <option value="1">Text</option>
                                    <option value="2">Numeric</option>
                                    <option value="3">Date</option>
                                </select>
                                <small class="text-danger tagInvalid"></small>
                            </div>
                            <i title="Save New Field" onclick="saveCustomField(this);" aria-hidden="true" class="fa fa-check-square mt-1 clickable" style="font-size: 25px;color: green;"></i>
                            <i title="Cancel" onclick="removeCustomField(this);" aria-hidden="true" class="fa fa-trash ml-3 mt-1 clickable" style="font-size: 25px;"></i>

                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-primary waves-effect waves-light m-1" onclick="showNewCustomField(this);"> <i class="fa fa-plus-circle"></i> <span>Add New Field</span> </button>
                        </div>
                    </div>

                    <!--                    <div class
                                        <label class="mt-3" style="font-size: 14px;font-weight: bold;">Add new custom type</label>-->



                    <!--                    <form class="row" method="post" action="{{$ActionCall}}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group col-lg-6">
                                                <label for="EventThumbnailImage">Upload your video</label>
                                                <p style="font-size: .7pc;">Video size must be less than 100mb </p>
                                                <input type="file" id="VideoFile" name="VideoFile" 
                                                       class="form-control" >
                                                <small class="text-danger">{{ $errors->first('VideoFile') }}</small>                            
                    
                                            </div>
                    
                                             <div class="form-group col-lg-6">
                                                <label for="input-5">Durations</label>
                                                <input type="time" id="" class="form-control">
                                            </div> 
                    
                    
                    
                    
                                            <div class="form-group col-lg-12">
                                                <button type="submit" class="btn btn-primary px-5 pull-right"> Save Video</button>
                                            </div>
                                        </form>-->
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Recently Added Videos
                    <div class="card-action">
                        <div class="dropdown">
                            <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                <i class="icon-options"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void();">Action</a>
                                <a class="dropdown-item" href="javascript:void();">Another action</a>
                                <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void();">Separated link</a>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-flush shadow-none">
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$810,000 . 04 Beds . 03 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$2,560,000 . 08 Beds . 07 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$910,300 . 03 Beds . 02 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$1,140,650 . 06 Beds . 03 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$1,140,650 . 06 Beds . 03 Baths</small>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="https://via.placeholder.com/110x110" alt="user avatar" class="customer-img rounded">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">Lorem ipsum dolor sitamet consectetur adipiscing</h6>
                                <small class="small-font">$910,300 . 03 Beds . 02 Baths</small>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="card-footer text-center bg-transparent border-0">
                    <a href="javascript:void();">View all Videos</a>
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
<script src="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.js') }}"></script>
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script>
    (function() {

        var bar = $('.bar_upload');
        var percent = $('.percent_upload');
        //var status = $('#status');

        $('.dragFileForm').ajaxForm({
            beforeSend: function() {

                var percentVal = '0%';
                var posterValue = $('input[name=input_podfile]').fieldValue();
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
                LoaderStart();
            },
            success: function() {
                LoaderStop();
                var percentVal = 'Redirecting..';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            complete: function(xhr) {
                //status.html(xhr.responseText);
                //alert('Uploaded Successfully');

                window.location.href = $('#hdnRedirect').val();
            }
        });

    })();

    $(document).ready(function() {

        $('.newContactForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        $('#TagSelectionInput').on('keyup keypress', function(e) {

            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {

                if ($('.ui-autocomplete.ui-front.ui-menu.ui-widget').css('display') != 'none') {
                    return false;
                }

                $('.busyIcon').removeClass('d-none');
                    var textVal = $('#TagSelectionInput').val();
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
                    $.ajax({
                        url: '../tags/' + textVal,
                        type: "get",
                        data: {
                            _token: CSRF_TOKEN
                        },
                        success: function(response) {
                            console.log(response);
                            $('.busyIcon').addClass('d-none');
                            if ($("[data-id=" + response.id + " ]").length > 0) {
                                return false;
                            }
                            var SelectedTag = '<div class="badge shade d-flex p-2" data-id="' + response.id + '"><div class="badge_sub badge_sub_left" data-id="' + response.id + '" data-alternateid="0" data-stringvalue="">' + response.name + '</div><div class="badge_sub badge_sub_right pl-2" title="Delete" onclick="DeleteTag(this)" data-id="' + response.id + '">X</div></div>';
                            $('.CurrentSelectedTags').append(SelectedTag);

                            var SelectedTags = $('#HiddenCategoyID').val();
                            SelectedTags += response.id + ",";
                            $('#HiddenCategoyID').val(SelectedTags);
                            $('#TagSelectionInput').val('');
                        },
                        error: function(response) {
                            $('.busyIcon').addClass('d-none');
                            console.log(response);
                        }
                    });

            }
        });

        setEventDateAndTime();
        $('.single-select').select2();

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



        //        $('.custom-header').multiSelect({
        //            selectableHeader: "<div class='custom-header'>Selectable items</div>",
        //            selectionHeader: "<div class='custom-header'>Selection items</div>",
        //            selectableFooter: "<div class='custom-header'>Selectable footer</div>",
        //            selectionFooter: "<div class='custom-header'>Selection footer</div>"
        //        });


    });
</script>

<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script>
    //this will find the box loaded above and add the autocomplete functionality to it

    //search is the event when the search is triggered
    //select is when the user clicks on a value in the dropdown
    $(function() {
        //sets the match requirement status by adding this class

        var id = $('#TagSelectionInput');
        $(id).addClass('matchRequired');

        $("#TagSelectionInput").autocomplete({
            source: function(request, response) {
                $('.busyIcon').removeClass('d-none');
                console.log(request.term);
                // alert(request.term);
                var textVal = this.element[0].value;
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");


                $.getJSON('../tags/' + textVal, {
                    'fieldID': $(this.element[0]).attr('data-alternateid'),
                    'fieldValue': this.element[0].value
                }, function(result) {
                    $(".ui-autocomplete").css("z-index", 10000);
                    console.log(result);
                    alert(result[0].label);
                    $('.busyIcon').addClass('d-none');
                }, response);
            },
            minLength: 2,
            //triggered BEFORE search
            search: function() {
                // alert('searching');
                var id = $('#TagSelectionInput');
                $(id).attr('data-id', '');
                $(id).css('color', 'black').css('font-style', 'italic').css('font-weight', 'normal');


            },
            select: function(event, ui) {
                event.stopPropagation();
                console.log(ui);
                $('.busyIcon').removeClass('d-none');
                $('.busyIcon').addClass('d-none');
                if ($("[data-id=" + ui.item.id + " ]").length > 0) {
                                return false;
                            }
                var SelectedTag = '<div class="badge shade d-flex p-2" data-id="' + ui.item.id + '"><div class="badge_sub badge_sub_left" data-id="' + ui.item.id + '" data-alternateid="0" data-stringvalue="">' + ui.item.label + '</div><div class="badge_sub badge_sub_right pl-2" title="Delete" onclick="DeleteTag(this)" data-id="' + ui.item.id + '">X</div></div>';
                $('.CurrentSelectedTags').append(SelectedTag);

                var SelectedTags = $('#HiddenCategoyID').val();
                SelectedTags += ui.item.id + ",";
                $('#HiddenCategoyID').val(SelectedTags);

                $('#TagSelectionInput').val('');
                return false;

            },

            //html: true, // optional (jquery.ui.autocomplete.html.js required)

            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 10000);
            },
            response: function(event, ui) {

            }
        });

    });
</script>
<script>
    $(function() {
        var availableTags = [
            <?php
            foreach ($tagsData as $contact_tags) {
                echo "{ label:'" . $contact_tags->name . "',value:'" . $contact_tags->name . "',id:" . $contact_tags->id . "},";
            }
            ?>
        ];
        //var availableTags = new Array();
        // var availableTags = [ { label: "Choice1", value: "value1",id:1 }, { label: "Choice2", value: "value2",id:3 }];



        $("#TagSelectionInput").autocomplete({
            source: availableTags
        });
    });
</script>
@endsection