@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $CardTitle = "Add New Contact";
    $ActionCall = url('org/contacts/store');
    $RedirectCall = url('org/contacts');
    $firstname = "";
    $lastname = "";
    $email = "";
    
    if (!empty($contact)) {
        $ActionCall = url('org/contacts/edit/' . $contact->id);
        $CardTitle = "Edit Contact";
        $firstname = $contact->first_name;
        $lastname = $contact->last_name;
        $email = $contact->email;
        
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

                    <form class="" action="{{$ActionCall}}" method="post" >
                    {{ csrf_field() }}
                   <!--  <input type="hidden" id="hdnRedirect" value="{{$RedirectCall}}" /> -->
                        <div class='form-group'>
                            <label for='firstName'>First Name</label>
                            <input type="text" class="form-control" id="firstName" name='firstName' value="{{  old('firstName', $firstname) }}" placeholder="Enter First Name" required>
                        </div>
                        <div class='form-group'>
                            <label for='lastName'>Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName"  value="{{  old('lastName', $lastname) }}" placeholder="Enter Last Name" required>
                        </div>
                        <div class='form-group'>
                            <label for='emailAddress'>Email Address</label>
                            <input type="text" class="form-control" id="emailAddress" name="emailAddress"  value="{{  old('emailAddress', $email) }}" placeholder="Enter Email Address" required>
                        </div>


                        <button class="btn btn-primary px-5 pull-right" type="submit">Save Contact</button>
                    </form>

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
<script src="{{asset('/js/VideoAndContact.js')}}" type="text/javascript"></script>
<!-- <script>
    $(document).ready(function() {
        $('.dragFileForm input').change(function() {
            $('.dragFileForm p').text(this.files.length + " file(s) selected");
        });
        UploadContactVideoBox();
        showHideLinkEvent();
    });
</script> -->

<script>
    (function () {

        var bar = $('.bar_upload');
        var percent = $('.percent_upload');
        //var status = $('#status');

        $('.dragFileForm').ajaxForm({
            beforeSend: function () {
                //status.empty();
                var percentVal = '0%';
                var posterValue = $('input[name=input_podfile]').fieldValue();
                bar.width(percentVal)
                percent.html(percentVal);                
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
                LoaderStart();
            },
            success: function () {
                LoaderStop();
                var percentVal = 'Redirecting..';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            complete: function (xhr) {
                //status.html(xhr.responseText);
                //alert('Uploaded Successfully');

                window.location.href = $('#hdnRedirect').val();
            }
        });

    })();
</script>
@endsection