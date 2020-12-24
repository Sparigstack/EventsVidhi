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
}
</style>
@endsection
@section('content')

<div class="container NewLogin" style="padding-top: 20px;">

    <div class="col-md-12 col-lg-12 align-items-center mb-3 ml-5" style="display: flex;">
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

color: #9C9C9C;" href="{{route('login')}}">
                                                        <i class="fa fa-angle-left"></i>&nbsp; Back</a>
    </div>

    <div class="row justify-content-center">

    <div class="col-md-12 row" style="    display: flex;
    justify-content: center;
    /*align-items: center;*/
    align-content: center;">

    	<div class="col-md-6">

    	<div class="card-body">

    		<form method="POST" action="{{ route('password.email') }}" style="margin:0 auto; width:80%;" class="">
                    @csrf
                    <div class="card-title  text-center py-3 mb-5 pb-3 mt-3" style="    font-family: Open Sans;
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 33px;">
                    Forgot password? <br/> Don't worry, it's easy to fix!</div>

                    <div class="form-group emailValid mb-5">
                        <label for="exampleInputEmailId" class="sr-only">Email ID</label>
                        <div class="position-relative has-icon-right">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" style="margin-left: 8%;" placeholder="E-mail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
                        <button type="submit"  class="btn btn-primary btn-block waves-effect " id="" onclick="" style="background: #FD6568;
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
    align-content: center;">Send Email</button>


</div>

<div class="SignUpLink mt-4">
        <button type="submit" class="" style="border: none;
    background-color: white;
    text-decoration: underline;"> <a style="color: #9C9C9C;font-weight: bold;cursor:pointer; ">Send email again</a></button>
                        </div>
    
   

            </form>


    	</div>

    </div>

    <div class="col-md-6 text-center">
    	<img src="assets/images-new/forgotPass1.png" class="">
    </div>



    </div>

   </div>



</div>

@endsection