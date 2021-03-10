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
    .form-group{
        display: flex;
        justify-content: center;
    }
}
</style>
@endsection
@section('content')
<div class="container NewLogin" style="padding-top: 20px;">

    <div class="col-md-12 col-lg-12 align-items-center ml-5 backButton d-none" style="display: flex;">
        <a class="" style="font-family: Open Sans;
font-style: normal;
font-weight: 300;
font-size: 14px;
line-height: 19px;
/* identical to box height */

display: flex;
align-items: center;
cursor:pointer;
/* Text/Icon DarkGray */

color: #9C9C9C;" onclick="GotoFirstStep();">
                                                        <i class="fa fa-angle-left"></i>&nbsp; Back</a>
    </div>

    <div class="col-md-12 col-lg-12 align-items-center ml-5 previousButton d-none" style="display: flex;">
                                                        
                                                         <a class="" style="font-family: Open Sans;
font-style: normal;
font-weight: 300;
font-size: 14px;
line-height: 19px;
/* identical to box height */

display: flex;
align-items: center;
cursor:pointer;
/* Text/Icon DarkGray */

color: #9C9C9C;" onclick="GotoPreviousStep();">
                                                        <i class="fa fa-angle-left"></i>&nbsp; Previous Step</a>
                                                        
                                                    </div>

    <div class="row justify-content-center">

        
        <div class="col-md-12 row NextHide" style="    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;">
                                            <div class="col-md-6">
                                                <div class="StartupPage">
                                                    
                                                   
                                                 <div class="card-title  text-center py-3" style="    font-family: Open Sans;
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 33px;">
                    Welcome to Panelhive! <br/> Lets’s help you get started!</div>
                                               <div class="col-md-12 row" style="display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;padding: 20px 0px;">

    <span style="background: #FD6568;
    border-radius: 25px;
    font-family: Open Sans;
    font-style: normal;
    font-size: 14px;
    line-height: 19px;
    display: flex;
    align-items: center;
    text-align: center;
    color: #FFFFFF;
    font-weight: bold;
    padding: 10px 25px;cursor:pointer;" onclick="ShowFormOrgRegister(this);" class="mr-5">I’m an Organizer!</span>
                                                   
                                                   <span style="background: #FD6568;
    border-radius: 25px;
    font-family: Open Sans;
    font-style: normal;
    font-size: 14px;
    line-height: 19px;
    display: flex;
    align-items: center;
    text-align: center;
    color: #FFFFFF;
    font-weight: bold;
    padding: 10px 25px;cursor:pointer;" onclick="ShowForm(this);">I’m a User!</span>
                                                   </div> 
                                                   <div class="card-footer text-center py-3" style="border-top: unset;">
        <p class="text-dark mb-0" style="font-family: Open Sans;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 19px;
    text-decoration-line: underline;
    color: #9C9C9C !important;
    text-align: center;"><a href="{{ route('login') }}" style="    color: #9C9C9C !important;"> I already have an account</a></p>
    </div>
                                                </div>
                                                
                                                <div class="card-body ActualForm d-none pt-0" >
                                                    
            <!--<form method="POST" action="{{ route('register') }}" style="margin:0 auto; width:80%;" class="Nexthidden">-->
                <form method="POST" action="" style="margin:0 auto; width:80%;" class="Nexthidden">

                    <input class="urlStringUserReg" type="hidden" value="{{ route('register') }}">

                    <input class="homePage" type="hidden" value="{{ url('/') }}">

                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                
               <?php
               $checkUrl = "";
               $dnoneClass = "";
               // $labelSignUp = "Organizer Sign Up";
               $labelSignUp = "Let's get your account setup";
                if (strpos($_SERVER['REQUEST_URI'], '/userRegister') !== false) {
                        // $checkUrl = "1";
                        $dnoneClass = "d-none";
                        $labelSignUp = "Let's get your account setup";
                } ?>
                @csrf
                <input type="hidden" name="checkUrl" value="1">
                <div class="card-content p-2 MobWidth">
                    
                    <div class="card-title py-3 ml-5" style="font-size: 18px;">
                    {{$labelSignUp}}</div>
                    
                    <div class="SignUpSocial mr-4">
                        
                        <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right"
                        style="color:white;"><i class="fa fa-facebook"></i></a>
                        <!-- <a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right"
                        style="color:white; background:#F14336; border-color:unset !important;"><i class="fa fa-google"></i></a> -->
                        <a href="javascript:void()" class="m-1 float-right ml-2"
                        style="cursor: pointer;"><img src="assets/images-new/googleIcon.png" style="height: 35px;border-radius: 50%;width: 35px;"></a>
                    </div>

                    <div class="form-group SignUp-Four-Form" style="padding-top:10px;">
                        <label for="exampleInputName" class="sr-only">Name</label>
                        <div class="position-relative has-icon-right">
                            <input id="name" onchange="ChangeName(this)" type="text" class="form-control @error('name') is-invalid @enderror RegName" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Username">
                            <div class="form-control-position">
                                <!--<i class="icon-user"></i>-->
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group emailValid">
                        <label for="exampleInputEmailId" class="sr-only">Email ID</label>
                        <div class="position-relative has-icon-right">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                            <span class="text-danger emailValidation d-none">The email has already been taken</span>
                            <div class="form-control-position">
                                <!--<i class="icon-envelope-open"></i>-->
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword" class="sr-only">Password</label>
                        <div class="position-relative has-icon-right">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                            <span class="text-danger passValidation d-none">Password must be atleast 8 characters</span>
                            <div class="form-control-position">
                                <!--<i class="icon-lock"></i>-->
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword" class="sr-only">Confirm Password</label>
                        <div class="position-relative has-icon-right">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            <span class="text-danger confirmpassValidation d-none">Password and confirm password must be same</span>
                            <div class="form-control-position">
                                <!--<i class="icon-lock"></i>-->
                            </div>
                        </div>
                    </div>

    <!--                <div class="form-group" style="    display: flex;-->
    <!--align-items: center;-->
    <!--justify-content: center;">-->
                       <button type="" class="btn btn-primary btn-block waves-effect waves-light d-none" id="SignUpButton" style="">Sign Up</button>
        <!-- </div>-->
    
    <div class="form-group" style="    display: flex;
    align-items: center;
    justify-content: center; margin-top:20px;" >
                        <button type="submit"  class="btn btn-primary btn-block waves-effect " id="NextButton" onclick="return GoToNextStep(this);" style="background: #FD6568;
    border-radius: 25px;
    font-family: Open Sans;
    font-style: normal;
    font-size: 14px;
    line-height: 19px;
    align-items: center;
    text-align: center;
    color: #FFFFFF;
    padding: 10px 45px;
    cursor: pointer;
    border: unset !important;
    width: auto;
    text-align: center;
    font-weight: bold;
    text-transform:capitalize !important;
    align-content: center;">Next</button>

        <i class="fa fa-spinner fa-spin fr d-none spinnerNext" style="font-size:24px;margin-left: 5px;"></i>

