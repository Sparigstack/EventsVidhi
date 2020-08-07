$(document).ready(function () {


    setEventDateAndTime();

     if($("#EventDateTime").val() != ''){
        $('#EventEndDateTime').removeAttr("disabled");
    }

    $(".readOnlyStartDate").keydown(function(e){
        e.preventDefault();
    });

    $('#SaveVideoAjax').on('submit', function (event) {
        LoaderStart();
        event.preventDefault();
        var CurentForm = $(this);
        var urlString = $('.addEventVideos').val();
        var formData = new FormData(this);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        var bar = $('.progressBar').find('.bar_upload');
        var percent = $('.progressBar').find('.percent_upload');
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        bar.width(percentComplete.toFixed(0) + '%');
                        percent.html(percentComplete.toFixed(0)+'%');
                    }
                }, false);
                return xhr;
            },
            url: urlString,
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SaveVideoAjax').find('.progressBar').removeClass('d-none');
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function (response) {
                // console.log(response);
                if (response.error != '') {
                    if(response.error.video_file){
                        $('.VideoInvalid').append(response.error.video_file);
                        alert(response.error.video_file);
                        $('#SaveVideoAjax').find('.progressBar').addClass('d-none');
                    }
                    else{
                        $('.urlError').append(response.error.input_url);
                    }
                    
                } else {
                    if (response.videoUrl.indexOf('embed') > -1) {
                        var HtmlContent = '<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3 d-flex" style="align-items: center;"><a class="pull-left" href="'+response.videoUrl+'" target="_blank"><iframe width="100" height="70" src="'+response.videoUrl+'" class="pull-left"></iframe></a><h6 class="mb-0 pull-left ml-3">' + response.videoTitle + '</h6></div><div data-id="' + response.videoID + '" Type="video" urltype="' + response.urlType + '" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
                    } else if(response.videoUrl.indexOf('vimeo') > -1){
                        var HtmlContent = '<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3 d-flex" style="align-items: center;"><a class="pull-left" href="'+response.videoUrl+'" target="_blank"><iframe width="100" height="70" src="'+response.videoUrl+'" class="pull-left"></iframe></a><h6 class="mb-0 pull-left ml-3">' + response.videoTitle + '</h6></div><div data-id="' + response.videoID + '" Type="video" urltype="' + response.urlType + '" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
                    } else{
                    var HtmlContent = '<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3 d-flex" style="align-items: center;"><a class="pull-left" href="'+response.videoUrl+'" target="_blank"><video class="pull-left" src="'+response.videoUrl+'" width="100px" height="100px"></video></a><h6 class="mb-0 pull-left ml-3">' + response.videoTitle + '</h6></div><div data-id="' + response.videoID + '" Type="video" urltype="' + response.urlType + '" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
                    }
                    $('#UploadedVideos').append(HtmlContent);
                    $(CurentForm).find('#input_url').val('');
                    $(CurentForm).find('#input_title').val('');
                    $('.UploadVideoContainer').addClass('d-none');
                    $('.VideoInvalid').empty();
                    $('#SaveVideoAjax').find('.progressBar').addClass('d-none');
                }
                LoaderStop();
            },
            error: function (err) {
                console.log(err);
                LoaderStop();
            }
        });
    });

    $('#SavePodCastAjax').on('submit', function (event) {
        LoaderStart();
        event.preventDefault();
        var CurentForm = $(this);
        var urlString = $('.addPodCastVideos').val();
        var formData = new FormData(this);
        var bar = $('.podcastProgressBar').find('.bar_upload');
        var percent = $('.podcastProgressBar').find('.percent_upload');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        bar.width(percentComplete.toFixed(0) + '%');
                        percent.html(percentComplete.toFixed(0)+'%');
                    }
                }, false);
                return xhr;
            },
            url: urlString,
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#SavePodCastAjax').find('.podcastProgressBar').removeClass('d-none');
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function (response) {
                if (response.error != '') {
                    if(response.error.podcast_video_file){
                        $('.PodcastInvalid').append(response.error.podcast_video_file);
                        alert(response.error.podcast_video_file);
                        $('#SavePodCastAjax').find('.podcastProgressBar').addClass('d-none');
                    }
                    else{
                        $('.podcastUrlError').append(response.error.input_url);
                    }
                    
                    // $(validateField).append(response.error.podcast_video_file);
                } else {
                    var HtmlContent = '<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class = "media align-items-center"><h6 class="ml-3 col-lg-12 text-left" class="mb-0">'+ response.videoTitle +'</h6></div><div class="media align-items-center"><div class="media-body ml-3 d-flex" style="align-items: center;"><a class="pull-left" href="'+response.videoUrl+'" target="_blank"><audio controls><source src="'+response.videoUrl+'" type="audio/ogg"></audio></a>'+ '</div><div data-id="' + response.videoID + '" Type="podcast" urltype="' + response.urlType + '" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
                    $('#UploadedVideos').append(HtmlContent);
                    $(CurentForm).find('#input_url').val('');
                    $(CurentForm).find('#input_title').val('');
                    $('.UploadPodCastContainer').addClass('d-none');
                    $('.PodcastInvalid').empty();
                    $('#SavePodCastAjax').find('.podcastProgressBar').addClass('d-none');
                }
                LoaderStop();
            },
            error: function (err) {
                console.log(err);
                LoaderStop();
            }
        });
    });

    $('.SaveSpeaker').on('submit', function (event) {
        LoaderStart();
        event.preventDefault();
        var CurentForm = $(this);
        // var urlStringSpeaker = $('.addSpeakers').val();
        var urlStringSpeaker = "";
        var speakerId = $("#speakerSubmitButton").attr('data-id');
        if (speakerId != "") {
            urlStringSpeaker = $('.updateSpeaker').val();
            urlStringSpeaker += "/" + speakerId;

        } else {
            urlStringSpeaker = $('.addSpeakers').val();
        }
        var formData = new FormData(this);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        var speakerTitle = $("#speakerTitle").val();
        var speakerFirstName = $("#speakerFirstName").val();
        // var speakerLastName = $("#speakerLastName").val();
        var speakerDesc = $("#speakerDesc").val();
        var speakerOrganization = $("#speakerOrganization").val();
        var speakerLinkedinUrl = $("#speakerLinkedinUrl").val();
        var speakerProfilePic = $("#profilePicImage").attr("src");
        // var picSave = $(".profilePicImage").attr('picvalue',speakerProfilePic);
        var eventId = $("#EventToLink").val();

        $.ajax({
            url: urlStringSpeaker,
            method: "post",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                console.log(response);
                if (speakerId != "") {
                    $('.CurrentlyUpdatingThis').remove();
                }
                
                var HtmlContent = '<ul class="list-group parent list-group-flush speakerList mb-2"><li class="list-group-item"><div class="media align-items-center"><img src="' + response.profilePicImage + '" alt="user avatar" class="speakerImgSize rounded"><div class="media-body ml-3"><h6 class="mb-0">' + response.speakerFirstName + '</h6><small class="small-font">' + response.speakerOrganization + ' - ' + response.speakerDesc + '</small></div><div data-id="' + response.id + '" onclick="EditSingleSpeaker(this);" Type="file UrlType="" class="mr-2"><i class="fa icon fas fa-edit clickable" style="font-size: 22px;cursor: pointer;"></i></div><div data-id="' + response.id + '" onclick="RemoveSingleSpeaker(this);" type="file" urltype="" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor:pointer;"></i></div></li></ul>';
                $('#uploadedSpeakers').append(HtmlContent);
                $('.speakerContainer').addClass('d-none');
                $(CurentForm).parent().addClass('d-none');
                $("#speakerSubmitButton").attr('data-id', '');
                $("#speakerId").val('');
                LoaderStop();
            },
            error: function (err) {
                console.log(err);
                LoaderStop();
            }
        });
    });

    $('.AddTicketForm').on('submit', function (event) {
        LoaderStart();
        event.preventDefault();
        var CurentForm = $(this);
        var urlStringTicket = "";
        var ticketId = $("#AddTicketSubmitButton").attr('data-id');
        if (ticketId != "") {
            urlStringTicket = $('.updateTicket').val();
            urlStringTicket += "/" + ticketId;
        } else {
            urlStringTicket = $('.AddTicketUrl').val();
        }

        $.ajax({
            url: urlStringTicket,
            method: "post",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                // console.log("Success: "+ response);
                if (ticketId != "") {
                    $('.CurrentlyUpdatingTicket').remove();
                }

                var HtmlContent = '<ul class="list-group parent list-group-flush TicketList mb-2 col-lg-8"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">' + response.name + ' -- ' + response.quantity + ' tickets, $' + response.price + '/ticket' + '</h6><small class="small-font">Ends on - ' + response.endDate + '</small></div><div data-id="' + response.id + '" onclick="EditSingleTicket(this);" type="file" urltype="" class="mr-2"><i class="fa icon fas fa-edit clickable" style="font-size: 22px;cursor: pointer;"></i></div><div data-id="1" onclick="RemoveSingleTicket(this);" type="file" urltype="" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li></ul>';
                $('#uploadedTickets').append(HtmlContent);
                $('.AddTicketContainer').addClass('d-none');
                // $(CurentForm).parent().addClass('d-none');
                $("#AddTicketSubmitButton").attr('data-id', '');
                $("#ticketId").val('');
                LoaderStop();
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
        var displaydateandtime = defaultdate.getMonth() + 1 + "/" + defaultdate.getDate() + "/" + defaultdate.getFullYear() + " " + defaulttime;
        $("#EventEndDateTime").val(displaydateandtime);

        $("#EventEndDateTime").datetimepicker({ 
             changeMonth: true,
             // minDate: displaydateandtime
             minDate: new Date(displaydateandtime)
        });
       
//         $("#EventEndDateTime").datetimepicker({
//     
//             minDate: defaultdate
//       }); 
    });

    var eventDateTime = new Date($("#EventDateTime").val());
    $("#SalesStart").datetimepicker({ 
             defaultDate: new Date(eventDateTime.getFullYear(), eventDateTime.getMonth(), eventDateTime.getDate()),
             changeMonth: true,
             minDate: new Date($("#EventDateTime").val()),
             maxDate: new Date($("#EventEndDateTime").val())
    });

    $("#SalesEnd").datetimepicker({ 
             defaultDate: new Date(eventDateTime.getFullYear(), eventDateTime.getMonth(), eventDateTime.getDate()),
             changeMonth: true,
             minDate: new Date($("#EventDateTime").val()),
             maxDate: new Date($("#EventEndDateTime").val())
    });

    $('#SalesStart').change(function (time) {
        var defaultdate = new Date($("#SalesStart").val());
        defaultdate.setHours(defaultdate.getHours() + 1);
        hours = defaultdate.getHours() > 12 ? (defaultdate.getHours() - 12).toString() : defaultdate.getHours().toString();
        hours = hours.length == 1 ? "0" + hours : hours;
        minutes = defaultdate.getMinutes().toString();
        minutes = minutes.length == 1 ? "0" + minutes : minutes;
        ampm = defaultdate.getHours() > 11 ? "PM" : "AM";
        defaulttime = hours + ":" + minutes + " " + ampm;
        var displaydateandtime = defaultdate.getMonth() + 1 + "/" + defaultdate.getDate() + "/" + defaultdate.getFullYear() + " " + defaulttime;
        $("#SalesEnd").val(displaydateandtime);
        $("#SalesEnd").datetimepicker({ 
             minDate: new Date(displaydateandtime)
        });
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

    $('#EventBannerImage').change(function () {
        $('#TempText').remove();
        document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('bannerImage').classList.remove('d-none');
    });

    $('#EventThumbnailImage').change(function () {
        $('#TempTextThumb').remove();
        document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('thumbnailImage').classList.remove('d-none');
    });

    $('#EventProfilePicImage').change(function () {
        $('.TempTextPic').remove();
        document.getElementById('profilePicImage').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('profilePicImage').classList.remove('d-none');
    });

    $('.EditProfilePic').change(function () {
        $('.TempTextPic').remove();
        document.getElementsByClassName('profilePicImage').src = window.URL.createObjectURL(this.files[0]);
        // document.getElementsByClassName('profilePicImage').classList.remove('d-none');
        $('.profilePicImage').removeClass('d-none');
    });

    $('#video_file').change(function () {
        $(this).parent().find('p').text(this.files.length + " file(s) selected");
    });
    $('#podcast_video_file').change(function () {
        $(this).parent().find('p').text(this.files.length + " file(s) selected");
    });

});

$('#publishButton').click(function() {
        $(".publishButton").val('true');
});

function findParent(element) {
    var parentElement = $(element).parent();
    if ($(parentElement).hasClass("parent"))
        return parentElement;
    else {
        for (var i = 0; i < 24; i++) {
            parentElement = $(parentElement).parent();
            if ($(parentElement).hasClass("parent"))
                return parentElement;
        }
    }
}

function IsOnlineEvent(element) {
    if ($(element).is(":checked")) {
        $('#Address1').attr('disabled', true);
        $('#Address1').removeAttr('required');

        $('#Address2').attr('disabled', true);

        $('.PostalCode').attr('disabled', true);
        $('.PostalCode').removeAttr('required');

        $('#city').attr('disabled', true);
        $('#city').removeAttr('required');

        $('#country').attr('disabled', true);
        $('#country').removeAttr('required');

        $('#state').attr('disabled', true);
        $('#state').removeAttr('required');

        $('#EventUrl').removeClass('d-none');
        $('#EventUrl').attr('required', 'required');
    } else {
        $('#EventUrl').addClass('d-none');
        $('#EventUrl').removeAttr('required');

        $('#Address1').attr('disabled', false);
        $('#Address1').attr('required', 'required');

        $('#Address2').attr('disabled', false);

        $('.PostalCode').attr('disabled', false);
        $('.PostalCode').attr('required', 'required');

        $('#city').attr('disabled', false);
        $('#city').attr('required', 'required');

        $('#state').attr('disabled', false);
        $('#state').attr('required', 'required');


        $('#country').attr('disabled', false);
        $('#country').attr('required', 'required');

    }
}

function UploadVideoBox(element) {
    var field = $(element).parent().parent().parent();
    if (!$(element).is(':checked')) {
        $(field).find('#input_url').attr('readonly', false);
        $(field).find("#input_url").prop('required', true);
        if ($(element).hasClass('PodCastUpload')) {
            $(field).find("#podcast_video_file").prop('required', false);
            $(field).find('.uploadPodcastVideo').addClass('d-none');
        } else {
            $(field).find("#input_vidfile").prop('required', false);
            $(field).find('.uploadVideoBox').addClass('d-none');
        }

    } else {
        $(field).find('#input_url').attr('readonly', true);
        $(field).find("#input_url").prop('required', false);
        if ($(element).hasClass('PodCastUpload')) {
            $(field).find("#podcast_video_file").prop('required', true);
            $(field).find('.uploadPodcastVideo').removeClass('d-none');
        } else {
            $(field).find("#input_vidfile").prop('required', true);
            $(field).find('.uploadVideoBox').removeClass('d-none');
        }

    }
}

function uploadVideo(element) {
    if ($(element).attr('id') == 'videoButton') {
        $('.UploadVideoContainer').removeClass('d-none');
        $('#input_title').val('');
        $('#input_url').val('');
        $('#input_url').attr('readonly', false); 
        $('#IsUploadVideo').prop('checked',false);
        $(".uploadVideoBox").addClass('d-none');
        $('#video_file').wrap('<form>').closest('form').get(0).reset();
        $('#video_file').unwrap();
        $(".uploadVideoBox").find('p').text("Drag your video file here or click in this area.");

        //   $('.videoTitle').removeClass('d-none');
        //   $('.videoUrl').removeClass('d-none');
        //   $('.videoUploadBox').removeClass('d-none'); 
        //   $('#input_url').attr('readonly', false); 
        //   $('#IsUploadVideo').prop('checked',false);

        $('.UploadPodCastContainer').addClass('d-none');
    } else if ($(element).attr('id') == 'podcastVideoButton') {
        $('.UploadPodCastContainer').removeClass('d-none');
        $('#input_title').val('');
        $('#input_url').val('');
        $('.PodcastUrl').find('#input_url').attr('readonly', false); 
        $('#IsUploadPodCast').prop('checked',false);
        $(".uploadPodcastVideo").addClass('d-none');
        $('#podcast_video_file').wrap('<form>').closest('form').get(0).reset();
        $('#podcast_video_file').unwrap();
        $(".uploadPodcastVideo").find('p').text("Drag your podcast file here or click in this area.");
        // $('.videoUrl').addClass('d-none');
        // $('.videoUploadBox').addClass('d-none');
        // $('.uploadVideoBox').addClass('d-none');
        // $('.uploadPodcastVideo').removeClass('d-none');
        // $('.uploadVideo').addClass('d-none');
        $('.UploadVideoContainer').addClass('d-none');
    }
    // $('.uploadVideo').removeClass('d-none');
}

function uploadSpeaker(element) {
    if ($(element).attr('id') == 'speakerButton') {
        if ($('.TempTextPic').hasClass('d-none')) {
            $('.TempTextPic').removeClass('d-none');
        }
        if ($('.SpeakerProfilePicDiv').find('#TempTextThumb').length == 0) {
            $('.SpeakerProfilePicDiv').append('<p id="TempTextThumb" class="TempTextPic">Drop your image here or click to upload.</p>');
        }
        $('.speakerContainer').removeClass('d-none');
        $("#speakerTitle").val('');
        $("#speakerFirstName").val('');
        // $("#speakerLastName").val('');
        $("#speakerDesc").val('');
        $("#speakerOrganization").val('');
        $("#speakerLinkedinUrl").val('');
        $("#profilePicImage").attr('src', '');
        $("#profilePicImage").addClass('d-none');
        $("#speakerSubmitButton").attr('data-id', '');
        $("#speakerId").val('');
        $(".removeprofilepic").addClass("d-none");

        if ($("#uploadedSpeakers").find(".speakerList").hasClass('d-none')) {
            $("#uploadedSpeakers").find(".speakerList").removeClass('d-none');
        }

    }
}

function getState(element) {
    var parent = findParent(element);
    //var CSRF_TOKEN = $('.csrf-token').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var urlString = $('.getState').val();
    var countryId = $(element).val();
    showInputLoader(element);
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, countryId: countryId },
        success: function (response) {
            hideInputLoader(element);
            $('#state').attr('disabled', false);
            $('#state').empty();
            $('#state').append(response);
            $('#state').attr('required', 'required');
            // console.log(response);
        }
    });
}
function getCity(element) {
    var parent = findParent(element);
    //var CSRF_TOKEN = $('.csrf-token').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var urlString = $('.getCity').val();
    var cityId = $(element).val();
    showInputLoader(element);
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, cityId: cityId },
        success: function (response) {
            hideInputLoader(element);
            $('#city').attr('disabled', false);
            $('#city').empty();
            $('#city').append(response);
            $('#city').attr('required', 'required');
        }
    });
}
function ShowAddressFields(element) {
    $('#Address1').attr('disabled', false);
    $('#Address1').attr('required', 'required');
    $('#Address2').attr('disabled', false);
    $('.PostalCode').attr('disabled', false);
}

