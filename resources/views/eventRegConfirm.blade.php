@extends('layouts.appFront')
@section('content')

<div class="m-auto col-md-11 col-lg-11 d-flex align-items-center pl-4 pt-4">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class="ml-4 pl-2"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

<div class="container mainHomePageContainer mt-3 mb-5 pl-0 pr-0 pb-5" style="">
		<?php
	        $dateStr = "";
	        $timeStr = "";

	        $sdStamp = strtotime($event->date_time);
	        $sd = date("d M, Y", $sdStamp);
	        $st = date('h:i a', $sdStamp);

	       $edStamp = strtotime($event->end_date_time);
	       $ed = date("d M, Y", $edStamp);
	       $et = date('h:i a', $edStamp);
	       if ($sd == $ed) {
	            $dateStr = date("D, d M", $sdStamp);
	            $timeStr = $st . " - " . $et;
	        } else {
	           $dateStr = date("D, d M", $sdStamp) . ' - ' . date("D, d M", $edStamp);
	            $timeStr = $st . " - " . $et;
	        }
	    ?>
	<div class="card col-md-7 m-auto container upgradeSuccessCard" style="background: #FED8C6;">
		<div class="row">
			<div class="col-md-9 mt-5">
				<h5>Your Registration is confirmed!</h5>
				<h5 class="mt-3"> {{$event->title}} </h5>
				<p> <b> {{$dateStr}}, {{$timeStr}} {{$event->timezone->abbreviation}} </b> </p>
				<!-- Mon, 14 Nov, 1:30 - 2:30 pm SGT -->
				<p class="pt-3" style="color: #1E1E1E;">Please check your email for confirmation and details for the event!</p>
				<a href="{{url('events/'.$event->id)}}" target="_blank"><input type="button" id="" class="clickable createEventButton buttonMobileSize px-5 pull-right mt-2" value="OK!" style="padding: 8px 30px;"></a>
			</div>
			<!-- #f2f2f2 -->
			<div class="col-md-3" style="">
				<img src="../assets/images-new/eventRegConfirm.png">
			</div>
		</div>
	</div>
	<!-- background:url('{{asset('assets/images-new/Vector.png')}}'); -->
<!-- background-image : -webkit-linear-gradient(top, red, red 50%, transparent 70%, transparent 100%); -->
</div>
@endsection