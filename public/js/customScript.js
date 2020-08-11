$(document).ready(function () {
    setEventDateAndTime();
    // var table = $('#default-datatable').DataTable({
    //     columnDefs: [
    //         {orderable: false, targets: 4},
    //     ]
    // });

    // var videosTable = $('#default-datatable-videos').DataTable({
    //     columnDefs: [
    //         {orderable: false, targets: 2},
    //     ]
    // });

    // var podcastsTable = $('#default-datatable-podcasts').DataTable({
    //     columnDefs: [
    //         {orderable: false, targets: 2},
    //     ]
    // });

    // var contactsTable = $('#default-datatable-contacts').DataTable({
    //     columnDefs: [
    //         {orderable: false, targets: 4},
    //     ]
    // });

    // $('#profileImg').change(function () {
    //     $('.textForProfile').remove();
    //     document.getElementById('profileImgSrc').src = window.URL.createObjectURL(this.files[0]);
    //     document.getElementById('profileImgSrc').classList.remove('d-none');
    // });

    // $('#profileBannerImage').change(function () {
    //     $('#textForProfileBanner').remove();
    //     document.getElementById('profileBannerImageSrc').src = window.URL.createObjectURL(this.files[0]);
    //     document.getElementById('profileBannerImageSrc').classList.remove('d-none');
    // });

    // // $('#tagsForm').on('submit', function (event) {
    // $('#tagsForm').keydown(function (event){
    //     if(event.keyCode == 13){
    //     LoaderStart();
    //     event.preventDefault();
    //     var CurentForm = $(this);
    //     var urlString = $('.addTags').val();
    //     var formData = new FormData(this);
    //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    //     $.ajax({
    //         url: urlString,
    //         method: "POST",
    //         data: new FormData(this),
    //         dataType: 'JSON',
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function (response) {
    //             // console.log(response);
    //             if (response.error != '') {
    //                 $('.tagInvalid').append(response.error.tagName);
    //                 alert(response.error.tagName);
    //                 LoaderStop();
    //             } else {
    //             $("#tagName").val('');
    //             // $("#allTags").append(response.tagName);
    //             $("#allTags").append('<option value="' + response.id +  '" selected="selected">' + response.tagName +  '</option>');
    //             LoaderStop();
    //             }
    //         },
    //         error: function (err) {
    //             console.log(err);
    //             // LoaderStop();
    //         }
    //     });
    // }
    // });

    // $('#SaveVideoAjax').on('submit', function (event) {
    //     event.preventDefault();
    //     LoaderStart();
    //     var CurentForm = $(this);
    //     var urlString = $('.addEventVideos').val();
    //     var formData = new FormData(this);
    //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    //     $.ajax({
    //         url: urlString,
    //         method: "POST",
    //         data: new FormData(this),
    //         dataType: 'JSON',
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function (response) {
    //             //var HtmlContent="<div>"+response.videoUrl+"</div> <div>"+response.videoTitle+"</div>";
    //             var HtmlContent = '<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">' + response.videoTitle + '</h6><small class="small-font">' + response.videoUrl + '</small></div><div data-id="' + response.videoID + '" Type="video" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
    //             $('#UploadedVideos').append(HtmlContent);
    //             $(CurentForm).find('#input_url').val('');
    //             $(CurentForm).find('#input_title').val('');
    //             $('.UploadVideoContainer').addClass('d-none');
    //             LoaderStop();
    //         },
    //         error: function (err) {
    //             console.log(err);
    //             LoaderStop();
    //         }
    //     });
    // });

    // $('#SavePodCastAjax').on('submit', function (event) {
    //     LoaderStart();
    //     event.preventDefault();
    //     var CurentForm = $(this);
    //     var urlString = $('.addPodCastVideos').val();
    //     var formData = new FormData(this);
    //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    //     $.ajax({
    //         url: urlString,
    //         method: "POST",
    //         data: new FormData(this),
    //         dataType: 'JSON',
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function (response) {
    //             //var HtmlContent="<div>"+response.videoUrl+"</div> <div>"+response.videoTitle+"</div>";
    //             var HtmlContent = '<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">' + response.videoTitle + '</h6><small class="small-font">' + response.videoUrl + '</small></div><div data-id="' + response.videoID + '" Type="podcast" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
    //             $('#UploadedVideos').append(HtmlContent);
    //             $(CurentForm).find('#input_url').val('');
    //             $(CurentForm).find('#input_title').val('');
    //             $('.UploadPodCastContainer').addClass('d-none');
    //             LoaderStop();
    //         },
    //         error: function (err) {
    //             console.log(err);
    //             LoaderStop();
    //         }
    //     });
    // });

    // $('#EventDateTime').change(function (time) {
    //     var dateRi = $(this).val();
    //     var defaultdate;
    //     var defaulttime;
    //     var hours;
    //     var minutes;
    //     var ampm;
    //     defaultdate = new Date($(this).val());
    //     defaultdate.setHours(defaultdate.getHours() + 1);
    //     hours = defaultdate.getHours() > 12 ? (defaultdate.getHours() - 12).toString() : defaultdate.getHours().toString();
    //     hours = hours.length == 1 ? "0" + hours : hours;
    //     minutes = defaultdate.getMinutes().toString();
    //     minutes = minutes.length == 1 ? "0" + minutes : minutes;
    //     ampm = defaultdate.getHours() > 11 ? "PM" : "AM";
    //     defaulttime = hours + ":" + minutes + " " + ampm;
    //     $("#EventEndDateTime").val(defaultdate.getMonth() + 1 + "/" + defaultdate.getDate() + "/" + defaultdate.getFullYear() + " " + defaulttime);
    // });
    // $(".files").on("change", function (e) {
    //     var files = e.target.files,
    //             filesLength = files.length;

    //     for (var i = 0; i < filesLength; i++) {
    //         var f = files[i]
    //         var sizeKB = f.size / 1024;
    //         var sizeMB = sizeKB / 1024;
    //         console.log(f.naturalWidth);
    //         if (sizeMB > 4) {
    //             $(this).parent().parent().find('.SizeError').removeClass('d-none');
    //             $(this).parent().parent().find('.SizeError').addClass('Invalid');
    //             $('#Submit').attr('disabled', true);
    //             return false;
    //         }
    //         if ($(this).parent().parent().find('.SizeError').hasClass('Invalid')) {
    //             $(this).parent().parent().find('.SizeError').addClass('d-none');
    //             $('#Submit').attr('disabled', false);
    //         }
    //     }
    // });
                
});



//function jainiltest(element){
//    var start = document.getElementById('#EventDateTime');
//                var end = document.getElementById('#EventEndDateTime');
//
//                start.addEventListener('change', function() {
//                    if (start.value)
//                        end.min = start.value;
//                }, false);
//                end.addEventLiseter('change', function() {
//                    if (end.value)
//                        start.max = end.value;
//                }, false);
//
//    
//}

//For Postal Code Input Only Write Numbers
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       
         var _URL = window.URL || window.webkitURL;
          $("#EventBannerImage").change(function(e) {
            var file = $(this)[0].files[0];
           if ((file = this.files[0])){
        image = new Image();
          image.onload = function() {
//            alert(this.width + "@" + this.height);
            // if(this.width === 845 && this.height === 445){
//				$('#TempText').remove();
//        document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);
//        document.getElementById('bannerImage').classList.remove('d-none');
                // return true;
              // }
            if(this.width< 845 && this.height < 445){
                $("#bannerImage").addClass("SmallImages");
                $(".removebtn").removeClass("d-none");
                return true;
            }else if(this.width === 845 && this.height === 445){
                $(".removebtn").removeClass("d-none");
                return true;
            }else{
                alert("Maximum image dimension allowed is : 845x445 pixels.");
                $('#bannerImage').attr("src", "");
                $('#EventBannerImage').val("");
                document.getElementById('bannerImage').src = "";
                document.getElementById('bannerImage').classList.add('d-none');
                $('#dragfile').append("<p id='TempText'>Drop your image here or click to upload.</p>");
               
				return true;
            }
        }
        image.src = _URL.createObjectURL(file);
    
     }
});

$('#RemoveImgBtn').on('click', function(e){
    $('#bannerImage').attr("src", "");
    $('#EventBannerImage').val("");
    $(".removebtn").addClass("d-none");
    document.getElementById('bannerImage').src = "";
        document.getElementById('bannerImage').classList.add('d-none');
        $(".eventBannerPic").val("");
    $('#dragfile').append("<p id='TempText'>Drop your image here or click to upload.</p>");
    $("#bannerImage").removeClass("SmallImages");
     //<p id="TempText">Drop your image here or click to upload.</p>
});

var _URL = window.URL || window.webkitURL;
          $("#EventThumbnailImage").change(function(e) {
            var file = $(this)[0].files[0];
           if ((file = this.files[0])){
        image = new Image();
          image.onload = function() {
//            alert(this.width + "@" + this.height);
            // if(this.width === 845 && this.height === 445){
//              $('#TempText').remove();
//        document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);
//        document.getElementById('bannerImage').classList.remove('d-none');
                // return true;
              // }
            if(this.width< 420 && this.height < 360){
                $("#thumbnailImage").addClass("SmallImages");
                $(".removethumbnail").removeClass("d-none");
                return true;
            }else if(this.width === 420 && this.height === 360){
                $(".removethumbnail").removeClass("d-none");
                return true;
            }else{
                alert("Maximum image dimension allowed is : 420x360 pixels.");
                $('#thumbnailImage').attr("src", "");
                $('#EventThumbnailImage').val("");
                $(".removethumbnail").addClass("d-none");
                document.getElementById('thumbnailImage').src = "";
                document.getElementById('thumbnailImage').classList.add('d-none');
                $('.thumbNailContainer').append("<p id='TempTextThumb'>Drop your image here or click to upload.</p>");
               
                return true;
            }
        }
        image.src = _URL.createObjectURL(file);
    
     }
});

$('#RemoveThumbnailBtn').on('click', function(e){
    $('#EventThumbnailImage').attr("src", "");
    $('#EventThumbnailImage').val("");
    $(".removethumbnail").addClass("d-none");
    document.getElementById('EventThumbnailImage').src = "";
        document.getElementById('thumbnailImage').classList.add('d-none');
        $(".eventThumbPic").val("");
    $('.thumbNailContainer').append("<p id='TempTextThumb'>Drop your image here or click to upload.</p>");
     //<p id="TempTextThumb">Drop your image here or click to upload.</p>
});

var _URL = window.URL || window.webkitURL;
$("#EventProfilePicImage").change(function(e) {
            var file = $(this)[0].files[0];
           if ((file = this.files[0])){
        image = new Image();
          image.onload = function() {
//            alert(this.width + "@" + this.height);
            // if(this.width === 845 && this.height === 445){
//              $('#TempText').remove();
//        document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);
//        document.getElementById('bannerImage').classList.remove('d-none');
                // return true;
              // }
            if(this.width< 420 && this.height < 360){
                $("#profilePicImage").addClass("SmallImages");
                $(".removeprofilepic").removeClass("d-none");
                $(".picText").addClass("d-none");
                return true;
            }else if(this.width === 420 && this.height === 360){
                $(".removeprofilepic").removeClass("d-none");
                $(".picText").addClass("d-none");
                return true;
            }else{
                alert("Maximum image dimension allowed is : 420x360 pixels.");
                $('#profilePicImage').attr("src", "");
                $('#EventProfilePicImage').val("");
                $(".removeprofilepic").addClass("d-none");
                document.getElementById('profilePicImage').src = "";
                document.getElementById('profilePicImage').classList.add('d-none');
                $("#profilePicImage").find("#TempTextOrgBanner").addClass('d-none');
                // $(".TempTextPic").removeClass('d-none');
                $(".picText").addClass("d-none");
                $('.SpeakerProfilePicDiv').append("<p id='TempTextThumb' class='TempTextPic'>Drop your image here or click to upload.</p>");
               
                return true;
            }
        }
        image.src = _URL.createObjectURL(file);
    
     }
});

$('#RemoveProfileBtn').on('click', function(e){
    $('#EventProfilePicImage').attr("src", "");
    $('#EventProfilePicImage').val("");
    $(".removeprofilepic").addClass("d-none");
    document.getElementById('EventProfilePicImage').src = "";
        document.getElementById('profilePicImage').classList.add('d-none');
        $("#profilePicImage").find("#TempTextOrgBanner").addClass('d-none');
        $(".eventSpeakerPic").val("");
        $(".picText").addClass("d-none");
    // $(".TempTextPic").removeClass('d-none');
    $('.SpeakerProfilePicDiv').append("<p id='TempTextThumb' class='TempTextPic'>Drop your image here or click to upload.</p>");
     //<p id="TempTextThumb">Drop your image here or click to upload.</p>
});

var _URL = window.URL || window.webkitURL;
          $("#profileBannerImage").change(function(e) {
            var file = $(this)[0].files[0];
           if ((file = this.files[0])){
        image = new Image();
          image.onload = function() {
            if(this.width< 845 && this.height < 445){
                $("#profileBannerImageSrc").addClass("SmallImages");
                $(".TempTextBanner").addClass('d-none');
                $(".removeorgbannerbtn").removeClass("d-none");
                return true;
            }else if(this.width === 845 && this.height === 445){
                $(".removeorgbannerbtn").removeClass("d-none");
                $(".TempTextBanner").addClass('d-none');
                return true;
            }else{
                alert("Maximum image dimension allowed is : 845x445 pixels.");
                $('#profileBannerImageSrc').attr("src", "");
                $('#profileBannerImage').val("");
                document.getElementById('profileBannerImageSrc').src = "";
                document.getElementById('profileBannerImageSrc').classList.add('d-none');
                $(".TempTextBanner").addClass('d-none');
                $(".removeorgbannerbtn").addClass("d-none");
                $('#orgDragBannerFile').append("<p class='TempTextBanner'>Drop your image here or click to upload.</p>");
               
                return true;
            }
        }
        image.src = _URL.createObjectURL(file);
    
     }
});

$('#RemoveOrgBannerButton').on('click', function(e){
    $('#profileBannerImage').attr("src", "");
    $('#profileBannerImage').val("");
    $(".removeorgbannerbtn").addClass("d-none");
    $(".userBanner").val("");
    document.getElementById('profileBannerImage').src = "";
        document.getElementById('profileBannerImageSrc').classList.add('d-none');
        // $("#TempTextBanner").removeClass('d-none');
    $('#orgDragBannerFile').append("<p class='TempTextBanner'>Drop your image here or click to upload.</p>");
    $("#profileBannerImageSrc").removeClass("SmallImages");
});

var _URL = window.URL || window.webkitURL;
$("#profileImg").change(function(e) {
            var file = $(this)[0].files[0];
           if ((file = this.files[0])){
        image = new Image();
          image.onload = function() {
            if(this.width< 420 && this.height < 360){
                $("#profileImgSrc").addClass("SmallImages");
                $(".removeuserprofile").removeClass("d-none");
                return true;
            }else if(this.width === 420 && this.height === 360){
                $(".removeuserprofile").removeClass("d-none");
                return true;
            }else{
                alert("Maximum image dimension allowed is : 420x360 pixels.");
                $('#profileImgSrc').attr("src", "");
                $('#profileImg').val("");
                $(".removeuserprofile").addClass("d-none");
                document.getElementById('profileImgSrc').src = "";
                document.getElementById('profileImgSrc').classList.add('d-none');
                // $("#profileImgSrc").find("#TempTextOrgBanner").addClass('d-none');
                $('.orgProfile').append("<p id='textForProfile' class='textForProfile'>Drop your image here or click to upload.</p>");
               
                return true;
            }
        }
        image.src = _URL.createObjectURL(file);
    
     }
});

$('#RemoveUserProfileBtn').on('click', function(e){
    $('#profileImg').attr("src", "");
    $('#profileImg').val("");
    $(".removeuserprofile").addClass("d-none");
    document.getElementById('profileImg').src = "";
    document.getElementById('profileImgSrc').classList.add('d-none');
    $(".userProfile").val("");
    // $("#profileImgsrc").find("#TempTextOrgBanner").addClass('d-none');
    $('.orgProfile').append("<p id='textForProfile' class='textForProfile'>Drop your image here or click to upload.</p>");
});

function findParentForm(element) {
    var parentElement = $(element).parent();
    if ($(parentElement).is("form"))
        return parentElement;
    else {
        for (var i = 0; i < 12; i++) {
            parentElement = $(parentElement).parent();
            if ($(parentElement).is("form"))
                return parentElement;
        }
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
        } else {
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
            // format: $(this).attr("data-hidetimepicker") == "True" ? 'd/m/Y' : 'd/m/Y g:i A',
            format: $(this).attr("data-hidetimepicker") == "True" ? 'm/d/Y' : 'm/d/Y g:i A',
            validateOnBlur: false,
            step: 15,
            customButtons: $(this).attr("data-setcustombuttons") == "True" ? true : false,
            scrollInput: false,
            minDate: new Date()
        }); 
        
        
    });   
}
//$("#EventDateTime").datetimepicker({ 
//        lang: 'en',
//        onSelect: function(date){
//        alert("hello");
//        var selectedDate = new Date(date);
//        var msecsInADay = 86400000;
//        var endDate = new Date(selectedDate.getTime() + msecsInADay);
//
//       //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
//         $("#EventEndDateTime").datetimepicker( "option", "setDate", endDate );
//        $("#EventEndDateTime").datetimepicker( "option", "minDate", endDate );
//        $("#EventEndDateTime").datetimepicker( "option", "maxDate", '+2y' );
//
//    }
//});
//
//$("#EventEndDateTime").datetimepicker({ 
//    changeMonth: true
//});
////Fri Jul 10 2020 18:30:14 GMT+0530 (India Standard Time)
// $('#EventDateTime').change(function() {
//   var startdate = $(this).val();
//       $("#EventEndDateTime").datetimepicker({
//            format: $(this).attr("data-hidetimepicker") == "True" ? 'd/m/Y' : 'd/m/Y g:i A',
//            startDate:startdate, 
//            minDate: startdate
//     });
//     
//     console.log(startdate); 
//     console.log(new Date());
// });

