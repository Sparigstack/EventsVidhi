$(document).ready(function () {
   setEventDateAndTime();
   var table = $('#default-datatable').DataTable({
   		columnDefs: [
            { orderable: false, targets: 4 },
        ]
    });

  });

function findParent(element) {
    var parentElement = $(element).parent();
    if ($(parentElement).hasClass("parent"))
        return parentElement;
    else {
        for (var i = 0; i < 12; i++) {
            parentElement = $(parentElement).parent();
            if ($(parentElement).hasClass("parent"))
                return parentElement;
        }
    }
}

function IsOnlineEvent(element){
    if($(element).is(":checked")){
        $('#Address').attr('readonly',true);
        $('#city').attr('disabled',true);
    }else{
        $('#Address').removeAttr ('readonly',false);
        $('#city').attr('disabled',false);
    }
}

function setEventDateAndTime(){
	$('.date').each(function () {
var defaultdate;
var defaulttime;
var hours;
var minutes;
var ampm;
if (Date.parse($(this).val())){
defaultdate = new Date($(this).val());
}
else {
defaultdate = new Date();
}

hours = defaultdate.getHours() > 12 ? (defaultdate.getHours() - 12).toString() : defaultdate.getHours().toString();
hours = hours.length == 1 ? "0" + hours : hours;
minutes = defaultdate.getMinutes().toString();
minutes = minutes.length == 1 ? "0" + minutes : minutes;
ampm = defaultdate.getHours() > 11 ? "PM" : "AM";
defaulttime = hours + ":" + minutes + " " + ampm;
if ($(this).val() == "CurrentDate")
$(this).val(getMmDdCurrentDate() + " " + defaulttime);
//$(this).val(defaultdate.toLocaleDateString("en-US") + " " + defaulttime);

var picker = $(this);
$(this).datetimepicker({
lang: 'en',
defaultDate: defaultdate,
defaultTime: defaulttime,
timepicker: $(this).attr("data-hidetimepicker") == "True" ? false : true,
format: $(this).attr("data-hidetimepicker") == "True" ? 'm/d/Y' : 'm/d/Y g:i A',
validateOnBlur: false,
step: 15,
customButtons: $(this).attr("data-setcustombuttons") == "True" ? true : false,
scrollInput: false
});
});

}

function deleteEvent(element) {
    var confirmDelete = confirm("Are you sure you want to delete this event?");
    if (!confirmDelete)
        return;
    var parent = findParent(element);
    var eventDeleteId = $(element).attr('db-delete-id');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.deleteEvent').val();
    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, eventDeleteId: eventDeleteId},
        success: function (response) {
        	// console.log(response);
            location.reload();
        }
    });
}