function RemoveSingleVideo(element) {
    LoaderStart();
    var id = $(element).attr('data-id');
    var type = $(element).attr('Type');
    var urltype = $(element).attr('urltype');
    var Field = findParent(element);
    var urlString = $('.RemoveEventVideos').val();
    urlString += "/" + id + "/" + type + "/" + urltype;
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

function RemoveSingleSpeaker(element) {
    LoaderStart();
    var id = $(element).attr('data-id');
    // var type = $(element).attr('Type');
    // var urltype = $(element).attr('urltype');
    var Field = findParent(element);
    var urlString = $('.removeEventSpeakers').val();
    urlString += "/" + id + "/speaker/blank";
    var CSRF_TOKEN = $('.csrf-token').val();
    var countryId = $(element).val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, id: id },
        success: function (response) {
            $(Field).remove();
            LoaderStop();
            console.log(response);
        },
        error: function (error) {
            alert('An Error Occured');
            LoaderStop();
            console.log(error);
        }
    });

}

function EditSingleSpeaker(element) {
    LoaderStart();
    $('.editSpeakerContainer').removeClass('d-none');
    $("#profilePicImage").removeClass("d-none");
    $(".TempTextPic").addClass("d-none");
    $(".deletePicDiv").removeClass("d-none");

    event.preventDefault();
    var id = $(element).attr('data-id');
    // var type = $(element).attr('Type');
    // var urltype = $(element).attr('urltype');
    var Field = findParent(element);
    $(Field).addClass('CurrentlyUpdatingThis');
    var urlString = $('.editEventSpeakers').val();
    urlString += "/" + id;
    var CSRF_TOKEN = $('.csrf-token').val();
    var countryId = $(element).val();

    if (!$(".speakerContainer").hasClass('d-none')) {
        $(".speakerContainer").addClass('d-none');
    }
    if ($("#uploadedSpeakers").find(".speakerList").hasClass('d-none')) {
        $("#uploadedSpeakers").find(".speakerList").removeClass('d-none');
    }

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, id: id },
        success: function (response) {
            // $(".speakerContainer").removeClass('d-none');
            $("#speakerTitle").val(response.title);
            $("#speakerFirstName").val(response.name);
            // $("#speakerLastName").val(response.last_name);
            $("#speakerDesc").val(response.description);
            $("#speakerOrganization").val(response.organization);
            $("#speakerLinkedinUrl").val(response.linkedin_url);
            $("#profilePicImage").attr('src', response.profile_pic);
            $("#speakerSubmitButton").attr('data-id', response.id);
            $("#speakerId").val(response.id);

            if (response.profile_pic != "") {
                $("#profilePicImage").removeClass('d-none');
                $(".removeprofilepic").removeClass('d-none');
                $(".TempTextPic").addClass('d-none');
            } else {
                $("#profilePicImage").addClass('d-none');
                $(".removeprofilepic").addClass('d-none');
                $(".TempTextPic").removeClass('d-none');
            }

            $('html, body').animate({
                'scrollTop': $("#SaveSpeaker").position().top
            });
            $(Field).addClass('d-none');
            $(".speakerContainer").removeClass('d-none');

            // $(Field).addClass('d-none');
            // $(Field).parent().find('.editSpeakerContainer').removeClass('d-none');
            // if($(Field).parent().find("#profilePicImage").attr('db-pic') != ""){
            //     $(Field).parent().find("#profilePicImage").removeClass("d-none");
            //     $(Field).parent().find(".TempTextPic").addClass("d-none");
            //     $(Field).parent().find(".deletePicDiv").removeClass("d-none");
            // } else{
            //     $(Field).parent().find("#profilePicImage").addClass("d-none");
            //     $(Field).parent().find(".TempTextPic").removeClass("d-none");
            //     $(Field).parent().find(".deletePicDiv").addClass("d-none");
            // }
            LoaderStop();
            console.log(response);
        },
        error: function (error) {
            alert('An Error Occured');
            LoaderStop();
            console.log(error);
        }
    });

}