</div>
    
   

            </form>

            <p class="" style="color: #9C9C9C;font-weight: bold;"> By selecting ‘Next’, I agree I have read Panelhive’s <a style="color: #9C9C9C;font-weight: bold;text-decoration:underline;" href="#">Privacy Policy</a>
and agree with <a style="color: #9C9C9C;font-weight: bold;text-decoration:underline;" href="#">Terms of Service!</a> </p>
        </div>
         
                    <p class="{{$dnoneClass}} d-none">Sign up for free account, you can create and showcase your events, manage customer data and use upto 3 gb space for your videos and podcasts.</p>
    </div>

    <div class="card-body ActualOrgRegisterForm d-none" >
                                                    
            <!--<form method="POST" action="{{ route('register') }}" style="margin:0 auto; width:80%;" class="Nexthidden">-->

                <div class="col-md-12 row">
                <form method="POST" action="" style="margin:0 auto; width:80%;" class="NexthiddenOrgReg">

                <input class="urlStringOrgReg" type="hidden" value="{{ route('register') }}">

                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                
               <?php
               $checkUrl = "";
               $dnoneClass = "";
               // $labelSignUp = "Organizer Sign Up";
               $labelSignUp = "Let's get your account setup";
                if (strpos($_SERVER['REQUEST_URI'], '/userRegister') !== false) {
                        // $checkUrl = "";
                        $dnoneClass = "d-none";
                        $labelSignUp = "Let's get your account setup";
                } ?>
                @csrf
                <input type="hidden" name="checkUrl" value="">
                <div class="card-content p-2 MobWidth">
                    
                    <div class="card-title py-3 ml-5" style="font-size: 18px;">
                    {{$labelSignUp}}</div>
                    
                    <div class="SignUpSocial mb-3">
                        
                        <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right"
                        style="color:white;"><i class="fa fa-facebook"></i></a>
                        <!-- <a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right"
                        style="color:white; background:#F14336; border-color:unset !important;"><i class="fa fa-google"></i></a> -->
                        <a href="javascript:void()" class="m-1 float-right ml-2"
                        style="cursor: pointer;"><img src="assets/images-new/googleIcon.png" style="height: 35px;border-radius: 50%;width: 35px;"></a>
                    </div>

                    
                    <div class="form-group emailValid">
                        <label for="exampleInputEmailId" class="sr-only">Email ID</label>
                        <div class="position-relative has-icon-right">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror orgEmail" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                            <span class="text-danger emailValidation d-none">The email has already been taken</span>
                            <div class="form-control-position">
                                <!--<i class="icon-envelope-open"></i>-->
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword" class="sr-only">Password</label>
                        <div class="position-relative has-icon-right">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror orgPass" name="password" required autocomplete="new-password" placeholder="Password">
                            <span class="text-danger passValidation d-none">Password must be atleast 8 characters</span>
                            <div class="form-control-position">
                                <!--<i class="icon-lock"></i>-->
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword" class="sr-only">Confirm Password</label>
                        <div class="position-relative has-icon-right">
                            <input id="password-confirm" type="password" class="form-control orgConfirmPass" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            <span class="text-danger confirmpassValidation d-none">Password and confirm password must be same</span>
                            <div class="form-control-position">
                                <!--<i class="icon-lock"></i>-->
                            </div>
                        </div>
                    </div>

    <!--                <div class="form-group" style="    display: flex;-->
    <!--align-items: center;-->
    <!--justify-content: center;">-->
                       <button type="" class="btn btn-primary btn-block waves-effect waves-light d-none" id="SignUpButton" style="">Sign Up</button>
        <!-- </div>-->

                        <div class="form-group" style="    display: flex;
    align-items: center;
    justify-content: center; margin-top:20px;">
                        <button type="submit" class="btn btn-primary btn-block waves-effect " id="DoneButton" onclick="return GoToNextOrgRegStep();" style="background: #FD6568;
    border-radius: 25px;
    font-family: Open Sans;
    font-style: normal;
    font-size: 14px;
    line-height: 19px;
    align-items: center;
    text-align: center;
    color: #FFFFFF;
    padding: 10px 45px;
    cursor: pointer;
    border: unset !important;
    width: auto;
    text-align: center;
    font-weight: bold;
    text-transform:capitalize !important;
    align-content: center;">Done!</button>

    <i class="fa fa-spinner fa-spin fr d-none spinnerClass" style="font-size:24px;margin-left: 5px;"></i>


