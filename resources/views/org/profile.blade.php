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
if(!empty($user)){
    if (!empty($user->profile_pic)) {
        $profilePicUrl = $AwsUrl . $user->profile_pic;
        $profilePicHidden = "d-none";
        $imageNone = "";
    }

    if (!empty($user->banner)) {
        $BannerUrl = $AwsUrl . $user->banner;
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

            	<form class="row" method="post" action="{{ url('org/profile/update')}}" enctype="multipart/form-data">
            		{{ csrf_field() }}
                    <div class="form-group col-lg-12">
                        <label for="profileBannerImage">Organizer Banner Image (optional)</label>

                        <div class="dragFileContainer">
                            <input type="file" accept="image/*" id="profileBannerImage" name="profileBannerImage" class="form-control files">
                            <img id="profileBannerImageSrc" src="{{$BannerUrl}}" class="{{$BannerHidden}} imageRadius w-100" alt="your image"/>
                            <?php
                                if (empty($BannerUrl)) { ?>
                                <p id="textForProfileBanner">Drop your image here or click to upload.</p>
                            <?php } ?>
                        </div>
                        <small class="text-danger">{{ $errors->first('profileBannerImage') }}</small>
                        <div class="text-danger d-none SizeError">Image size must be less than or equal to 4MB</div>
                    </div>

                    <div class="row col-lg-12">
            		<div class="form-group col-lg-6">
            			<label for="profileImgSrc">Organizer Profile Image (optional)</label>
            			<div class="dragFileContainer thumbNailContainer" style="display: flex;justify-content: center;">
                            <input type="file" accept="image/*" id="profileImg" name="profileImg" class="form-control files">
                            <img id="profileImgSrc" src="{{$profilePicUrl}}" class="imageRadius w-100 {{$imageNone}}" alt="your image">
                            <?php
                                if (empty($profilePicUrl)) { ?>
                                <p id="textForProfile" class="textForProfile">Drop your image here or click to upload.</p>
                            <?php } ?>
                            
                        </div>
                        <small class="text-danger">{{ $errors->first('profileImg') }}</small>
                        <div class="text-danger d-none SizeError">Image size must be less than or equal to 4MB</div>
            		</div>

                    <div class="form-group col-lg-6">
            		<div class="form-group col-lg-12">
            			<label for="organizerName">Organizer Name</label>
						<input type="text" id="organizerName" value="{{$user->name}}" name="organizerName" class="form-control" title="Organizer Name" placeholder="Organizer Name" autocomplete="off" rows="0" required="">
					</div>

                    <div class="form-group col-lg-12">
                        <label for="organizerUsername">Organizer Username</label>
                        <input type="text" id="organizerUsername" value="{{$user->username}}" name="organizerUsername" class="form-control" title="Organizer Username" placeholder="Organizer Username" autocomplete="off" rows="0" required="">
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="organizerEmail">Organizer Email Address</label>
                        <input type="email" id="organizerEmail" value="{{$user->email}}" name="organizerEmail" class="form-control" title="Organizer Email Address" placeholder="Organizer Email Address" autocomplete="off" rows="0" readonly="">
                    </div>
                </div>
                </div>

					<!-- <div class="form-group col-lg-12">
            			<label for="descBox">Description Box</label>
                        <textarea id="descBox" name="descBox" required="" class="form-control" title="Description Box" placeholder="Description Box" autocomplete="off" rows="4"></textarea>
					</div>

					<div class="form-group col-lg-12">
            			<label for="facebookAcc">Facebook Account</label>
						<input type="text" id="facebookAcc" value="" name="facebookAcc" class="form-control" title="Facebook Account" placeholder="Facebook Account" autocomplete="off" rows="0">
					</div>

					<div class="form-group col-lg-12">
            			<label for="twitterAcc">Twitter Account</label>
						<input type="text" id="twitterAcc" value="" name="twitterAcc" class="form-control" title="Twitter Account" placeholder="Twitter Account" autocomplete="off" rows="0">
					</div>

					<div class="form-group col-lg-12">
            			<label for="linkedinAcc">LinkedIn Account</label>
						<input type="text" id="linkedinAcc" value="" name="linkedinAcc" class="form-control" title="LinkedIn Account" placeholder="LinkedIn Account" autocomplete="off" rows="0">
					</div>

					<div class="form-group col-lg-12">
            			<label for="websiteName">Website Name</label>
						<input type="text" id="websiteName" value="" name="websiteName" class="form-control" title="Website Name" placeholder="Website Name" autocomplete="off" rows="0">
					</div> -->

					<div class="col-lg-12">
                        <button type="submit" id="Submit" data-id="" class="btn btn-primary px-5 pull-right"> Save Profile</button>
					</div>


            	</form>

            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script src="{{asset('/js/customScript.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/Events.js')}}" type="text/javascript"></script>

@endsection