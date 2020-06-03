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

});