$(document).ready(function () {
    setEventDateAndTime();

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
                if(response.error!=''){
                    $('.VideoInvalid').append(response.error.video_file);
                    alert(response.error.video_file);
                }else{
                    var HtmlContent='<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">'+response.videoTitle+'</h6><small class="small-font">'+response.videoUrl+'</small></div><div data-id="'+response.videoID+'" Type="video" urltype="'+response.urlType+'" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
                    $('#UploadedVideos').append(HtmlContent);
                    $(CurentForm).find('#input_url').val('');
                    $(CurentForm).find('#input_title').val('');
                    $('.UploadVideoContainer').addClass('d-none');
                    $('.VideoInvalid').empty();
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
        var CurentForm=$(this);
        var urlString = $('.addPodCastVideos').val();
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
                if(response.error!=''){
                    $('.PodcastInvalid').append(response.error.podcast_video_file);
                    // $(validateField).append(response.error.podcast_video_file);
                    alert(response.error.podcast_video_file);
                }else{
                var HtmlContent='<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">'+response.videoTitle+'</h6><small class="small-font">'+response.videoUrl+'</small></div><div data-id="'+response.videoID+'" Type="podcast" urltype="'+response.urlType+'" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
                $('#UploadedVideos').append(HtmlContent);
                $(CurentForm).find('#input_url').val('');
                $(CurentForm).find('#input_title').val('');
                $('.UploadPodCastContainer').addClass('d-none');
                $('.PodcastInvalid').empty();
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
        var CurentForm=$(this);
        // var urlStringSpeaker = $('.addSpeakers').val();
        var urlStringSpeaker = "";
        var speakerId = $("#speakerSubmitButton").attr('data-id');
        if(speakerId != ""){
            urlStringSpeaker = $('.updateSpeaker').val();
            urlStringSpeaker += "/" + speakerId;
        } else{
            urlStringSpeaker = $('.addSpeakers').val();
        }
        var formData = new FormData(this);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        var speakerTitle = $("#speakerTitle").val();
        var speakerFirstName = $("#speakerFirstName").val();
        var speakerLastName = $("#speakerLastName").val();
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
                // var HtmlContent='<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">'+ response.speakerTitle +' </h6><small class="small-font">'+ response.profilePicImage +'</small></div><div data-id="'+ response.id +'" onclick="RemoveSingleSpeaker(this);" type="file" urltype="" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor:pointer;"></i></div></div></li></ul>';
                var HtmlContent = '<ul class="list-group parent list-group-flush shadow-none"><li class="list-group-item"><div class="media align-items-center"><img src="'+ response.profilePicImage +'" alt="user avatar" class="customer-img rounded" height="100" width="100"><div class="media-body ml-3"><h6 class="mb-0">'+ response.speakerFirstName + response.speakerLastName +'</h6><small class="small-font">'+ response.speakerOrganization + ' - ' + response.speakerDesc +'</small></div><div data-id="'+ response.id +'" onclick="EditSingleSpeaker(this);" Type="file UrlType="" class="mr-2"><i class="fa icon fas fa-edit clickable" style="font-size: 22px;cursor: pointer;"></i></div><div data-id="'+ response.id +'" onclick="RemoveSingleSpeaker(this);" type="file" urltype="" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor:pointer;"></i></div></li></ul>';
                $('#uploadedSpeakers').append(HtmlContent);
                $('.speakerContainer').addClass('d-none');
                $(CurentForm).parent().addClass('d-none');
                // $(CurentForm).parent().parent().find('.speakerList')removeClass('d-none');
                $("#speakerSubmitButton").attr('data-id','');
                $("#speakerId").val('');
                // $('.PodcastInvalid').empty();
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

    $('#EventBannerImage').change(function() {
        $('#TempText').remove();
        document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('bannerImage').classList.remove('d-none');
    });

    $('#EventThumbnailImage').change(function() {
        $('#TempTextThumb').remove();
        document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('thumbnailImage').classList.remove('d-none');
    });

    $('#EventProfilePicImage').change(function() {
        $('.TempTextPic').remove();
        document.getElementById('profilePicImage').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('profilePicImage').classList.remove('d-none');
    });

    $('.EditProfilePic').change(function() {
        $('.TempTextPic').remove();
        document.getElementsByClassName('profilePicImage').src = window.URL.createObjectURL(this.files[0]);
        // document.getElementsByClassName('profilePicImage').classList.remove('d-none');
        $('.profilePicImage').removeClass('d-none');
    });

    $('#video_file').change(function() {
        $(this).parent().find('p').text(this.files.length + " file(s) selected");
    });
    $('#podcast_video_file').change(function() {
        $(this).parent().find('p').text(this.files.length + " file(s) selected");
    });

});

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
        //   $('.videoTitle').removeClass('d-none');
        //   $('.videoUrl').removeClass('d-none');
        //   $('.videoUploadBox').removeClass('d-none'); 
        //   $('#input_url').attr('readonly', false); 
        //   $('#IsUploadVideo').prop('checked',false);

        $('.UploadPodCastContainer').addClass('d-none');
    } else if ($(element).attr('id') == 'podcastVideoButton') {
        $('.UploadPodCastContainer').removeClass('d-none');
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
        $('.speakerContainer').removeClass('d-none');
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
        data: {_token: CSRF_TOKEN, countryId: countryId},
        success: function (response) {
            hideInputLoader(element);
            $('#state').attr('disabled', false);
            $('#state').empty();
            $('#state').append(response);
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
        data: {_token: CSRF_TOKEN, cityId: cityId},
        success: function (response) {
            hideInputLoader(element);
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

function RemoveSingleVideo(element) {
    LoaderStart();
    var id = $(element).attr('data-id');
    var type = $(element).attr('Type');
    var urltype = $(element).attr('urltype');
    var Field = findParent(element);
    var urlString = $('.RemoveEventVideos').val();
    urlString += "/" + id + "/" + type+ "/" + urltype;
    var CSRF_TOKEN = $('.csrf-token').val();
    var countryId = $(element).val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, id: id},
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
        data: {_token: CSRF_TOKEN, id: id},
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
    var urlString = $('.editEventSpeakers').val();
    urlString += "/" + id;
    var CSRF_TOKEN = $('.csrf-token').val();
    var countryId = $(element).val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, id: id},
        success: function (response) {
            $(".speakerContainer").removeClass('d-none');
            $("#speakerTitle").val(response.title);
            $("#speakerFirstName").val(response.first_name);
            $("#speakerLastName").val(response.last_name);
            $("#speakerDesc").val(response.description);
            $("#speakerOrganization").val(response.organization);
            $("#speakerLinkedinUrl").val(response.linkedin_url);
            $("#profilePicImage").val(response.profile_pic);
            $("#speakerSubmitButton").attr('data-id', response.id);
            $("#speakerId").val(response.id);

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

function removeOldProfilePic(element){
    LoaderStart();
    var Field = findParent(element);
    var dataPic = $(element).attr('data-pic');
    var id = $(Field).parent().find(".speakerId").val();
    var urlString = $('.deleteProfilePic').val();
    var CSRF_TOKEN = $('.csrf-token').val();

    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, id: id, dataPic:dataPic},
        success: function (response) {
            console.log(response);
            $(Field).parent().find(".TempTextPic").removeClass('d-none');
            $(Field).parent().find(".deletePicDiv").addClass('d-none');
            $(Field).parent().find(".profilePicImage").addClass('d-none');
            $(Field).parent().find(".profilePicImage").attr('src','');
            $(Field).parent().find(".profilePicImage").attr('db-pic','');
            LoaderStop();
        },
        error: function (error) {
            // alert('An Error Occured');
            LoaderStop();
            console.log(error);
        }
    });
}