$(function () {
    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function (e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
        'input[type=text]', 'input[type=file]',
        'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hidden');

        $('.has-error').removeClass('has-error');
        $inputs.each(function (i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hidden');
                e.preventDefault();
            }
        });

        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error').removeClass('d-none').find('.alert').text(response.error.message);
        } else {
            $(".spinnerSubmit").removeClass("d-none");
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});

function applyBorderColorPlan(element){
    var price = $(".yearPrice").text().substring(1, $(".yearPrice").text().length);
	if($(element).hasClass('yearlyDiv')){
		//$('.yearlyDiv').attr('style', 'border: 2px solid #FD6568 !important;background: white!important;box-shadow: none;');
		//$(".monthlyDiv").css({ 'border' : ''});
		//$(".contentPlanCard").css({ 'border' : ''});
        $(".yearlydot").removeClass("hiddenDiv");
        $(".monthlydot").addClass("hiddenDiv");
        $(".priceMonth").text($(".yearPrice").text());
        $(".billedPara").text("Billed Yearly");
        $(".subTotal").html("$" + parseInt(price) * parseInt(12));
        $(".totalClass").html("$" + parseInt(price) * parseInt(12));
		$('.planText').val('yearly');
	} else {
		// $('.monthlyDiv').attr('style', 'border: 2px solid #FD6568 !important;background: white!important;box-shadow: none;');
		// $(".yearlyDiv").css({ 'border' : ''});
		// $(".contentPlanCard").css({ 'border' : ''});
        $(".yearlydot").addClass("hiddenDiv");
        $(".monthlydot").removeClass("hiddenDiv");
        $(".priceMonth").text($(".monthPrice").text());
        $(".billedPara").text("Billed Monthly");
        $(".subTotal").html($(".monthPrice").text());
        $(".totalClass").html($(".monthPrice").text());
		$('.yearlyDiv').attr('data-id', 'yearly');	
		$('.planText').val('monthly');
	}
}

function checkSelectedOption(){
	var planText = $('.planText').val();
	var planId = $(".planId").val();
	if(planText == '') { 
    	alert("Please Select Plan Type");
    	return false;
	} else {
		window.location.href = "../payment/" +  planId + "/" + planText;
	}
}

function checkOrgLogin(element){
    var userType = $(".getUserType").val();
    var url = $(element).attr("data-attr");
    var loginRoute = $(".loginRoute").val();
    if(userType == ""){
        window.location.href = loginRoute;
    } else if(userType == "1"){
        window.location.href = url;
    } else {
        alert("Only organizer can upgrade plan");
        return false;
    }
}

function ticketCheckoutPage(element){
    var finalTicketTotal = $(".finalTicketTotal").attr("value");
    var eventId = $(element).attr("data-event-id");

    if(finalTicketTotal == "0"){
        $(".chekoutBtn").attr("disabled", true);
        return;
    } else {
        var ticketids = [];
        var ticketQty = [];
        $(".ticketdetailDiv").each(function() {
            var ticketid = $(this).find(".ticketName").attr("data-id");
            var qty = $(this).find(".input-number").attr("value");
            if(qty != "0"){
                ticketids.push(ticketid);
                ticketQty.push(qty);
            }
        });
        var tid = ticketids.join(",");
        var tqty = ticketQty.join(",");
        window.location.href = "../ticketCheckout/" + eventId + "/" + finalTicketTotal + "/" + tid + "/" + tqty;
    }
}

function setPurchaseTicketValues(element){
    event.preventDefault();
    
    $(".chekoutBtn").attr("disabled", false);
    var fieldName = $(element).attr('data-field');
    var type = $(element).attr('data-type');
    var input = $(element).parent().parent().find("input[name='"+fieldName+"']");
    var tktName = $(element).parent().parent().find("input").attr("data-tkt-name");
    var currentVal = parseInt(input.val());
    var price = $(element).parent().parent().parent().parent().find(".ticketPrice").attr("value");
    var sum = 0;
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();

                $(element).parent().parent().find(".input-number").attr("value" , currentVal - 1);

                $(".orderSummary").each(function() {
                    var orderTktCnt = $(this).find(".orderTktCnt");
                    //var orderTktPrice = $(this).find(".orderTktPrice").text();

                    if(tktName == $(this).find(".orderTktName").text()){
                        orderTktCnt.html("x" + (currentVal - 1)) ;
                        //var tktPrice = $(this).find(".orderTktPrice").text("$" + (price * (currentVal - 1)));
                        $(this).find(".orderTktPrice").attr("value", price * (currentVal - 1));
                    }
                    sum += parseInt($(this).find(".orderTktPrice").attr("value"));
                });

                $(".finalTicketTotal").attr("value", sum);
                $(".finalTicketTotal").text("$"+ sum);
                $(".subTotal").text("$"+ sum);
            } 
        } else if(type == 'plus') {
            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();

                $(element).parent().parent().find(".input-number").attr("value" , currentVal + 1);

                $(".orderSummary").each(function() {
                    var orderTktCnt = $(this).find(".orderTktCnt");
                    //var orderTktPrice = $(this).find(".orderTktPrice").text();

                    if(tktName == $(this).find(".orderTktName").text()){
                        orderTktCnt.html("x" + (currentVal + 1)) ;
                        //var tktPrice = $(this).find(".orderTktPrice").text("$" + (price * (currentVal + 1)));
                        $(this).find(".orderTktPrice").attr("value", price * (currentVal + 1));
                    }
                    sum += parseInt($(this).find(".orderTktPrice").attr("value"));
                });

                $(".finalTicketTotal").attr("value", sum);
                $(".finalTicketTotal").text("$"+ sum);
                $(".subTotal").text("$"+ sum);

            }
        }
    } else {
        input.val(0);
    }
}