</div>

<p class="" style="color: #9C9C9C;font-weight: bold;"> By selecting ‘Done!’, I agree I have read Panelhive’s <a style="color: #9C9C9C;font-weight: bold;text-decoration:underline;" href="#">Privacy Policy</a>
and agree with <a style="color: #9C9C9C;font-weight: bold;text-decoration:underline;" href="#">Terms of Service!</a> </p>


            </form>
        </div>

            


        </div>

        
    </div>

    <div class="card-body ActualOrgRegisterFormNext d-none" >
            <!--<form method="POST" action="{{ route('register') }}" style="margin:0 auto; width:80%;" class="Nexthidden">-->
            <div class="col-md-12 row">
                <form method="POST" action="" style="margin:0 auto; width:80%;" class="NexthiddenUpdateOrgReg">

                    <input class="urlStringUpdateOrgReg" type="hidden" value="{{ route('register') }}">

                    <input class="profilePage" type="hidden" value="{{ url('org/profile') }}">

                    <input class="newOrgId" type="hidden" value="" name="newOrgId">

                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                
               <?php
               $checkUrl = "";
               $dnoneClass = "";
               // $labelSignUp = "Organizer Sign Up";
               $labelSignUp = "Tell us more about yourself";
                if (strpos($_SERVER['REQUEST_URI'], '/userRegister') !== false) {
                        // $checkUrl = "1";
                        $dnoneClass = "d-none";
                        $labelSignUp = "Tell us more about yourself";
                } ?>
                @csrf
                <input type="hidden" name="checkUrl" value="">
                <div class="card-content p-2 MobWidth">
                    
                    <div class="card-title py-5 ml-5 pl-2">
                    {{$labelSignUp}}</div>
                    
                    <!-- <div class="SignUpSocial">
                        
                        <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right"
                        style="color:white;"><i class="fa fa-facebook"></i></a>
                        <a href="javascript:void()" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right"
                        style="color:white; background:#F14336; border-color:unset !important;"><i class="fa fa-google"></i></a>
                    </div> -->

                    
                    <div class="form-group">
                        <label for="exampleInputBusinessName" class="sr-only">Business Name</label>
                        <div class="position-relative has-icon-right">
                            <input id="businessName" type="text" class="form-control" name="businessName" value="{{ old('businessName') }}" required autocomplete="businessName" placeholder="Account Name" onchange="ChangeBusinessName(this)">
                            <div class="form-control-position">
                                <!--<i class="icon-envelope-open"></i>-->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputWebsite" class="sr-only">Website</label>
                        <div class="position-relative has-icon-right">
                            <input id="website" type="url" class="form-control" name="website" autocomplete="website" placeholder="Website">
                            <div class="form-control-position">
                                <!--<i class="icon-lock"></i>-->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputLocation" class="sr-only">Location</label>
                        <div class="position-relative has-icon-right">
                            <input id="location" type="text" class="form-control" name="location" required autocomplete="location" placeholder="Location">
                            <div class="form-control-position">
                                <!--<i class="icon-lock"></i>-->
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="exampleInputPassword" class="sr-only">Confirm Password</label>
                        <div class="position-relative has-icon-right">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                        </div>
                    </div> -->

    <!--                <div class="form-group" style="    display: flex;-->
    <!--align-items: center;-->
    <!--justify-content: center;">-->
                       <button type="" class="btn btn-primary btn-block waves-effect waves-light d-none" id="SignUpButton" style="">Sign Up</button>
        <!-- </div>-->

                        <div class="form-group" style="    display: flex;
    align-items: center;
    justify-content: center; margin-top:20px;">
                        <button type="submit" class="btn btn-primary btn-block waves-effect " id="NextStepOrgButton" onclick="return GoToNextOrgRegStep1();" style="background: #FD6568;
    border-radius: 25px;
    font-family: Open Sans;
    font-style: normal;
    font-size: 14px;
    line-height: 19px;
    align-items: center;
    text-align: center;
    color: #FFFFFF;
    padding: 10px 45px;
    cursor: pointer;
    border: unset !important;
    width: auto;
    text-align: center;
    font-weight: bold;
    text-transform:capitalize !important;
    align-content: center;">Next</button>

