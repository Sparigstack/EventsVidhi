@extends('layouts.appOrg')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container-fluid">
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

</div> -->

@endsection