function LoaderStart() {
    $('#pageloader-overlay').css('display', 'block');
}
function LoaderStop() {
    $('#pageloader-overlay').css('display', 'none');
}

function showInputLoader(element) {
    var parent = $(element).parent();
    $(parent).find('.loader-icon').removeClass('d-none');
}

function hideInputLoader(element) {
    var parent = $(element).parent();
    $(parent).find('.loader-icon').addClass('d-none');
}

// function IsOnlineEvent(element) {
//     if ($(element).is(":checked")) {
//         $('#Address1').attr('disabled', true);
//         $('#Address2').attr('disabled', true);
//         $('#PostalCode').attr('disabled', true);
//         $('#city').attr('disabled', true);
//         $('#country').attr('disabled', true);
//         $('#state').attr('disabled', true);
//         $('#EventUrl').removeClass('d-none');
//     } else {
//         $('#EventUrl').addClass('d-none');
//         if ($("#city option[value='-1']").length != 0) {
//             $('#Address1').attr('disabled', false);
//             $('#Address2').attr('disabled', false);
//             $('#PostalCode').attr('disabled', false);
//             $('#city').attr('disabled', false);
//         }
//         if ($("#state option[value='-1']").length != 0) {
//             $('#state').attr('disabled', false);
//         }
//         $('#country').attr('disabled', false);
//     }
// }

