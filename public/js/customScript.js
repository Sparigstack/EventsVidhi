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

    $('#SaveVideoAjax').on('submit', function (event) {
        LoaderStart();
        event.preventDefault();
        var CurentForm=$(this);
        var urlString = $('.addEventVideos').val();
        var formData = new FormData(this);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: urlString,
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                //var HtmlContent="<div>"+response.videoUrl+"</div> <div>"+response.videoTitle+"</div>";
                var HtmlContent='<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">'+response.videoTitle+'</h6><small class="small-font">'+response.videoUrl+'</small></div><div data-id="'+response.videoID+'" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
                $('#UploadedVideos').append(HtmlContent);
                $(CurentForm).find('#input_url').val('');
                $(CurentForm).find('#input_title').val('');
                $('.UploadVideoContainer').addClass('d-none');
                // $(CurentForm).find('.RemoveVideo').removeClass('d-none');
                // $(CurentForm).find('.uploadVideoBox').addClass('d-none');
                // $(CurentForm).find('#videoSubmitButton').attr('disabled',true);
                // $(CurentForm).parent().find('#SaveVideoAjax').prop('name','SubmittedForm');
                // $(CurentForm).parent().find('#SaveVideoAjax').prop('id','SubmittedForm');
                // var InputVideo=$(CurentForm).parent().find('#IsUploadVideo');
                // $(InputVideo).prop('id','IsUploadVideoDisabled');
                // $(InputVideo).parent('label').attr('for','IsUploadVideoDisabled');
                // $('#videoButton').attr('onclick','VideoFormContent();');
                // $('#SaveVideoAjax').unbind('submit').submit();
                LoaderStop();
                // console.log(response.message);
            },
            error: function (err) {
                console.log(err);
                LoaderStop();
            }
        });
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
            if (sizeMB > 4) {
                $(this).parent().parent().find('.SizeError').removeClass('d-none');
                $(this).parent().parent().find('.SizeError').addClass('Invalid');
                $('#Submit').attr('disabled', true);
                return false;
            }
            if ($(this).parent().parent().find('.SizeError').hasClass('Invalid')) {
                $(this).parent().parent().find('.SizeError').addClass('d-none');
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
        $('#Address1').attr('disabled', true);
        $('#Address2').attr('disabled', true);
        $('#PostalCode').attr('disabled', true);
        $('#city').attr('disabled', true);
        $('#country').attr('disabled', true);
        $('#state').attr('disabled', true);
        $('#EventUrl').removeClass('d-none');
    } else {
        $('#EventUrl').addClass('d-none');
        if ($("#city option[value='-1']").length != 0) {
            $('#Address1').attr('disabled', false);
            $('#Address2').attr('disabled', false);
            $('#PostalCode').attr('disabled', false);
            $('#city').attr('disabled', false);
        }
        if ($("#state option[value='-1']").length != 0) {
            $('#state').attr('disabled', false);
        }
        $('#country').attr('disabled', false);
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
function UploadVideoBox(element) {
    var field=$(element).parent().parent().parent();
    if (!$(field).find('#IsUploadVideo').is(':checked')) {
        $(field).find('#input_url').attr('readonly', false);
        $(field).find("#input_url").prop('required', true);
        $(field).find("#input_vidfile").prop('required', false);
        $(field).find('.uploadVideoBox').addClass('d-none');
    } else {
        $(field).find('.uploadVideoBox').removeClass('d-none');
        $(field).find('#input_url').attr('readonly', true);
        $(field).find("#input_url").prop('required', false);
        $(field).find("#input_vidfile").prop('required', true);
    }
}
function showHideLinkEvent() {
    if ($('#IsLinkedEvent').is(':checked')) {
        $('.EventSelectionBox').removeClass('d-none');
    } else {
        $('.EventSelectionBox').addClass('d-none');
    }

}
function uploadVideo(element) {
    if ($(element).attr('id') == 'videoButton') {
        $('.UploadVideoContainer').removeClass('d-none');
        //   $('.videoTitle').removeClass('d-none');
        //   $('.videoUrl').removeClass('d-none');
        //   $('.videoUploadBox').removeClass('d-none'); 
        //   $('#input_url').attr('readonly', false); 
        //   $('#IsUploadVideo').prop('checked',false);

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
function UpdateEventStatus(element) {
    var URL = $('.PostUrl').val();
    $id = $(element).attr('data-id');
    $status = $(element).attr('status');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        url: URL,
        type: "post",
        data: { _token: CSRF_TOKEN, 'id': $id, 'status': $status },
        success: function (response) {
            // console.log(response);
            if ($status == '1') {
                $(element).attr('status', '2');
                $(element).text('Resume');
            } if ($status == '2') {
                $(element).attr('status', '1');
                $(element).text('Pause');
            } if ($status == '3') {
                $(".pauseButton").addClass('d-none');
                $(".cancelButton").addClass('d-none');
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
}
function addEventVideos(element) {
    // $(element).parent().parent().find('#SaveVideoAjax').submit();

    return false;
    LoaderStart();
    var parent = findParent(element);
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.addEventVideos').val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN },
        success: function (response) {

            console.log(response);
            LoaderStop();
        }
    });
}

function getState(element) {
    var parent = findParent(element);
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.getState').val();
    var countryId = $(element).val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, countryId: countryId },
        success: function (response) {
            $('#state').attr('disabled', false);
            $('#state').empty();
            $('#state').append(response);
            // console.log(response);
        }
    });
}
function getCity(element) {
    var parent = findParent(element);
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.getCity').val();
    var cityId = $(element).val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, cityId: cityId },
        success: function (response) {
            $('#city').attr('disabled', false);
            $('#city').empty();
            $('#city').append(response);
        }
    });
}
function ShowAddressFields(element) {
    $('#Address1').attr('disabled', false);
    $('#Address2').attr('disabled', false);
    $('#PostalCode').attr('disabled', false);
}
function LoaderStart() {
    $('#pageloader-overlay').css('display', 'block');
}
function LoaderStop() {
    $('#pageloader-overlay').css('display', 'none');
}

