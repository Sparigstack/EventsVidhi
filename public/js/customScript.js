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

    $('#profileImg').change(function () {
        $('.textForProfile').remove();
        document.getElementById('profileImgSrc').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('profileImgSrc').classList.remove('d-none');
    });

    $('#profileBannerImage').change(function () {
        $('#textForProfileBanner').remove();
        document.getElementById('profileBannerImageSrc').src = window.URL.createObjectURL(this.files[0]);
        document.getElementById('profileBannerImageSrc').classList.remove('d-none');
    });
                
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
            // if(this.width< 845 && this.height < 445){
                if(this.width> 970 && this.height > 330){
                $("#bannerImage").addClass("SmallImages");
                $(".removebtn").removeClass("d-none");
                return true;
            }
            // else if(this.width === 845 && this.height === 445){
                else if(this.width === 970 && this.height === 330){
                $(".removebtn").removeClass("d-none");
                return true;
            }else{
                // alert("Maximum image dimension allowed is : 845x445 pixels.");
                alert("Maximum image dimension allowed is : 970x330 pixels.");
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

function updateIsFeatured(element){
    var parent = findParent(element);
    var eventId = $(element).attr('data-id');
    var isFeatureCheck = $(element).attr('data-event');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.updateIsFeatured').val();
    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, eventId: eventId, isFeatureCheck: isFeatureCheck},
        success: function (response) {
            //console.log(response);
            if(isFeatureCheck == "0"){
                $(element).attr('data-event', "1");
            } else {
                $(element).attr('data-event', "0");
            }
        },
        error: function (response) {
            //console.log(response);
        }
    });
}