// function deleteEvent(element) {
//     var confirmDelete = confirm("Are you sure you want to delete this event?");
//     if (!confirmDelete)
//         return;
//     var parent = findParent(element);
//     var eventDeleteId = $(element).attr('db-delete-id');
//     var CSRF_TOKEN = $('.csrf-token').val();
//     var urlString = $('.deleteEvent').val();
//     $.ajax({
//         url: urlString,
//         type: 'post',
//         data: {_token: CSRF_TOKEN, eventDeleteId: eventDeleteId},
//         success: function (response) {
//             // console.log(response);
//             location.reload();
//         }
//     });
// }

// function deleteContact(element) {
//     var confirmDelete = confirm("Are you sure you want to delete this contact?");
//     if (!confirmDelete)
//         return;
//     var parent = findParent(element);
//     var contactDeleteId = $(element).attr('db-delete-id');
//     var CSRF_TOKEN = $('.csrf-token').val();
//     var urlString = $('.deleteContact').val();
//     $.ajax({
//         url: urlString,
//         type: 'post',
//         data: {_token: CSRF_TOKEN, contactDeleteId: contactDeleteId},
//         success: function (response) {
//             // console.log(response);
//             location.reload();
//         }
//     });
// }

// function UploadVideoBox(element) {
//     var field = $(element).parent().parent().parent();
//     if (!$(element).is(':checked')) {
//         $(field).find('#input_url').attr('readonly', false);
//         $(field).find("#input_url").prop('required', true);
//         if ($(element).hasClass('PodCastUpload')) {
//             $(field).find("#podcast_video_file").prop('required', false);
//             $(field).find('.uploadPodcastVideo').addClass('d-none');
//         } else {
//             $(field).find("#input_vidfile").prop('required', false);
//             $(field).find('.uploadVideoBox').addClass('d-none');
//         }