function removeOldProfilePic(element) {
    LoaderStart();
    var Field = findParent(element);
    var dataPic = $(element).attr('data-pic');
    var id = $(Field).parent().find(".speakerId").val();
    var urlString = $('.deleteProfilePic').val();
    var CSRF_TOKEN = $('.csrf-token').val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, id: id, dataPic: dataPic },
        success: function (response) {
            console.log(response);
            $(Field).parent().find(".TempTextPic").removeClass('d-none');
            $(Field).parent().find(".deletePicDiv").addClass('d-none');
            $(Field).parent().find(".profilePicImage").addClass('d-none');
            $(Field).parent().find(".profilePicImage").attr('src', '');
            $(Field).parent().find(".profilePicImage").attr('db-pic', '');
            LoaderStop();
        },
        error: function (error) {
            // alert('An Error Occured');
            LoaderStop();
            console.log(error);
        }
    });
}

function showSpeakerListing(element) {
    $("#uploadedSpeakers").find(".speakerList").removeClass('d-none');
    $(".speakerContainer").addClass('d-none');
    $(".CurrentlyUpdatingThis").removeClass('CurrentlyUpdatingThis');

}

function showTicketListing(element) {
    $("#uploadedTickets").find(".TicketList").removeClass('d-none');
    $(".AddTicketContainer").addClass('d-none');
    $(".CurrentlyUpdatingTicket").removeClass('CurrentlyUpdatingTicket');
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
            }
            if ($status == '2') {
                $(element).attr('status', '1');
                $(element).text('Pause');
            }
            if ($status == '3') {
                $(".pauseButton").addClass('d-none');
                $(".cancelButton").addClass('d-none');
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function doConfirm(msg, yesFn, noFn) {
    var confirmBox = $("#confirmBox");
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function () {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();
}

function ValidateEventForm(element) {
    // var IsOnline = $(element).find("#IsOnline");
    // if (!$(IsOnline).is(':checked')) {

    // }
    var checkUrl = window.location.href;
    var eventPageUrl = $(".eventsPage").val();
    var eventStartDateChange=$(".eventStartDateChange").val();
    var eventEndDateChange=$(".eventEndDateChange").val();
    var eventTimezoneChange = $(".eventTimezoneChange").val();
    var EventDateTime = $("#EventDateTime").val();
    var EventEndDateTime = $("#EventEndDateTime").val();
    var cityTimezone = $("#cityTimezone").val();
    if(checkUrl.includes('new')== false && ((eventStartDateChange != EventDateTime) || (eventEndDateChange != EventEndDateTime) || (eventTimezoneChange != cityTimezone))){
        event.preventDefault();
        doConfirm("Do you want to inform all attendees about this change?", function yes() {
            $(element).unbind('submit').submit();
            // return false;
        }, function no() {
            $(element).unbind('submit').submit();
            // window.location.href = eventPageUrl;
        });
    }else{
        // $(element).unbind('submit').submit();
    }

}
function ChangeCustomUrl(element) {
    var currentText = $(element).val();
    var actualUrl = $('#HumanFriendlyUrl').attr('data');
    // $('#HumanFriendlyUrl').text(actualUrl + currentText);
    $(".textPreview").text("Preview URL:");
    $('#HumanFriendlyUrl').text("https://www.panelhive.com/" + currentText);
}

function copyHumanFriendlyUrl(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($("#HumanFriendlyUrl").text()).select();
    document.execCommand('copy');
    $(".copied").text("Copied to clipboard").show().fadeOut(1200);
    $temp.remove();
}

function addCustomUrl(element){
    var parent = findParent(element);
    var eventTitle = $(element).attr('event-title');
    var eventCustomUrl = $(element).parent().find('.eventCustomUrl').val();
    $(".headerTitle").text("Set custom URL for " + eventTitle);
    $(".textPreview").text("Preview URL:");
    $(".eventId").val($(element).attr('db-event-id'));
    $("#successMessage").addClass('d-none');
    $("#customUrlDuplicate").addClass('d-none');
    if(eventCustomUrl != ""){
        $("#CustomUrl").val(eventCustomUrl);
        $('#HumanFriendlyUrl').text("https://www.panelhive.com/" + eventCustomUrl);
        $(".socialMediaLinks").removeClass('d-none');
    } else{
        $("#CustomUrl").val('');
        $('#HumanFriendlyUrl').text("https://www.panelhive.com/...");
        $(".socialMediaLinks").addClass('d-none');
    }
}

function saveCustomUrl(element) {
    var parent = findParent(element);
    var eventId = $("#openCustomUrlPopup").find(".eventId").val();
    var CustomUrl = $("#CustomUrl").val();
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.saveCustomUrl').val();
    LoaderStart();
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, eventId: eventId, CustomUrl: CustomUrl },
        success: function (response) {
            console.log(response);
            // var arr = response;
            // if(arr.length > 0){
            if(response != ""){
                $('#customUrlDuplicate').removeClass('d-none');
                $('#successMessage').addClass('d-none');
            } else{
                $('#customUrlDuplicate').addClass('d-none');
                $('#successMessage').removeClass('d-none');
            }
            LoaderStop();
            // location.reload();
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function IsPaidAlert(element) {
    var val = $(element).val();
    if (val == "false") {
        if ($('.PaidAlertBox').hasClass('d-none')) {
            $('.PaidAlertBox').removeClass('d-none');
        }
    } else {
        if (!$('.PaidAlertBox').hasClass('d-none')) {
            $('.PaidAlertBox').addClass('d-none');
        }
    }
}

function copyEvent(element) {
    var confirmCopy = confirm("Are you sure you want to copy this event details?");
    if (!confirmCopy)
        return;
    var parent = findParent(element);
    var eventId = $(element).attr('db-event-id');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.copyEvent').val();
    LoaderStart();
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, eventId: eventId },
        success: function (response) {
            console.log(response);
            LoaderStop();
            location.reload();
        },
        error: function (err) {
            console.log(err);
            LoaderStop();
        }
    });
}

