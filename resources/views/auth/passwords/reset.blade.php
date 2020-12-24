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

<div class="container NewLogin" style="padding-top: 80px;">

    <div class="row justify-content-center">

    <div class="col-md-12 row" style="    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;">

    	<div class="col-md-6">

    	<div class="card-body">

    		<form method="POST" action="{{ route('password.update') }}" style="margin:0 auto; width:80%;" class="">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                    <div class="card-title  text-center py-3" style="    font-family: Open Sans;
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 33px;">
                    Great! <br/> Now create a new password!</div>

                    <div class="form-group">
                        <div class="position-relative has-icon-right">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="margin-left: 8%;" placeholder="New Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="position-relative has-icon-right">
                            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" style="margin-left: 8%;" placeholder="Confirm Password">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
    
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
    align-content: center;">Done!</button></div>
    
   

            </form>


    	</div>

    </div>

    <div class="col-md-6 pl-5 text-center">
    	<img src="../../assets/images-new/forgotPass2.png" class="">
    </div>



    </div>

   </div>



</div>

@endsection