//     } else {
//         $(field).find('#input_url').attr('readonly', true);
//         $(field).find("#input_url").prop('required', false);
//         if ($(element).hasClass('PodCastUpload')) {
//             $(field).find("#podcast_video_file").prop('required', true);
//             $(field).find('.uploadPodcastVideo').removeClass('d-none');
//         } else {
//             $(field).find("#input_vidfile").prop('required', true);
//             $(field).find('.uploadVideoBox').removeClass('d-none');
//         }

//     }
// }
// function UploadVideoBoxVideoCon() {
//     if (!$('#IsUploadVideo').is(':checked')) {
//         $('#input_url').attr('readonly', false);
//         $("#input_url").prop('required', true);
//         $("#input_vidfile").prop('required', false);
//         $('.uploadVideoBox').addClass('d-none');
//     } else {
//         $('.uploadVideoBox').removeClass('d-none');
//         $('#input_url').attr('readonly', true);
//         $("#input_url").prop('required', false);
//         $("#input_vidfile").prop('required', true);
//     }
// }
// function deleteVideo(element) {
//     var confirmDelete = confirm("Are you sure you want to delete this video?");
//     if (!confirmDelete)
//         return;
//     var parent = findParent(element);
//     var videoDeleteId = $(element).attr('db-delete-id');
//     var CSRF_TOKEN = $('.csrf-token').val();
//     var urlString = $('.deleteVideo').val();
//     $.ajax({
//         url: urlString,
//         type: 'post',
//         data: {_token: CSRF_TOKEN, videoDeleteId: videoDeleteId},
//         success: function (response) {
//             // console.log(response);
//             location.reload();
//         }
//     });
// }

