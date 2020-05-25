@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
	<div class="row">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="mb-3">Password Settings</h5>
            	<form class="row" method="post" action="" enctype="multipart/form-data">
            		{{ csrf_field() }}

            		<div class="form-group col-lg-12">
            			<label for="oldPassword">Old Password</label>
						<input type="text" id="oldPassword" value="" name="oldPassword" class="form-control" title="Old Password" placeholder="Old Password" autocomplete="off" rows="0">
					</div>

					<div class="form-group col-lg-12">
            			<label for="newPassword">New Password</label>
						<input type="text" id="newPassword" value="" name="newPassword" class="form-control" title="New Password" placeholder="New Password" autocomplete="off" rows="0">
					</div>

					<div class="form-group col-lg-12">
            			<label for="confirmPass">Confirm Password</label>
						<input type="text" id="confirmPass" value="" name="confirmPass" class="form-control" title="Confirm Password" placeholder="Confirm Password" autocomplete="off" rows="0">
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