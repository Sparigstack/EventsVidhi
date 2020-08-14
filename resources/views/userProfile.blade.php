@extends('layouts.app')
<?php $v = "1.0.1"; ?>

@section('content')
<div class="container-fluid m-auto col-md-7">
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
}

?>
	<div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                        <h5>Edit Profile</h5>
                </div>
                <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

            	<form class="row" method="post" action="{{ url('userProfile/update')}}" enctype="multipart/form-data">
            		{{ csrf_field() }}
                    
                    <div class="row col-lg-12">
            		<div class="form-group col-lg-6">
                        <div class="form-group col-lg-12">
            			<label for="profileImgSrc">Profile Image (optional)</label>
                        <input type="hidden" name="userProfile" class="userProfile" value="{{$profilePicUrl}}">
            			<div class="dragFileContainer thumbNailContainer orgProfile" style="display: flex;justify-content: center;width:63% !important;">
                            <input type="file" accept="image/*" id="profileImg" name="profileImg" class="form-control files" style="width: 58%;
    height: 40% !important;">
                            <img id="profileImgSrc" src="{{$profilePicUrl}}" class="imageRadius w-100 {{$imageNone}}" alt="your image">
                            <?php
                                if (empty($profilePicUrl)) { ?>
                                <p id="textForProfile" class="textForProfile">Drop your image here or click to upload.</p>
                            <?php } ?>
                            
                        </div>
                        <small class="text-danger">{{ $errors->first('profileImg') }}</small>
                        <div class="text-danger d-none SizeError">Image size must be less than or equal to 4MB</div>

                        <?php 
                            $dNoneClassProfile = "d-none";
                            if(!empty($user->profile_pic)){
                                $dNoneClassProfile = '';
                            }
                            ?>
                            <div class="removeuserprofile {{$dNoneClassProfile}} pl-5 ml-5"><a type="button" id="RemoveUserProfileBtn">Remove Profile Image</a></div>
                        </div>

                        <div class="form-group col-lg-12">
                        <label for="organizerEmail">Email Address</label>
                        <input type="email" id="organizerEmail" value="{{$user->email}}" name="organizerEmail" class="form-control" title="Email Address" placeholder="Email Address" autocomplete="off" rows="0" readonly="">
                    </div>

            		</div>

                    <div class="form-group col-lg-6">
            		<div class="form-group col-lg-12">
            			<label for="organizerName">Name</label>
						<input type="text" id="organizerName" value="{{$user->name}}" name="organizerName" class="form-control" title="Name" placeholder="Name" autocomplete="off" rows="0" required="">
					</div>

                    <!-- <div class="form-group col-lg-12">
                        <label for="organizerUsername">Organizer Username</label>
                        <input type="text" id="organizerUsername" value="{{$user->username}}" name="organizerUsername" class="form-control" title="Organizer Username" placeholder="Organizer Username" autocomplete="off" rows="0">
                    </div> -->

                    <div class="form-group col-lg-12">
                        <label for="organizerMobile">Contact Number</label>
                        <input type="text" id="organizerMobile" value="{{$user->phone}}" name="organizerMobile" class="form-control" title="Contact Number" placeholder="Contact Number" autocomplete="off" rows="0">
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="facebookAcc">Facebook Profile</label>
                        <input type="url" id="facebookAcc" value="{{$user->facebook_url}}" name="facebookAcc" class="form-control" title="Facebook Profile" placeholder="Facebook Profile" autocomplete="off" rows="0">
                    </div>

                </div>
                </div>

                    <!-- <div class="form-group col-lg-6">
                        <label for="organizerMobile">Organizer Phone Number</label>
                        <input type="text" id="organizerMobile" value="{{$user->phone}}" name="organizerMobile" class="form-control" title="Organizer Phone Number" placeholder="Organizer Phone Number" autocomplete="off" rows="0">
                    </div> -->

					<!-- <div class="form-group col-lg-12">
            			<label for="organizerDesc">Organizer Description</label>
                        <textarea id="organizerDesc" name="organizerDesc" class="form-control" title="Organizer Description" placeholder="Organizer Description" autocomplete="off" rows="4">{{$user->description}}</textarea>
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
<script src="{{asset('/js/Profile.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/Events.js')}}" type="text/javascript"></script>

@endsection