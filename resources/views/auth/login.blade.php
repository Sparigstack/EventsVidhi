@extends('layouts.NewAppFront')
@section('css')
<style>
.form-group input{
    height: 45px;
    width: 350px;
}
@media(max-width:40em) {
    .form-group input{
        /*width: auto !important;*/
        width: 265px !important;
    }
    .col-md-12{
        width: auto !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    .signUpAnchor{
        margin-right: 3rem!important;
    }
}
</style>
@endsection

@section('content')
<div class="container NewLogin" style="padding-top: 20px;">
    <div class="row">
        
        
        <div class="col-md-12 row">
                                            <div class="col-md-6">
                                                <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                        
                <div class="card-content p-2">
                   
                    <div class="card-title text-uppercase text-center py-3 CustomLoginText" style="font-family: Open Sans;
font-style: normal;
font-weight: bold;
font-size: 22px;
margin:10px 0px;
text-transform: capitalize !important;
line-height: 33px;
display: flex;
justify-content:center;
align-items: center;
text-align: center;">Welcome back! <br/> Nice to see you again!</div>

<div class="SignUpSocial mr-5" style="float:right; padding-bottom:10px;">
                                                   
                                                     <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>
                                                     <!-- <a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white; background:#F14336; border-color:unset !important;"><i class="fa fa-google"></i></a> -->
                                                     <a href="javascript:void()" class="m-1 float-right ml-2"
                        style="cursor: pointer;"><img src="assets/images-new/googleIcon.png" style="height: 35px;border-radius: 50%;width: 35px;""></a>
                                                </div>
                    <div class="form-group" style="padding-left: 15%;">
                        <label for="exampleInputUsername" class="sr-only">Username</label>
                        <div class="position-relative has-icon-right">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror newloginform" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-mail" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-control-position">
                              
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="padding-left: 15%;">
                        <label for="exampleInputPassword" class="sr-only">Password</label>
                        <div class="position-relative has-icon-right">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror newloginform" name="password" required autocomplete="current-password" placeholder="Password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-control-position">
                               
                            </div>
                        </div>
                    </div>
                    <div class="form-row" style="padding-left: 15%;">
                        <div class="form-group col-6">
                            <div class="icheck-material-primary form-check pl-0 CustomCheckbox">

                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label ForRemember" for="remember">
                                    {{ __('Remember Me') }}
                                </label>

                            </div>
                        </div>

                        <div class="SignUpLink col-6">
                             <p class="mr-5" style="color: #9C9C9C;text-decoration:underline;font-weight: bold;margin-right: 3rem;"> <a style="color: #9C9C9C;font-weight: bold;" href="{{url('forgotPassword')}}">Forgot Password?</a></p>
                        </div>
                        <!--<div class="form-group col-6 text-right pr-0">-->
                        <!--    @if (Route::has('password.request'))-->
                        <!--    <a class="btn btn-link" href="{{ route('password.request') }}">-->
                        <!--        {{ __('Reset Password') }}-->
                        <!--    </a>-->
                        <!--    @endif-->
                        <!--</div>-->
                    </div>
                 

                    <div class="sign-in-button col-md-12">
                        <div class="SubmitButton col-md-6" style="padding-left: 15% !important;">
                           <button type="submit" class="btn btn-primary btn-block New-Login">Log In</button>
                        </div>
                        <div class="SignUpLink col-md-6">
                             <p class="text-dark mb-0 ml-4 signUpAnchor" style="color:#1E1E1E; text-decoration:underline;font-weight: bold;"> <a style="color:#1E1E1E;font-weight: bold;" href="{{ url('userRegister') }}">or Sign Up</a></p>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <!--<div class="card-footer text-center py-3">-->
       
    <!--</div>-->
                                                </div>
                                                 <div class="col-md-6" style="text-align: center;">
                                                <img src="assets/images-new/OBJECTS.png" class="">
                                                </div>
                                                </div>
        
        
        
        
        
</div>


</div>
@endsection