<i class="fa fa-spinner fa-spin fr d-none spinnerClassNext" style="font-size:24px;margin-left: 5px;"></i>

</div>

            </form>
        </div>


        </div>


    </div>

    
</div>

                                            
                                                <div class="col-md-6 HiddenImageOnclick">
                                                     <img src="assets/images-new/Layer 7.png" class="">
                                                </div>

                                                <div class="col-md-6 HiddenOrgImageOnclick d-none text-center">
                                                     <img src="assets/images-new/Layer 2.png" class="">
                                                </div>

                                                <div class="col-md-6 HiddenOrgImageOnclick1 d-none ">
                                                     <img src="assets/images-new/OrgRegister.png" class="">
                                                </div>

                                                <div class="col-md-6 HiddenUserImageOnclick d-none text-center">
                                                     <img src="assets/images-new/userRegister.png" class="">
                                                </div>
        </div>
        
        
            <div class="col-md-12 row LetsStart-Section d-none ">
        
                <div class="col-md-6  card-title text-center py-3">
                    Congratulations, <span class="register-user-name"></span> ! Now you are part of the community!

                    <div class="form-group" style="
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top:25px;
    /*text-align: left;*/
    font-weight: 500;
    ">
                        <p class="ml-2"> Please click verification link that we have sent you at your email address to get started. </p>

