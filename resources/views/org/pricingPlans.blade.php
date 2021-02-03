@extends('layouts.appOrg')
@section('content')

<div class="container mainHomePageContainer pt-3 pb-3 pl-0 pr-0" style="">

	<div class="card mb-4 col-md-10 m-auto" style="">
		<div class="row col-md-12 col-lg-12 col-sm-12">
			<div class="col-md-6 col-lg-6 col-sm-12">
				<img class="plansOuterImg" style="left:63%;" src="../assets/images-new/Plans.png" />
			</div>

			<div class="col-md-6 col-lg-6 col-sm-12">
				<div class="mt-5">
					<h4><u>PRICING & PLANS</u></h4>
				</div>

				<div class="mt-5">
					<h4>PRICING</h4>
					<p style="line-height: 25px;">With our simple straightforward pricing, you can enjoy hassle free setup of events and workshops and create a lasting experience.</p>
					<h5 class="mt-4">2% processing fee per ticket</h5> 
					<p>*no additional admin or processing charges</p>
					<h6 class="mt-4">Got a free event?  Great! We won’t charge you either!</h6>
				</div>
			</div>
		</div>

		<div class="row" style="padding: 80px;">
			<div class="col-md-8 col-lg-8">
				<h4>PLANS</h4>
				<p class="mt-4" style="line-height: 25px;">We want you to not only hold one off session, but leave a trail! Leave a mark and build up your community!  We therefore, provide you the opportunity of saving up your sessions and content on your channel for your existing as well as future followers! Don’t just archive the past sessions, save it for easy access by your followers!</p>
				<h6 class="mt-4" style="line-height: 25px;">Choose the right storage plan for your content requirements from our offering, and showcase all your past events too!</h6>
			</div>
		</div>

		<div class="row d-flex justify-content-center" style="padding: 40px;padding-top: 0px;padding-bottom: 20px;">
			<div class="col-md-4 col-lg-4 col-sm-8 text-center mxwidthorg-30" style="padding-top: 45px;">
				<div class="card plansCard" style="">
					<h5 class="mt-4"> BASIC </h4>
					<h4 class="mt-4"> Free </h4>
					<p class="mt-4"> 3 gb of cloud space to upload & showcase content </p>
					<a class="mt-4 mb-4"><input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Want it!" style="padding: 8px 40px;" disabled="disabled"></a>
				</div>
			</div>

			<div class="col-md-4 col-lg-4 col-sm-8 text-center mxwidthorg-30" style="">
				<div class="card plansCard" style="border: 2px solid #FD6568 !important;">
					<h5 class="mt-4"> PLUS </h4>
					<p class="mt-2" style="color: #9C9C9C;"> *price per month </p>
					<div class="d-flex justify-content-center">
						<h4> $3 </h4>
						<p class="mt-1 ml-1"> billed yearly </p>
					</div>
					<div class="d-flex justify-content-center">
						<h4> $4.5 </h4>
						<p class="mt-1 ml-1">  billed monthly </p>
					</div>
					<p class="mt-3"> 10 gb of cloud space to upload & showcase content </p>
					<a href="{{url('planDetails/2')}}" class="mt-4 mb-4"><input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Want it!" style="padding: 8px 40px;"></a>
				</div>
			</div>

			<div class="col-md-4 col-lg-4 col-sm-8 text-center mxwidthorg-30" style="">
				<div class="card plansCard" style="padding: 20px 13px;">
					<h5 class="mt-4"> PREMIUM </h4>
					<p class="mt-2" style="color: #9C9C9C;"> *price per month </p>
					<div class="d-flex justify-content-center">
						<h4> $7 </h4>
						<p class="mt-1 ml-1"> billed yearly </p>
					</div>
					<div class="d-flex justify-content-center">
						<h4> $12 </h4>
						<p class="mt-1 ml-1"> billed monthly </p>
					</div>
					<p class="mt-3"> <b> Unlimited </b> of cloud space to upload & showcase content </p>
					<a href="{{url('planDetails/3')}}" class="mt-4 mb-4"><input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Want it!" style="padding: 8px 40px;"></a>
				</div>
			</div>

		</div>

		<div class="row mb-5">
			<div class="col-md-7"></div>
			<div class="col-md-4 row">
				<div class="col-md-10 pull-right mt-5 pt-3 pr-0"><p class="">Any Questions?&nbsp;&nbsp;<a target="_blank" href="{{url('contactUs')}}"><b><u>Message Us</u></b></a></p></div>
				<div class="col-md-2 pull-right"><img src="../assets/images-new/plansImage2.png"></div>
			</div>
		</div>

    </div>

</div>
@endsection