function VideoFormContent() {
    var EventID=$('#EventToLink').val();
    var CsrfToken=$('meta[name="csrf-token"]').attr("content");
    var TokenInput='<input type="hidden" name="_token" value="'+CsrfToken+'">';
    var HtmlContent = "<div class='col-lg-8 UploadVideoContainer parent m-auto pt-5'><form class='' ID='SaveVideoAjax' name='SaveVideoAjax' method='post' enctype='multipart/form-data'>"+TokenInput+"<input type='text' name='EventToLink' id='EventToLink' class='d-none' value='"+EventID+"'/><button  class='btn btn-primary d-none RemoveVideo' style='position: absolute;right: -132px;top:29px;'>Remove Video</button><div class='form-group  videoTitle'><label for='input_title'>Video Title</label><input type='text' class='form-control' id='input_title' name='input_title' value='' placeholder='Enter Video Title' required></div><div class='form-group videoUrl'><label for='input_url'>Video URL</label><span style='font-size: 11px;font-weight: 600;'>&nbsp;&nbsp;(YouTube or Vimeo url)</span><input type='text' class='form-control' id='input_url' name='input_url' value='' placeholder='Enter Video URL' required></div><div class='form-group videoUploadBox'><label for='BlankLabel'></label><div class='icheck-material-primary'><input onclick='UploadVideoBox(this)' type='checkbox' id='IsUploadVideo' name='IsUploadVideo' ><label for='IsUploadVideo'>Or upload video</label></div></div><div class='parent' style='width: 100%;'><div class='form-group  d-none uploadVideoBox'><div class='dragFileContainer'><input id='video_file' name='video_file' type='file' multiple><p>Drag your video file here or click in this area.</p></div></div><div class='form-group  d-none uploadPodcastVideo'><div class='dragFileContainer'><input id='podcast_video_file' name='podcast_video_file' type='file' multiple><p>Drag your podcast video file here or click in this area.</p></div></div></div><div class='col-lg-12'><button type='submit' data-id='' id='videoSubmitButton' class='btn btn-primary px-5 pull-right'> Save Video</button></div></form>";
    $('.InsertVideoDiv').append(HtmlContent);
}
function RemoveSingleVideo(element){
    LoaderStart();
    var id=$(element).attr('data-id');
    var Field=findParent(element);
    var urlString = $('.RemoveEventVideos').val();
    urlString +="/"+id;
    var CSRF_TOKEN = $('.csrf-token').val();
    var countryId = $(element).val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, id: id },
        success: function (response) {
            $(Field).remove();
            LoaderStop();
            // console.log(response);
        },
        error: function (error) {
           alert('An Error Occured');
           LoaderStop();
            // console.log(error);
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
