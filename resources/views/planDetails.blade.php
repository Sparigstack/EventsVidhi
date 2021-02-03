@extends('layouts.appFront')
@section('content')
<?php $v = "1.0.1"; ?>
<div class="container mainHomePageContainer pt-3 pb-3 pl-0 pr-0" style="">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('pricingPlans')}}" style="color: #9C9C9C;font-weight: 100;" class=""><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="row mb-4 ml-2">
		<div class="col-md-9 card mb-4 pl-0 pr-0">
			<div class="col-md-12 col-lg-12 text-center mt-4 pl-0 pr-0">
				<h5 class="text-center">Checkout &nbsp;&nbsp; <span class="dot1"></span> <span class="dot"></span> </h5>
				<hr>
			</div>

			<div class="container" style="padding:20px 40px ;">
				<h5 class="mb-4 ml-4"> Cloud Storage Plan </h5>

				<input type="hidden" class="planText" value="">
				<input type="hidden" class="planId" value="{{$id}}">
				<div class="row justify-content-center" style="">
					<div class="col-md-5 col-lg-5 col-sm-5 text-center" style="box-shadow: none;">
						<div class="card plansCard contentPlanCard" style="border: 2px solid #FD6568 !important;">
							<h5><?php if($id == 2) {echo "PLUS";} if($id == 3) {echo "PREMIUM";} ?></h5>
							<p><?php if($id == 2) {echo "10 gb of cloud space to upload & showcase content";} if($id == 3) {echo "<b>Unlimited </b> of cloud space to upload & showcase content";} ?></p>
						</div>
					</div>

					<?php 
					$plusMonthly = '';
					$plusYearly = '';
					$premiumMonthly = '';
					$premiumYearly = '';
					for ($plan= 0; $plan<count($plans); $plan++) {
						$plusMonthly = $plans[0]->price;
						$plusYearly = $plans[1]->price;
						$premiumMonthly = $plans[2]->price;
						$premiumYearly = $plans[3]->price;
					}
					?>

					<div class="col-md-3 col-lg-3 col-sm-3 text-center" style="">
						<div class="card plansCard yearlyDiv" style="background: white!important;box-shadow: none;" onclick="applyBorderColorPlan(this);">
							<h5>$<?php if($id == 2) {echo $plusYearly;} if($id == 3) {echo $premiumYearly;} ?></h5>
							<p>billed yearly</p>
							<p style="color: #9C9C9C;"> *price per month </p>
						</div>
					</div>

					<div class="col-md-3 col-lg-3 col-sm-3 text-center" style="">
						<div class="card plansCard monthlyDiv" style="background: white !important;box-shadow: none;" onclick="applyBorderColorPlan(this);">
							<h5>$<?php if($id == 2) {echo $plusMonthly;} if($id == 3) {echo $premiumMonthly;} ?></h5>
							<p>billed monthly</p>
							<p style="color: #9C9C9C;"> *price per month </p>
						</div>
					</div>
				</div>

				<a onclick="return checkSelectedOption();" class="mt-5 mb-5 ml-4"><input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Next" style="padding: 8px 50px;"></a>

				<p class="mt-4 mb-4 ml-4" style="color: #9C9C9C;font-size:12px;font-weight: 600;">*By selecting ‘Next’, I agree I have read Panelhive’s <a href="#" style="color: #9C9C9C;"><u>Privacy Policy</u></a> and agree with <a href="#" style="color: #9C9C9C;"><u>Terms of Service!</u></a> <br> I agree that Panelhive may share my information with the event organiser.</p>

		</div>

    </div>

    <div class="col-md-3 mb-4">
    	<div class="card w-100 container" style="padding: 20px 18px;">
    		<div class="row">
				<div class="col-md-9"> <h5> Order Summary </h5> </div>
				<div class="col-md-3 text-right"> <span class="dot1"></span> <span class="dot"></span> </div>
			</div>

			<p>Cloud Storage Plan</p>
			<h5 class="mt-3"> <?php if($id == 2) {echo "PLUS";} if($id == 3) {echo "PREMIUM";} ?> Storage </h5>

			<div class="row">
				<div class="col-md-9"> <p> <b> Price per month </b> </p> </div>
				<div class="col-md-3 text-right"> $<?php if($id == 2) {echo $plusYearly;} if($id == 3) {echo $premiumYearly;} ?> </div>
			</div>

			<p> Billed Yearly </p>

			<hr>
			<div class="row">
				<div class="col-md-9"> <p> Subtotal </p> </div>
				<div class="col-md-3 text-right"> $<?php if($id == 2) {echo $plusYearly;} if($id == 3) {echo $premiumYearly;} ?> </div>
			</div>

			<div class="row">
				<div class="col-md-9"> <h5> Total </h5> </div>
				<div class="col-md-3 text-right"> $<?php if($id == 2) {echo $plusYearly;} if($id == 3) {echo $premiumYearly;} ?> </div>
			</div>
    	</div>

    </div>

</div>
@endsection
@section('script')
<script src="{{asset('/js/payment.js?v='.$v)}}" type="text/javascript"></script>
@endsection