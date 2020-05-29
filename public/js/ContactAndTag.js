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

function DeleteCustomField(element) {
    var confirmDelete = confirm("Are you sure want to delete this custom field permanently?");
    if (!confirmDelete) {
        return false;
    }
    LoaderStart();
    var parent = findParent(element);
    var CSRF_TOKEN = $('.csrf-token').val();
    var DataID = $(element).attr('db-delete-id');
    var urlString = $('.deleteCustomField').val();
    urlString += "/" + DataID;
    showInputLoader(element);
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, id: DataID },
        success: function (response) {
            $(parent).remove();
            LoaderStop();
            // console.log(response);
        }
    });
}