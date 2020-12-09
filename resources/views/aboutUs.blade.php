@extends('layouts.appFront')
@section('content')

<div class="container mainHomePageContainer pt-3 pb-3" style="">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-5"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-5" style="background:url('{{asset('assets/images-new/about-banner.png')}}'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:350px; padding:unset;border-radius:6px;">
        <div class="col-md-12 d-flex justify-content-center">
           <div class="bannerText text-center">
                <h4 class="fontSizeCss aboutUsBannerTxt" style=""> At Panelhive, we believe learning should <br>be an experience to remember</h4>
            </div>
        </div>
    </div>

    <div class="aboutUsDiv mb-5">
    	<div class="aboutUsCardCss" style="">
			<div class="bannerText">
                <p class="fontSizeCss aboutPara mb-0" style=""> We strive to bring you events and other media to help you advance your skills and stay in sync with topics of your interest. With our advanced features, we wish to provide one-stop platform for organisers to organise events and workshops and for users to enjoy the content with ease. We hope to bring you the best experience!</p>
            </div>
    	</div>
    </div>


</div>

@endsection