// function deletePodcast(element) {
//     var confirmDelete = confirm("Are you sure you want to delete this podcast video?");
//     if (!confirmDelete)
//         return;
//     var parent = findParent(element);
//     var podcastVideoDeleteId = $(element).attr('db-delete-id');
//     var CSRF_TOKEN = $('.csrf-token').val();
//     var urlString = $('.deletePodcast').val();
//     $.ajax({
//         url: urlString,
//         type: 'post',
//         data: {_token: CSRF_TOKEN, podcastVideoDeleteId: podcastVideoDeleteId},
//         success: function (response) {
//             // console.log(response);
//             location.reload();
//         }
//     });
// }
// function UploadPodcastVideoBox() {
//     if (!$('#IsUploadPodcast').is(':checked')) {
//         $('#input_url').attr('readonly', false);
//         $("#input_url").prop('required', true);
//         $("#input_podfile").prop('required', false);
//         $('.uploadPodcastBox').addClass('d-none');
//     } else {
//         $('.uploadPodcastBox').removeClass('d-none');
//         $('#input_url').attr('readonly', true);
//         $("#input_url").prop('required', false);
//         $("#input_podfile").prop('required', true);
//     }
// }
// function showHideLinkEvent() {
//     if ($('#IsLinkedEvent').is(':checked')) {
//         $('.EventSelectionBox').removeClass('d-none');
//         $('.linkedEvent').val('1');
//     } else {
//         $('.EventSelectionBox').addClass('d-none');
//         $('.linkedEvent').val('0');
//     }

