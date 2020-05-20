$(document).ready(function () {
    setEventDateAndTime();
    var table = $('#default-datatable').DataTable({
        columnDefs: [
            { orderable: false, targets: 4 },
        ]
    });

    var videosTable = $('#default-datatable-videos').DataTable({
        columnDefs: [
            { orderable: false, targets: 3 },
        ]
    });
    
    var podcastsTable = $('#default-datatable-podcasts').DataTable({
        columnDefs: [
            { orderable: false, targets: 3 },
        ]
    });

    $('#EventDateTime').change(function (time) {
        var dateRi = $(this).val();
        var defaultdate;
        var defaulttime;
        var hours;
        var minutes;
        var ampm;
        defaultdate = new Date($(this).val());
        defaultdate.setHours(defaultdate.getHours() + 1);
        hours = defaultdate.getHours() > 12 ? (defaultdate.getHours() - 12).toString() : defaultdate.getHours().toString();
        hours = hours.length == 1 ? "0" + hours : hours;
        minutes = defaultdate.getMinutes().toString();
        minutes = minutes.length == 1 ? "0" + minutes : minutes;
        ampm = defaultdate.getHours() > 11 ? "PM" : "AM";
        defaulttime = hours + ":" + minutes + " " + ampm;
        $("#EventEndDateTime").val(defaultdate.getMonth() + 1 + "/" + defaultdate.getDate() + "/" + defaultdate.getFullYear() + " " + defaulttime);
    });
    $(".files").on("change", function (e) {
        var files = e.target.files,
            filesLength = files.length;
            
        for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var sizeKB = f.size / 1024;
            var sizeMB = sizeKB / 1024;
            console.log(f.naturalWidth);
            if (sizeMB > 1) {
                $(this).parent().find('.SizeError').removeClass('d-none');
                $(this).parent().find('.SizeError').addClass('Invalid');
                $('#Submit').attr('disabled', true);
                return false;
            } 
            if($(this).parent().find('.SizeError').hasClass('Invalid')){
                $(this).parent().find('.SizeError').addClass('d-none');
                $('#Submit').attr('disabled', false);
            }
        }
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

function IsOnlineEvent(element) {
    if ($(element).is(":checked")) {
        $('#Address').val('');
        $('#Address').attr('readonly', true);
        $('#city').attr('disabled', true);
        $('#EventUrl').removeClass('d-none');
    } else {
        $('#EventUrl').val('');
        $('#EventUrl').addClass('d-none');
        $('#Address').removeAttr('readonly', false);
        $('#city').attr('disabled', false);
    }
}

function setEventDateAndTime() {
    $('.date').each(function () {
        var defaultdate;
        var defaulttime;
        var hours;
        var minutes;
        var ampm;
        if (Date.parse($(this).val())) {
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
        data: { _token: CSRF_TOKEN, eventDeleteId: eventDeleteId },
        success: function (response) {
            // console.log(response);
            location.reload();
        }
    });
}
function UploadVideoBox(){
   if(!$('#IsUploadVideo').is(':checked')){
    $('#input_url').attr('readonly', false);
    $("#input_url").prop('required',true);
    $("#input_vidfile").prop('required',false);
    $('.uploadVideoBox').addClass('d-none');
   }else{
    $('.uploadVideoBox').removeClass('d-none');
    $('#input_url').attr('readonly', true);
    $("#input_url").prop('required',false);
    $("#input_vidfile").prop('required',true);
   }
}
function showHideLinkEvent(){
    if($('#IsLinkedEvent').is(':checked')){
        $('.EventSelectionBox').removeClass('d-none');
    }else{
        $('.EventSelectionBox').addClass('d-none');
    }

}
function uploadVideo(element){
    if ($(element).attr('id') == 'videoButton') {
      $('.videoTitle').removeClass('d-none');
      $('.videoUrl').removeClass('d-none');
      $('.videoUploadBox').removeClass('d-none'); 
      $('#input_url').attr('readonly', false); 
      $('#IsUploadVideo').prop('checked',false);
      // $('.uploadVideo').removeClass('d-none');
      $('.uploadPodcastVideo').addClass('d-none');
   }
   else if ($(element).attr('id') == 'podcastVideoButton') {
       $('.videoTitle').addClass('d-none');
       $('.videoUrl').addClass('d-none');
       $('.videoUploadBox').addClass('d-none');
       $('.uploadVideoBox').addClass('d-none');
       $('.uploadPodcastVideo').removeClass('d-none');
       $('.uploadVideo').addClass('d-none');
   }
    // $('.uploadVideo').removeClass('d-none');
}
function addEventVideos(element) {
    var parent = findParent(element);
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.addEventVideos').val();
    
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN},
        success: function (response) {
            console.log(response);
        }
    });
}

// function SaveNewEvent(element) {
//     var URL=$('.URL').val();
//     ob = new Object();
//     ob.title=$('#title').val();
//     ob.Description=$('#Description').val();
//     ob.EventUrl=$('#EventUrl').val();
//     ob.IsOnline=false;
//     if($('#IsOnline').is(":checked")){
//         ob.IsOnline==true;
//     }
    
//     ob.city=$('#city').find('option:selected').val();
//     ob.Address=$('#Address').val();
//     ob.EventDateTime=$('#EventDateTime').val();
//     ob.EventEndDateTime=$('#EventEndDateTime').val();
//     ob.IsPublic=false;
//     if($('#IsPublic').is(":checked")){
//         ob.IsPublic==true;
//     }
//     ob.IsPaid="";
//     if($('#IsPaid').is(":checked")){
//         ob.IsPaid==true;
//     }
//     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
//     var Data = JSON.stringify(ob);
//     $.ajax({
//         url: URL,
//         type: "post",
//         data: {_token: CSRF_TOKEN, Data},
//         success: function (response) {
//             console.log(response);
//         },
//         error: function (response) {
//            console.log(response);
//         }
//     });
// }
