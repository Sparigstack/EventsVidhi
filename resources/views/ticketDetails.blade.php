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
				<div class="row mt-2">
					<div class="col-md-8">
						<h5> {{$ticketDetails->name}} </h5>
						<p> ${{$ticketDetails->price}} </p>
					</div>

					<div class="col-md-4">
							<!-- plus minus sign bootstrap -->
								<div class="center">
    <div class="input-group" >
          <span class="input-group-btn">
              <button style="
    " type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                <span class="fa fa-minus"></span>
              </button>
          </span>
          <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100">
          <span class="input-group-btn">
              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                  <span class="fa fa-plus"></span>
              </button>
          </span>
      </div>
</div>
							<!-- plus minus sign bootstrap -->
					</div>
				</div>
				@if ($key + 1 != $ticketCount)
                    <hr class="mt-3 mb-3">
                @endif
				@endforeach

				<div class="row justify-content-center mt-4" style="">
					<p style="color: #9C9C9C;"> Ticket sales end on Thurs, Nov 10, 2021 12 AM </p>
				</div>

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

			<p style="color: #9C9C9C;">{{count($ticketDetail)}} tickets</p>

			@foreach($ticketDetail as $ticketDetails)
			<div class="row">
				<div class="col-md-7"> <p> {{$ticketDetails->name}} </p> </div>
				<div class="col-md-2"> x1 </div>
				<div class="col-md-3 text-right"> ${{$ticketDetails->price * 1}} </div>
			</div>
			@endforeach

			<hr>
			<div class="row">
				<div class="col-md-9"> <p> Subtotal </p> </div>
				<div class="col-md-3 text-right subTotal"> $10 </div>
			</div>

			<div class="row">
				<div class="col-md-9"> <p> Fees* </p> </div>
				<div class="col-md-3 text-right subTotal"> $10 </div>
			</div>

			<div class="row">
				<div class="col-md-9"> <p> Promo Discount </p> </div>
				<div class="col-md-3 text-right subTotal"> $10 </div>
			</div>

			<div class="row">
				<div class="col-md-9"> <h5> Total </h5> </div>
				<div class="col-md-3 text-right"> <h5 class="finalTicketTotal" value="10"> $10 </h5> </div>
			</div>
    	</div>

    	<div class="mt-3">
    		<a href="{{url('ticketCheckout/'. $eventRecord->id)}}" class="d-flex justify-content-center">
            <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Checkout" style="padding: 8px 30px;"></a>
            <p class="mt-4" style="color: #9C9C9C;">*Panelhive’s fees are non-refundable</p>
    	</div>

    	</div>

	</div>
</div>
@endsection
@section('script')
<script>
		//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>
@endsection