// }
// function uploadVideo(element) {
//     if ($(element).attr('id') == 'videoButton') {
//         $('.UploadVideoContainer').removeClass('d-none');
//         //   $('.videoTitle').removeClass('d-none');
//         //   $('.videoUrl').removeClass('d-none');
//         //   $('.videoUploadBox').removeClass('d-none'); 
//         //   $('#input_url').attr('readonly', false); 
//         //   $('#IsUploadVideo').prop('checked',false);

//         $('.UploadPodCastContainer').addClass('d-none');
//     } else if ($(element).attr('id') == 'podcastVideoButton') {
//         $('.UploadPodCastContainer').removeClass('d-none');
//         // $('.videoUrl').addClass('d-none');
//         // $('.videoUploadBox').addClass('d-none');
//         // $('.uploadVideoBox').addClass('d-none');
//         // $('.uploadPodcastVideo').removeClass('d-none');
//         // $('.uploadVideo').addClass('d-none');
//         $('.UploadVideoContainer').addClass('d-none');
//     }
//     // $('.uploadVideo').removeClass('d-none');
// }
// function UpdateEventStatus(element) {
//     var URL = $('.PostUrl').val();
//     $id = $(element).attr('data-id');
//     $status = $(element).attr('status');
//     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

//     $.ajax({
//         url: URL,
//         type: "post",
//         data: {_token: CSRF_TOKEN, 'id': $id, 'status': $status},
//         success: function (response) {
//             // console.log(response);
//             if ($status == '1') {
//                 $(element).attr('status', '2');
//                 $(element).text('Resume');
//             }
//             if ($status == '2') {
//                 $(element).attr('status', '1');
//                 $(element).text('Pause');
//             }
//             if ($status == '3') {
//                 $(".pauseButton").addClass('d-none');
//                 $(".cancelButton").addClass('d-none');
//             }
//         },
//         error: function (response) {
//             console.log(response);
//         }
//     });
// }

