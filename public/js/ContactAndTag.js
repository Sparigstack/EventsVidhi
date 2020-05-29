$(document).ready(function () {
// $('#tagsForm').on('submit', function (event) {
$('#tagsForm').keydown(function (event) {
    if (event.keyCode == 13) {
        LoaderStart();
        event.preventDefault();
        var CurentForm = $(this);
        var urlString = $('.addTags').val();
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
                // console.log(response);
                if (response.error != '') {
                    $('.tagInvalid').append(response.error.tagName);
                    alert(response.error.tagName);
                    LoaderStop();
                } else {
                    $("#tagName").val('');
                    // $("#allTags").append(response.tagName);
                    $("#allTags").append('<option value="' + response.id + '" selected="selected">' + response.tagName + '</option>');
                    LoaderStop();
                }
            },
            error: function (err) {
                console.log(err);
                // LoaderStop();
            }
        });
    }
});
});