@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
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

    if (!empty(Auth::user()->banner)) {
        $BannerUrl = $AwsUrl . Auth::user()->banner;
        $BannerHidden = "";
    }
}

?>
	<div class="row">
        <div class="card w-100">
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

                    <div class="form-group col-lg-12">
                        <div class="form-group col-lg-12">
                                <label for="profileBannerImage">Organizer Banner Image</label><br>
                                <?php
                                    $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                    if (!empty(Auth::user()->banner)) {
                                        $logoUrl = $AwsUrl . Auth::user()->banner;
                                    }
                                ?>
                                <img class="rounded w-100 h-100 bannerRadius" style="" title="" src="{{$logoUrl}}">
                            </div>
                    </div>
                    <div class="row col-lg-12">
            		  <div class="form-group col-lg-6">

                            <div class="form-group col-lg-12">
            			        <label for="profileImgSrc">Organizer Profile Image</label><br>
                                <?php
                                    $logoUrl = $AwsUrl . 'no-image-logo.jpg';
                                    if (!empty(Auth::user()->profile_pic)) {
                                        $logoUrl = $AwsUrl . Auth::user()->profile_pic;
                                    }
                                ?>
                                <img class="rounded" style="width:35% !important;" title="" src="{{$logoUrl}}">
                            </div>

                            <div class="form-group col-lg-12">
                             <label for="organizerName" class="mb-0">Organizer Name</label>
                              <!-- <input type="text" id="organizerName" value="{{Auth::user()->name}}" name="organizerName" class="form-control" title="Organizer Name" placeholder="Organizer Name" autocomplete="off" rows="0" required="" readonly=""> -->
                                <p style="font-size:16px;" class="mb-4">{{Auth::user()->name}}</p>
                           </div>

                           <div class="form-group col-lg-12">
                                <label for="organizerEmail" class="mb-0">Organizer Email Address</label>
                                <!-- <input type="email" id="organizerEmail" value="{{Auth::user()->email}}" name="organizerEmail" class="form-control" title="Organizer Email Address" placeholder="Organizer Email Address" autocomplete="off" rows="0" readonly=""> -->
                                <p style="font-size:16px;" class="mb-0">{{Auth::user()->email}}</p>
                            </div>

            		  </div>

                      <div class="form-group col-lg-6">

                            <div class="form-group col-lg-12">
                                <label for="organizerDesc" class="mb-0">Organizer Description</label>
                                <!-- <textarea id="organizerDesc" name="organizerDesc" class="form-control" title="Organizer Description" placeholder="Organizer Description" autocomplete="off" rows="4" readonly="">{{Auth::user()->description}}</textarea> -->
                                <p style="font-size:16px;" class="mb-4">{{Auth::user()->description}}</p>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="websiteName" class="mb-0">Website Name</label>
                                <!-- <input type="url" id="websiteName" value="{{Auth::user()->website_url}}" name="websiteName" class="form-control" title="Website Name" placeholder="Website Name" autocomplete="off" rows="0"> -->
                                <p style="font-size:16px;" class="mb-4">{{Auth::user()->website_url}}</p>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="linkedinAcc" class="mb-0">LinkedIn</label>
                                <!-- <input type="url" id="linkedinAcc" value="{{Auth::user()->linkedin_url}}" name="linkedinAcc" class="form-control" title="LinkedIn" placeholder="LinkedIn" autocomplete="off" rows="0"> -->
                                <p style="font-size:16px;" class="mb-4">{{Auth::user()->linkedin_url}}</p>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="facebookAcc" class="mb-0">Facebook</label>
                                <!-- <input type="url" id="facebookAcc" value="{{Auth::user()->facebook_url}}" name="facebookAcc" class="form-control" title="Facebook" placeholder="Facebook" autocomplete="off" rows="0"> -->
                                <p style="font-size:16px;" class="mb-4">{{Auth::user()->facebook_url}}</p>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="twitterAcc" class="mb-0">Twitter</label>
                                <!-- <input type="url" id="twitterAcc" value="{{Auth::user()->twitter_url}}" name="twitterAcc" class="form-control" title="Twitter" placeholder="Twitter" autocomplete="off" rows="0"> -->
                                <p style="font-size:16px;" class="mb-0">{{Auth::user()->twitter_url}}</p>
                            </div>

                        </div>
                    </div>

					<div class="col-lg-12">
                        <a class="pull-right" href="{{ url('org/profile/'.$userId)}}"><button type="button" id="button" data-id="" class="btn btn-primary px-5 pull-right">Edit Profile</button></a>
					</div>
            	</form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- <script src="{{asset('/js/Profile.js')}}" type="text/javascript"></script> -->
<script src="{{asset('/js/Events.js')}}" type="text/javascript"></script>

@endsection