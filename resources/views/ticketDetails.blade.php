@extends('layouts.appFront')
@section('content')
<?php $v = "1.0.1"; ?>
<div class="container mainHomePageContainer pt-3 pb-3 pl-0 pr-0" style="">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-3">
		<a href="{{url('events/'. $eventRecord->id)}}" style="color: #9C9C9C;font-weight: 100;" class=""><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<?php 
		$ticketCount = $ticketDetail->count();

		$dateStr = "";
        $timeStr = "";

        $sdStamp = strtotime($eventRecord->date_time);
        $sd = date("d M, Y", $sdStamp);
        $st = date('h:i A', $sdStamp);

        $edStamp = strtotime($eventRecord->end_date_time);
        $ed = date("d M, Y", $edStamp);
        $et = date('h:i A', $edStamp);
        if ($sd == $ed) {
            $dateStr = date("D, M d, Y", $sdStamp);
            $timeStr = $st . " - " . $et;
        } else {
           $dateStr = date("D, M d, Y", $sdStamp) . ' - ' . date("D, M d, Y", $edStamp);
           $timeStr = $st . " - " . $et;
        }
	?>

	<div class="row mb-4 ml-2">
		<div class="col-md-9 mb-4 pl-0 pr-0">
			<div class="card">
				<h4 class="ml-4 mt-3 pl-0 pr-0">{{$eventRecord->title}}</h4>

				<div class="row ml-4">
					<div class="eventDateTimeBorder" style="">
						<p class="mr-3" style="color:#675C5C;font-weight: 600;"> {{$dateStr}} </p>
					</div>
					<div>
                       <p class="ml-3" style="color:#675C5C;font-weight: 600;"> {{$timeStr}} {{$eventRecord->timezone->abbreviation}} </p>
					</div>
				</div>

				<hr>

			<!-- </div> -->

			<div class="container" style="padding:5px 25px ;">
				<h4 class="mb-4"> Tickets </h4>

				@foreach($ticketDetail as $key => $ticketDetails)
				<?php
					$backcolor = "";
					$disableBtn = "";
					$qtyVal = "1";
					$soldOut = "d-none";
					$hideDiv = "";
					$backcolor1 = "";

					$ticketDateStr = "";
			        $ticketTimeStr = "";

        			$ticketEndDate = date("D, M d, Y", strtotime($ticketDetails->sales_end));
        			$ticketEndTime = date('h:i A', strtotime($ticketDetails->sales_end));

					if($ticketDetails->quantity == $ticketDetails->sold_out){
						$backcolor = "color: #8C8C8C;";
						$disableBtn = "disabled";
						$qtyVal = "0";
						$soldOut = "";
						$hideDiv = "d-none";
						$backcolor1 = "background: #9C9C9C;";
					}
				?>
				<div class="row mt-2 ticketdetailDiv">
					<div class="col-md-10 ticketsDiv">
						<h5 class="ticketName" style="{{$backcolor}}" data-id="{{$ticketDetails->id}}"> {{$ticketDetails->name}} </h5>
						<div class="col-md-12 pl-0 row">
							<p class="ticketPrice col-md-4" value="{{$ticketDetails->price}}">${{$ticketDetails->price}}</p>
    						<p class="soldOutClass {{$soldOut}} col-md-6">sold out</p>
						</div>

						<div class="{{$hideDiv}}">
							<p style="color: #9C9C9C;"> Ticket sales end on {{$ticketEndDate}} {{$ticketEndTime}} </p>
						</div>
						<!-- <p class="ticketPrice" value="{{$ticketDetails->price}}"> ${{$ticketDetails->price}} </p> -->
					</div>

					<div class="col-md-2 parent mt-3">
						<!-- plus minus sign bootstrap -->
      					<div class="input-group w-100">
  							<div class="input-group-prepend">
  								<button {{$disableBtn}} style="" type="button" class="btn btn-number" onclick="setPurchaseTicketValues(this);" data-type="minus" data-field="quant[2]">
                					<span class="fa fa-minus" style="color: #9C9C9C;"></span>
              					</button>
  							</div>
  							<input style="border: 1px solid #ECECEC;" type="text" name="quant[2]" data-tkt-name="{{$ticketDetails->name}}" class="form-control input-number text-center" value="{{$qtyVal}}" min="0" max="{{$ticketDetails->quantity - $ticketDetails->sold_out}}" onchange="setPurchaseTicketValues(this);">
  							<div class="input-group-append">
  								<button {{$disableBtn}} style="{{$backcolor1}}" type="button" class="btn btn-number" onclick="setPurchaseTicketValues(this);" data-type="plus" data-field="quant[2]">
                  					<span class="fa fa-plus"></span>
              					</button>
  							</div>
						</div>
						<!-- plus minus sign bootstrap -->
					</div>
				</div>
				@if ($key + 1 != $ticketCount)
                    <hr class="mt-3 mb-3">
                @endif
				@endforeach

				<!-- <div class="row justify-content-center mt-4" style="">
					<p style="color: #9C9C9C;"> Ticket sales end on Thurs, Nov 10, 2021 12 AM </p>
				</div> -->

			</div>
			</div>


			<div class="card col-md-6">
				<h5 class="mt-3"> Have a promo code? </h5>
				<div class="row pl-3 mb-3">
					<input placeholder="Enter here" type="text" name="promoCode" class="form-control" style="width:75%;background: #ECECEC;">
					<a href="#" class="ml-4 pl-2 mt-2" style="color: #000000;"><p><u>Apply</u></p></a>
				</div>
			</div>


    	</div>

    	<div class="col-md-3 mb-4">
    	<div class="card w-100 container" style="padding: 20px 18px;">
    		<div class="row">
				<div class="col-md-9"> <h5> Order Summary </h5> </div>
				<div class="col-md-3 text-right"> <span class="dot1"></span> <span class="dot"></span> </div>
			</div>

			<p style="color: #9C9C9C;" class="countTkt"></p>

			@foreach($ticketDetail as $ticketDetails)
			@if($ticketDetails->quantity != $ticketDetails->sold_out)
			<div class="row orderSummary">
				<div class="col-md-7"> <p class="orderTktName">{{$ticketDetails->name}}</p> </div>
				<div class="col-md-2 orderTktCnt">x1</div>
				<div class="col-md-3 text-right"><p class="orderTktPrice" value="{{$ticketDetails->price * 1}}">${{$ticketDetails->price * 1}}</p></div>
			</div>
			@endif
			@endforeach

			<hr>
			<div class="row">
				<div class="col-md-9"> <p> Subtotal </p> </div>
				<div class="col-md-3 text-right subTotal">$10</div>
			</div>

			<div class="row">
				<div class="col-md-9"> <p> Fees* </p> </div>
				<div class="col-md-3 text-right">$0</div>
			</div>

			<div class="row">
				<div class="col-md-9"> <p> Promo Discount </p> </div>
				<div class="col-md-3 text-right">-$0</div>
			</div>

			<div class="row">
				<div class="col-md-6"> <h5> Total </h5> </div>
				<div class="col-md-6 text-right"> <h5 class="finalTicketTotal" value="10">$10.00</h5> </div>
			</div>
    	</div>

    	<div class="mt-3">
    		<a class="d-flex justify-content-center" onclick="ticketCheckoutPage(this);" data-event-id="{{$eventRecord->id}}">
            <input type="button" id="" class="clickable createEventButton buttonMobileSize chekoutBtn" value="Checkout" style="padding: 8px 30px;"></a>
            <p class="mt-4" style="color: #9C9C9C;">*Panelhive’s fees are non-refundable</p>
    	</div>

    	</div>

	</div>