</div>


                     <div class="form-group d-none" style="    display: flex;
    align-items: center;
    justify-content: center; margin-top:40px;">
                        <button class="btn btn-primary btn-block waves-effect" id="LetsStartButton" style="background: #FD6568;
    border-radius: 25px;
    font-family: Open Sans;
    font-style: normal;
    font-size: 14px;
    line-height: 19px;
    /* display: flex; */
    align-items: center;
    text-align: center;
    color: #FFFFFF;
    padding: 10px 45px;
    cursor: pointer;
    border: unset !important;
    width: auto;
    text-align: center;
    align-content: center;" onclick="redirecttohomepage();">Let's Start!</button></div>
                </div>
                
                <div class="col-md-6 text-center">
                    <img src="assets/images-new/OBJECTS.png" class="">
                </div>
            </div>

            <div class="col-md-12 row LetsStartOrgReg-Section d-none ">
        
                <div class="col-md-6  card-title text-center py-3">
                    Congratulations, <span class="register-user-name"></span> ! Now you are part of the community!

                    <div class="form-group" style="
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top:25px;
    /*text-align: left;*/
    font-weight: 500;
    ">
                        <p class="ml-2">To add your first event, you simply need to verify your email address with us. Please click verification link that we have sent you at your email address. </p>

</div>


                     <div class="form-group d-none" style="    display: flex;
    align-items: center;
    justify-content: center; margin-top:40px;">
                        <button class="btn btn-primary btn-block waves-effect" id="LetsStartButton" style="background: #FD6568;
    border-radius: 25px;
    font-family: Open Sans;
    font-style: normal;
    font-size: 14px;
    line-height: 19px;
    /* display: flex; */
    align-items: center;
    text-align: center;
    color: #FFFFFF;
    padding: 10px 45px;
    cursor: pointer;
    border: unset !important;
    width: auto;
    text-align: center;
    align-content: center;" onclick="redirecttoorgprofilepage();">Let's Start!</button></div>
                </div>
                
                <div class="col-md-6 text-center">
                    <img src="assets/images-new/OBJECTS.png" class="">
                </div>
            </div>



        
            </div>
        


</div>

@endsection

