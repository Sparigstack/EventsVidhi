@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $ActionCall = url('org/csv/import');
    $RedirectCall = "";

    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><h5 class="mt-2">User Settings</h5></div>
                <div class="card-body">
                    <!-- <div class="card-title">
                        <h5>User Settings</h5>
                    </div>
                    <hr> -->
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif


                    {{ csrf_field() }}
                    <input type="hidden" id="urlToCall" class="urlToCall" value="{{ url('org/setting/update')}}" />
                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <div class="parent" style="width: 100%;">
                        <div class="form-group col-lg-4">
                            <label for="CsvFile">Username</label>
                            <div class="">
                                <input type="text" id="Username" name="Username" data_type="username" class="form-control" value="{{$user->username}}" onchange="SaveUserSetting(this)">

                            </div>
                            <small class="text-danger usernameExist"></small>
                        </div>
                    </div>

                    <div class="icheck-material-info icheck-inline col-lg-6">
                        <?php $IsChecked = "";
                        if ($user->auto_approve_follower) {
                            $IsChecked = "checked";
                        }
                        ?>
                        <input type="checkbox" id="AutoApproveFollower" {{$IsChecked}} name="AutoApproveFollower" data_type="AutoAproveFollower" onchange="SaveUserSetting(this)">
                        <label for="AutoApproveFollower">Auto approve follower's</label>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h5 class="mt-2">{{ __('Reset Password') }}</h5></div>

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
@endsection

@section('script')
<script src="{{asset('/js/settings.js')}}" type="text/javascript"></script>
@endsection