</div>
@endsection
@section('script')
<script src="{{asset('/js/payment.js?v='.$v)}}" type="text/javascript"></script>
<script>
	$(document).ready(function () {
		var sum = 0;
		var cnt = 0;
		$(".ticketsDiv").each(function() {
			if(!$(this).parent().find("button").is('[disabled=disabled]')){
				sum += parseInt($(this).find(".ticketPrice").attr("value"));
				cnt++;
			}
    	});

		$(".finalTicketTotal").attr("value", sum);
		$(".finalTicketTotal").text("$"+ sum);
		$(".subTotal").text("$"+ sum);
		$(".countTkt").text(cnt + " tickets");
	});

// $('.input-number').focusin(function(){
//    $(this).data('oldValue', $(this).val());
// });
// $('.input-number').change(function() {
    
//     minValue =  parseInt($(this).attr('min'));
//     maxValue =  parseInt($(this).attr('max'));
//     valueCurrent = parseInt($(this).val());
    
//     name = $(this).attr('name');
//     if(valueCurrent >= minValue) {
//         $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
//     } else {
//         alert('Sorry, the minimum value was reached');
//         $(this).val($(this).data('oldValue'));
//     }
//     if(valueCurrent <= maxValue) {
//         $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
//     } else {
//         alert('Sorry, the maximum value was reached');
//         $(this).val($(this).data('oldValue'));
//     }
    
    
// });
// $(".input-number").keydown(function (e) {
//         // Allow: backspace, delete, tab, escape, enter and .
//         if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
//              // Allow: Ctrl+A
//             (e.keyCode == 65 && e.ctrlKey === true) || 
//              // Allow: home, end, left, right
//             (e.keyCode >= 35 && e.keyCode <= 39)) {
//                  // let it happen, don't do anything
//                  return;
//         }
//         // Ensure that it is a number and stop the keypress
//         if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
//             e.preventDefault();
//         }
//     });
</script>
@endsection