@section('script')
<script>

    $(document).ready(function () {
        // $('#SignUpButton').on('submit', function (event) {
        //     event.preventDefault();
        // });
    });
    
    function ShowForm(element){
        $(".StartupPage").addClass("d-none");
        $(".ActualForm").removeClass("d-none");
        $(".HiddenImageOnclick").addClass("d-none");
        $(".HiddenUserImageOnclick").removeClass("d-none");
        $(".backButton").removeClass("d-none");
    }

    function ShowFormOrgRegister(element){
        $(".StartupPage").addClass("d-none");
        $(".ActualForm").addClass("d-none");
        $(".ActualOrgRegisterForm").removeClass("d-none");
        $(".HiddenImageOnclick").addClass("d-none");
        $(".HiddenOrgImageOnclick").addClass("d-none");
        $(".HiddenOrgImageOnclick1").removeClass("d-none");
        $(".backButton").removeClass("d-none");
    }

    function GotoFirstStep(){
         $(".StartupPage").removeClass("d-none");
         $(".ActualForm").addClass("d-none");
         $(".ActualForm").addClass("d-none");
         $(".ActualOrgRegisterForm").addClass("d-none");
         $(".HiddenImageOnclick").removeClass("d-none");
         $(".HiddenOrgImageOnclick").addClass("d-none");
         $(".HiddenOrgImageOnclick1").addClass("d-none");
         $(".HiddenUserImageOnclick").addClass("d-none");
         $(".backButton").addClass("d-none");
    }

    function GotoPreviousStep(){
         // $(".StartupPage").removeClass("d-none");
         // $(".ActualForm").addClass("d-none");
         // $(".ActualForm").addClass("d-none");
         $(".ActualOrgRegisterForm").removeClass("d-none");
         $(".ActualOrgRegisterFormNext").addClass("d-none");
         $(".backButton").removeClass("d-none");
         $(".HiddenOrgImageOnclick").addClass("d-none");
         $(".HiddenOrgImageOnclick1").removeClass("d-none");
         $(".previousButton").addClass("d-none");
         // $(".HiddenImageOnclick").removeClass("d-none");
    }

    function GoToNextStep(element){
            if($('#name').val()=='' || $('#email').val()=='' || $('#password').val()=='' || $('#password-confirm').val()==''){
                //alert('Please fill all fields');
                // return;
            } else{
                $(".passValidation").addClass('d-none');
                $(".confirmpassValidation").addClass('d-none');
                if($('#password').val().length < 8) {
                    //alert('Password must be atleast 8 characters');
                    $(".passValidation").removeClass('d-none');
                    return false;
                } else if($('#password-confirm').val()!=$('#password').val()){
                    //alert('Password and confirm password must be same');
                    $(".confirmpassValidation").removeClass('d-none');
                    return false;
                } else {
                    $('.Nexthidden').on('submit', function (e) {
                        e.preventDefault();
                        var CurentForm = $(this);
                        var formData = new FormData(this);
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
                        var urlStringUserReg = $(".urlStringUserReg").val();
                        $(".spinnerNext").removeClass('d-none');
                        $.ajax({
                            url: urlStringUserReg,
                            method: "POST",
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                //console.log(response);
                                $(".spinnerNext").addClass('d-none');
                                if(response.statusText == "Unprocessable Entity"){
                                     //alert('The email has already been taken');
                                     $(".emailValidation").removeClass("d-none");
                                     return false;
                                } else {
                                    $(".emailValidation").addClass("d-none");
                                $(".NextHide").addClass("d-none");
                                $(".LetsStart-Section").removeClass("d-none");
                                $(".backButton").addClass("d-none");
                                $(".HiddenUserImageOnclick").addClass("d-none");
                                }
                            },
                            error: function (err) {
                                //console.log(err);
                                $(".spinnerNext").addClass('d-none');
                                if(err.statusText == "Unprocessable Entity"){
                                    //alert('The email has already been taken');
                                    $(".emailValidation").removeClass("d-none");
                                    return false;
                                } else {
                                    $(".emailValidation").addClass("d-none");
                                $(".NextHide").addClass("d-none");
                                $(".LetsStart-Section").removeClass("d-none");
                                $(".backButton").addClass("d-none");
                                $(".HiddenUserImageOnclick").addClass("d-none");
                                 }
                            }

                        });
                    });
                }
                // The email has already been taken.
            }
    }
    function GoToNextOrgRegStep(){
            if($('.orgEmail').val()=='' || $('.orgPass').val()=='' || $('.orgConfirmPass').val()==''){
                //alert('Please fill all fields');
                // return;
            } else{
                $(".passValidation").addClass('d-none');
                $(".confirmpassValidation").addClass('d-none');
                if($('.orgPass').val().length < 8) {
                    //alert('Password must be atleast 8 characters');
                    $(".passValidation").removeClass('d-none');
                    return false;
                } else if($('.orgConfirmPass').val()!=$('.orgPass').val()){
                    //alert('Password and confirm password must be same');
                    $(".confirmpassValidation").removeClass('d-none');
                    return false;
                } else {
                    $('.NexthiddenOrgReg').on('submit', function (e) {
                        e.preventDefault();
                        var CurentForm = $(this);
                        var formData = new FormData(this);
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
                        var urlStringUserReg = $(".urlStringOrgReg").val();
                        $(".spinnerClass").removeClass('d-none');
                        $.ajax({
                            url: urlStringUserReg,
                            method: "POST",
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            async:true,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                 //console.log(response);
                                 $(".spinnerClass").addClass('d-none');
                                if(response.statusText == "Unprocessable Entity"){
                                     //alert('The email has already been taken');
                                     $(".emailValidation").removeClass("d-none");
                                     return false;
                                } else {
                                    $(".emailValidation").addClass("d-none");
                                $(".ActualOrgRegisterFormNext").removeClass("d-none");
                                $(".ActualOrgRegisterForm").addClass("d-none");
                                $(".newOrgId").val(response);
                                //$(".spinnerClass").addClass('d-none');
                                $(".backButton").addClass("d-none");
                                $(".previousButton").removeClass("d-none");
                                $(".HiddenOrgImageOnclick").removeClass("d-none");
                                $(".HiddenOrgImageOnclick1").addClass("d-none");
                                }
                            },
                            error: function (err) {
                                 //console.log(err);
                                 $(".spinnerClass").addClass('d-none');
                                if(err.statusText == "Unprocessable Entity"){
                                     //alert('The email has already been taken');
                                     $(".emailValidation").removeClass("d-none");
                                     return false;
                                } else {
                                $(".emailValidation").addClass("d-none");
                                $(".ActualOrgRegisterFormNext").removeClass("d-none");
                                $(".ActualOrgRegisterForm").addClass("d-none");
                                $(".newOrgId").val(err);
                                //$(".spinnerClass").addClass('d-none');
                                $(".backButton").addClass("d-none");
                                $(".previousButton").removeClass("d-none");
                                $(".HiddenOrgImageOnclick").removeClass("d-none");
                                $(".HiddenOrgImageOnclick1").addClass("d-none");
                                }
                            }

                        });
                    });
                }
                // The email has already been taken.
            }
    }

    function GoToNextOrgRegStep1(){
        
            if($('#businessName').val()=='' || $('#location').val()==''){
                //alert('Please fill all fields');
                // return;
            } else{
                    $('.NexthiddenUpdateOrgReg').on('submit', function (e) {
                        e.preventDefault();
                        var CurentForm = $(this);
                        var formData = new FormData(this);
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
                        var urlStringUpdateOrgReg = $(".urlStringUpdateOrgReg").val();
                        $(".spinnerClassNext").removeClass('d-none');
                        $.ajax({
                            url: urlStringUpdateOrgReg,
                            method: "POST",
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            async:true,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                // console.log(response);
                                $(".ActualOrgRegisterFormNext").addClass("d-none");
                                $(".LetsStartOrgReg-Section").removeClass("d-none");
                                $(".spinnerClassNext").addClass('d-none');
                                $(".previousButton").addClass("d-none");
                                $(".backButton").addClass("d-none");
                                $(".HiddenOrgImageOnclick").addClass("d-none");
                            },
                            error: function (err) {
                                // console.log(err);
                                $(".ActualOrgRegisterFormNext").addClass("d-none");
                                $(".LetsStartOrgReg-Section").removeClass("d-none");
                                $(".spinnerClassNext").addClass('d-none');
                                $(".previousButton").addClass("d-none");
                                $(".backButton").addClass("d-none");
                                $(".HiddenOrgImageOnclick").addClass("d-none");
                            }

                        });
                    });
                // The email has already been taken.
            }
    }

    function ChangeName(element){
        $(".register-user-name").text(element.value);
    }
    function ChangeBusinessName(element){
        $(".register-user-name").text(element.value);
    }
    function redirecttohomepage(){
        var homePage = $(".homePage").val();
        window.location.href = homePage;
        // $("#SignUpButton").trigger('click');
        // $('#button-1').trigger('click');
        // $('#button-1').trigger(e.type);
    }
    function redirecttoorgprofilepage(){
        var profilePage = $(".profilePage").val();
        window.location.href = profilePage;
    }
      
</script>


@endsection