function uploadTicket(element) {
    if ($(element).attr('id') == 'ticketButton') {
        $('.AddTicketContainer').removeClass('d-none');
        $("#TicketName").val('');
        $("#TicketQuantity").val('');
        $("#TicketPrice").val('');
        $("#SalesStart").val('');
        $("#SalesEnd").val('');
        $("#AddTicketSubmitButton").attr('data-id', '');
        $("#ticketId").val('');

        if ($("#uploadedTickets").find(".TicketList").hasClass('d-none')) {
            $("#uploadedTickets").find(".TicketList").removeClass('d-none');
        }

    }
}

function EditSingleTicket(element) {
    LoaderStart();
    $('.AddTicketContainer').removeClass('d-none');

    event.preventDefault();
    var id = $(element).attr('data-id');
    var Field = findParent(element);
    $(Field).addClass('CurrentlyUpdatingTicket');
    var urlString = $('.editEventTickets').val();
    urlString += "/" + id;
    var CSRF_TOKEN = $('.csrf-token').val();
    var countryId = $(element).val();

    if (!$(".AddTicketContainer").hasClass('d-none')) {
        $(".AddTicketContainer").addClass('d-none');
    }
    if ($("#uploadedTickets").find(".TicketList").hasClass('d-none')) {
        $("#uploadedTickets").find(".TicketList").removeClass('d-none');
    }

    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, id: id },
        success: function (response) {
            // $(".speakerContainer").removeClass('d-none');
            $("#TicketName").val(response.name);
            $("#TicketQuantity").val(response.quantity);
            $("#TicketPrice").val(response.price);
            $("#SalesStart").val(response.sales_start);
            $("#SalesEnd").val(response.sales_end);
            $("#AddTicketSubmitButton").attr('data-id', response.id);
            $("#ticketId").val(response.id);

            $('html, body').animate({
                'scrollTop': $(".AddTicketForm").position().top
            });
            $(Field).addClass('d-none');
            $(".AddTicketContainer").removeClass('d-none');

            LoaderStop();
            // console.log(response);
        },
        error: function (error) {
            alert('An Error Occured');
            LoaderStop();
            console.log(error);
        }
    });

}

function RemoveSingleTicket(element) {
    LoaderStart();
    var id = $(element).attr('data-id');
    // var type = $(element).attr('Type');
    // var urltype = $(element).attr('urltype');
    var Field = findParent(element);
    var urlString = $('.removeEventTickets').val();
    urlString += "/" + id + "/ticket/blank";
    var CSRF_TOKEN = $('.csrf-token').val();
    // var countryId = $(element).val();

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
            console.log(error);
        }
    });

}

function removeDisable(){
    if($("#EventDateTime").val() != ''){
        $('#EventEndDateTime').removeAttr("disabled");
    }
    else{
        $('#EventEndDateTime').addAttr("disabled");
    }
}

// function isPublishEvent(element){
//     // if($(element).attr('id') == "publishButton"){
//     //     $(".publishEvent").val('true');
//     // }
//     // else{
//     //     $(".publishEvent").val('');
//     // }
// }