@extends('layouts.NewAppFront')

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

<div class="col-6 text-right pr-0" style="float:right; padding-bottom:10px;">
                                                   

                                                    <a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white; background:#F14336; border-color:unset !important;"><i class="fa fa-google"></i></a>
                                                     <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>
                                                </div>
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-row">
                        <div class="form-group col-6">
                            <div class="icheck-material-primary form-check pl-0 CustomCheckbox">

                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label ForRemember" for="remember">
                                    {{ __('Remember Me') }}
                                </label>

                            </div>
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
                        <div class="SubmitButton col-md-6">
                           <button type="submit" class="btn btn-primary btn-block New-Login">Sign In</button>
                        </div>
                        <div class="SignUpLink col-md-6">
                             <p class="text-dark mb-0" style="color:#000; text-decoration:underline;"> <a style="color:#000;" href="{{ url('userRegister') }}">Or Sign Up here</a></p>
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