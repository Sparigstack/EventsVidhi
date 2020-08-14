$(document).ready(function () {

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

var _URL = window.URL || window.webkitURL;
$("#profileImg").change(function(e) {
            var file = $(this)[0].files[0];
           if ((file = this.files[0])){
        image = new Image();
          image.onload = function() {
            if(this.width< 420 && this.height < 360){
                // $("#profileImgSrc").addClass("SmallImages");
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

});

