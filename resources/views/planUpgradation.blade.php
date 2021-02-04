@extends('layouts.appFront')
@section('content')
<div class="container mainHomePageContainer mt-5 mb-5 pl-0 pr-0 pb-5" style="">

	<div class="card col-md-8 m-auto container upgradeSuccessCard" style="">
		<div class="row">
			<div class="col-md-6 mt-5">
				<h5>Your plan has been Upgraded!</h5>
				<p class="mt-5 pt-3" style="font-weight: 600;color: #1E1E1E;">Please check your E-mail for confirmation and go to your dashboard to upload more content!</p>
				<a href="{{url('org/events')}}"><input type="button" id="" class="clickable createEventButton buttonMobileSize px-5 pull-right mt-5" value="OK!" style="padding: 8px 30px;"></a>
			</div>
			<div class="col-md-6">
				<img src="assets/images-new/upgradePlanImg.png">
			</div>
		</div>
	</div>

</div>
@endsection