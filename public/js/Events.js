// $(document).ready(function () {
//     setEventDateAndTime();

//     $('#SaveVideoAjax').on('submit', function (event) {
//         LoaderStart();
//         event.preventDefault();
//         var CurentForm=$(this);
//         var urlString = $('.addEventVideos').val();
//         var formData = new FormData(this);
//         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
//         $.ajax({
//             url: urlString,
//             method: "POST",
//             data: new FormData(this),
//             dataType: 'JSON',
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function (response) {
//                 //var HtmlContent="<div>"+response.videoUrl+"</div> <div>"+response.videoTitle+"</div>";
//                 var HtmlContent='<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">'+response.videoTitle+'</h6><small class="small-font">'+response.videoUrl+'</small></div><div data-id="'+response.videoID+'" Type="video" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
//                 $('#UploadedVideos').append(HtmlContent);
//                 $(CurentForm).find('#input_url').val('');
//                 $(CurentForm).find('#input_title').val('');
//                 $('.UploadVideoContainer').addClass('d-none');
//                 LoaderStop();
//             },
//             error: function (err) {
//                 console.log(err);
//                 LoaderStop();
//             }
//         });
//     });

//     $('#SavePodCastAjax').on('submit', function (event) {
//         LoaderStart();
//         event.preventDefault();
//         var CurentForm=$(this);
//         var urlString = $('.addPodCastVideos').val();
//         var formData = new FormData(this);
//         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
//         $.ajax({
//             url: urlString,
//             method: "POST",
//             data: new FormData(this),
//             dataType: 'JSON',
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function (response) {
//                 //var HtmlContent="<div>"+response.videoUrl+"</div> <div>"+response.videoTitle+"</div>";
//                 var HtmlContent='<ul class="list-group parent list-group-flush mb-2"><li class="list-group-item"><div class="media align-items-center"><div class="media-body ml-3"><h6 class="mb-0">'+response.videoTitle+'</h6><small class="small-font">'+response.videoUrl+'</small></div><div data-id="'+response.videoID+'" Type="podcast" onclick="RemoveSingleVideo(this);" class=""><i class="fa icon fa-trash-o clickable" style="font-size: 22px;cursor: pointer;"></i></div></div></li>';
//                 $('#UploadedVideos').append(HtmlContent);
//                 $(CurentForm).find('#input_url').val('');
//                 $(CurentForm).find('#input_title').val('');
//                 $('.UploadPodCastContainer').addClass('d-none');
//                 LoaderStop();
//             },
//             error: function (err) {
//                 console.log(err);
//                 LoaderStop();
//             }
//         });
//     });

//     $('#EventDateTime').change(function (time) {
//         var dateRi = $(this).val();
//         var defaultdate;
//         var defaulttime;
//         var hours;
//         var minutes;
//         var ampm;
//         defaultdate = new Date($(this).val());
//         defaultdate.setHours(defaultdate.getHours() + 1);
//         hours = defaultdate.getHours() > 12 ? (defaultdate.getHours() - 12).toString() : defaultdate.getHours().toString();
//         hours = hours.length == 1 ? "0" + hours : hours;
//         minutes = defaultdate.getMinutes().toString();
//         minutes = minutes.length == 1 ? "0" + minutes : minutes;
//         ampm = defaultdate.getHours() > 11 ? "PM" : "AM";
//         defaulttime = hours + ":" + minutes + " " + ampm;
//         $("#EventEndDateTime").val(defaultdate.getMonth() + 1 + "/" + defaultdate.getDate() + "/" + defaultdate.getFullYear() + " " + defaulttime);
//     });
//     $(".files").on("change", function (e) {
//         var files = e.target.files,
//             filesLength = files.length;

//         for (var i = 0; i < filesLength; i++) {
//             var f = files[i]
//             var sizeKB = f.size / 1024;
//             var sizeMB = sizeKB / 1024;
//             console.log(f.naturalWidth);
//             if (sizeMB > 4) {
//                 $(this).parent().parent().find('.SizeError').removeClass('d-none');
//                 $(this).parent().parent().find('.SizeError').addClass('Invalid');
//                 $('#Submit').attr('disabled', true);
//                 return false;
//             }
//             if ($(this).parent().parent().find('.SizeError').hasClass('Invalid')) {
//                 $(this).parent().parent().find('.SizeError').addClass('d-none');
//                 $('#Submit').attr('disabled', false);
//             }
//         }
//     });

//     $('#EventBannerImage').change(function() {
//         $('#TempText').remove();
//         document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);
//         document.getElementById('bannerImage').classList.remove('d-none');
//     });

//     $('#EventThumbnailImage').change(function() {
//         $('#TempTextThumb').remove();
//         document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);
//         document.getElementById('thumbnailImage').classList.remove('d-none');
//     });

//     $('#video_file').change(function() {
//         $(this).parent().find('p').text(this.files.length + " file(s) selected");
//     });
//     $('#podcast_video_file').change(function() {
//         $(this).parent().find('p').text(this.files.length + " file(s) selected");
//     });

// });