// function getState(element) {
//     var parent = findParent(element);
//     //var CSRF_TOKEN = $('.csrf-token').val();
//     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
//     var urlString = $('.getState').val();
//     var countryId = $(element).val();
//     showInputLoader(element);
//     $.ajax({
//         url: urlString,
//         type: 'post',
//         data: {_token: CSRF_TOKEN, countryId: countryId},
//         success: function (response) {
//             hideInputLoader(element);
//             $('#state').attr('disabled', false);
//             $('#state').empty();
//             $('#state').append(response);
//             // console.log(response);
//         }
//     });
// }
// function getCity(element) {
//     var parent = findParent(element);
//     //var CSRF_TOKEN = $('.csrf-token').val();
//     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
//     var urlString = $('.getCity').val();
//     var cityId = $(element).val();
//     showInputLoader(element);
//     $.ajax({
//         url: urlString,
//         type: 'post',
//         data: {_token: CSRF_TOKEN, cityId: cityId},
//         success: function (response) {
//             hideInputLoader(element);
//             $('#city').attr('disabled', false);
//             $('#city').empty();
//             $('#city').append(response);
//         }
//     });
// }
// function ShowAddressFields(element) {
//     $('#Address1').attr('disabled', false);
//     $('#Address2').attr('disabled', false);
//     $('#PostalCode').attr('disabled', false);
// }

// function RemoveSingleVideo(element) {
//     LoaderStart();
//     var id = $(element).attr('data-id');
//     var type = $(element).attr('Type');
//     var Field = findParent(element);
//     var urlString = $('.RemoveEventVideos').val();
//     urlString += "/" + id + "/" + type;
//     var CSRF_TOKEN = $('.csrf-token').val();
//     var countryId = $(element).val();

//     $.ajax({
//         url: urlString,
//         type: 'post',
//         data: {_token: CSRF_TOKEN, id: id},
//         success: function (response) {
//             $(Field).remove();
//             LoaderStop();
//             // console.log(response);
//         },
//         error: function (error) {
//             alert('An Error Occured');
//             LoaderStop();
//             // console.log(error);
//         }
//     });

// }
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

