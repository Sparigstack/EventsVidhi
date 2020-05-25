@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
	<h5 class="mb-3">Profile Details</h5>
	<div class="row">
        <div class="card w-100">
            <div class="card-body">
            	<form class="row" method="post" action="" enctype="multipart/form-data">
            		{{ csrf_field() }}

            		<div class="form-group col-lg-12">
            			<label for="profileBannerImg">Profile Banner Image</label>
            			<div class="dragFileContainer">
                            <input type="file" accept="image/*" id="profileBannerImg" name="profileBannerImg" class="form-control files">
                            <img id="profileBannerImg" src="" class="imageRadius d-none" alt="" width="100">
                            <p id="textForProfileBanner">Drop your image here or click to upload.</p>
                        </div>
            		</div>

            		<div class="form-group col-lg-12">
            			<label for="organizerName">Organizer Name</label>
						<input type="text" id="organizerName" value="" name="organizerName" class="form-control" title="Organizer Name" placeholder="Organizer Name" autocomplete="off" rows="0">
					</div>

					<div class="form-group col-lg-12">
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
					</div>

					<div class="col-lg-12">
                        <button type="submit" id="" data-id="" class="btn btn-primary px-5 pull-right"> Save Profile</button>
					</div>


            	</form>

            </div>
        </div>
    </div>

</div>

@endsection