@extends('layouts.app')

@section('content')
<div class="container-fluid m-auto col-md-7">
<?php
$profilePicUrl = "";
$profilePicHidden = "";
$BannerUrl = "";
$BannerHidden = "d-none";
$imageNone = "d-none";
$AwsUrl = env('AWS_URL');
if(!empty(Auth::user())){
    if (!empty(Auth::user()->profile_pic)) {
        $profilePicUrl = $AwsUrl . Auth::user()->profile_pic;
        $profilePicHidden = "d-none";
        $imageNone = "";
    }
}

?>
	<div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                        <h5>Profile Details</h5>
                </div>
                <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                <?php $userId = Auth::user()->id; ?>

            	<form class="row" action="" enctype="multipart/form-data">
            		{{ csrf_field() }}
                    <div class="row col-lg-12">
            		  <div class="form-group col-lg-6">

                            <div class="form-group col-lg-12">
            			        <label for="profileImgSrc">Profile Image</label><br>
                                <?php
                                    $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                    if (!empty(Auth::user()->profile_pic)) {
                                        $logoUrl = $AwsUrl . Auth::user()->profile_pic;
                                    }
                                ?>
                                <img class="rounded" style="width:63% !important;" title="" src="{{$logoUrl}}">
                            </div>

            		  </div>

                      <div class="form-group col-lg-6">

                            <div class="form-group col-lg-12">
                             <label for="organizerName" class="mb-0">Name</label>
                              <!-- <input type="text" id="organizerName" value="{{Auth::user()->name}}" name="organizerName" class="form-control" title="Organizer Name" placeholder="Organizer Name" autocomplete="off" rows="0" required="" readonly=""> -->
                                <p style="font-size:16px;" class="mb-4">{{Auth::user()->name}}</p>
                           </div>

                            <div class="form-group col-lg-12">
                                <label for="organizerEmail" class="mb-0">Email Address</label>
                                <!-- <input type="email" id="organizerEmail" value="{{Auth::user()->email}}" name="organizerEmail" class="form-control" title="Organizer Email Address" placeholder="Organizer Email Address" autocomplete="off" rows="0" readonly=""> -->
                                <p style="font-size:16px;" class="mb-0">{{Auth::user()->email}}</p>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="organizerMobile" class="mb-0">Contact Number</label>
                                <p style="font-size:16px;" class="mb-4">{{Auth::user()->phone}}</p>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="facebookAcc" class="mb-0">Facebook Profile</label>
                                <!-- <input type="url" id="facebookAcc" value="{{Auth::user()->facebook_url}}" name="facebookAcc" class="form-control" title="Facebook" placeholder="Facebook" autocomplete="off" rows="0"> -->
                                <p style="font-size:16px;" class="mb-0">{{Auth::user()->facebook_url}}</p>
                            </div>

                        </div>
                    </div>

					<div class="col-lg-12">
                        <a class="pull-right" href="{{ url('userProfile/'.$userId)}}"><button type="button" id="button" data-id="" class="btn btn-primary px-5 pull-right">Edit Profile</button></a>
					</div>
            	</form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')


@endsection