@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $ActionCall = url('org/csv/import');
    $RedirectCall = "";

    ?>
    <div class="row">
        <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header"><h5 class="mt-2">Account Settings</h5></div>
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
                        <!-- col-lg-4 -->
                        <div class="form-group">
                            <label for="CsvFile">Username</label>
                            <div class="">
                                <input type="text" id="Username" name="Username" data_type="username" class="form-control" value="{{$user->username}}" onchange="SaveUserSetting(this)">

                            </div>
                            <small class="text-danger usernameExist"></small>
                        </div>
                    </div>

                    <div class="icheck-material-info icheck-inline col-lg-8 pl-0">
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

        <div class="col-lg-7">
            <input type="hidden" class="cancelSubscription" value="{{url('cancelSubscription')}}">
            <input type="hidden" class="planName" value="{{Auth::User()->plan->plan_id}}">
            <?php 
                $benefits = "";
                $planName = "";
                $interval = "";
                if(Auth::user()->plan->id == 5){
                    $benefits = "3 gb of cloud space to upload & showcase content";
                } else if(Auth::user()->plan->id == 1 || Auth::user()->plan->id == 2){
                    $benefits = "10 gb of cloud space to upload & showcase content";
                } else {
                    $benefits = "Unlimited of cloud space to upload & showcase content";
                }

                if(Auth::user()->plan->id == 1){
                    $planName = "Plus Plan";
                    $interval = "$3 Billed Monthly";
                }
                if(Auth::user()->plan->id == 2){
                    $planName = "Plus Plan";
                    $interval = "$36 Billed Yearly";
                }
                if(Auth::user()->plan->id == 3){
                    $planName = "Premium Plan";
                    $interval = "$7 Billed Monthly";
                }
                if(Auth::user()->plan->id == 4){
                    $planName = "Premium Plan";
                    $interval = "$84 Billed Yearly";
                }
                if(Auth::user()->plan->id == 5){
                    $planName = "Basic Plan";
                    $interval = "Free";
                }
            ?>
            <div class="card">
                <div class="card-header"><h5 class="mt-2">Your Subscription Summary</h5></div>
                <div class="card-body">
                    <div class="row col-lg-12">
                        <div class="col-lg-4 pl-0 pr-0">
                            <h6> Your current plan - </h6> 
                        </div>
                        <div class="col-lg-8 pl-0 pr-0">
                            <p> {{$planName}} ({{$interval}}) </p> 
                        </div>
                    </div>
                    <div class="row col-lg-12">
                        <div class="col-lg-4 pl-0 pr-0">
                            <h6> Your plan benefits - </h6>
                        </div>
                       <div class="col-lg-8 pl-0 pr-0"> 
                            <p> {{$benefits}} </p> 
                        </div>
                    </div>

                    <?php if(Auth::user()->plan->id != 5) { 
                        $expiryDatePlusOne = date('Y-m-d', strtotime(Auth::user()->expiry_date . ' + 1 days'))
                    ?>
                    <div class="row col-lg-12">
                        <div class="col-lg-4 pl-0 pr-0">
                            <h6> Active until - </h6>
                        </div>
                        <div class="col-lg-8 pl-0 pr-0">
                            <p> {{Auth::user()->expiry_date}} </p>
                        </div>
                    </div>
                    <div class="row col-lg-12">
                        <div class="col-lg-4 pl-0 pr-0">
                            <h6> New billing date - </h6>
                        </div>
                        <div class="col-lg-8 pl-0 pr-0">
                            <p> {{$expiryDatePlusOne}} </p>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if(Auth::user()->plan->id != 5) { ?>
                    <div class="row col-lg-12">

                        <div class="col-lg-4 pl-0 pr-0">
                            <h6> Cancellation Policy - </h6>
                        </div>
                        <div class="col-lg-8 pl-0 pr-0">
                            <p class="notCancelPlan d-none"> If you want to cancel your paid plan, you will need to bring down your occupied storage by deleting your media content up to 3 gb of space and maximum 3 third party video/podcast URLs for your account as mentioned in the free subscription. Once you perform that step, you will notice Cancel My Subscription link below here which you can use to Cancel your subscription. </p>
                            <p class="CancelPlan d-none"> You are eligible to cancel your account by using the link below. Please note that your account will be changed to Free subscription policy straight away. To maximize your paid subscription benefits, you may cancel your account 1-2 days before your expiry date. </p>
                            <a style="color: #14abef !important;cursor: pointer;" onclick="CancelSubscription(this);" data-id="{{Auth::user()->id}}"><u>Cancel My Subscription</u> </a>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>

    </div>

    <!-- <div class="row justify-content-center">
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
    </div> -->

</div>
@endsection

@section('script')
<script src="{{asset('/js/settings.js')}}" type="text/javascript"></script>
@endsection