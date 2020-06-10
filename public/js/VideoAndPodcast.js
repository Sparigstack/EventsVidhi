$(document).ready(function () {
    var videosTable = $('#default-datatable-videos').DataTable({
        columnDefs: [
            {orderable: false, targets: 2},
        ]
    });

    var podcastsTable = $('#default-datatable-podcasts').DataTable({
        columnDefs: [
            {orderable: false, targets: 2},
        ]
    });

    $('.dragFileForm #input_vidfile').change(function () {
        // $('.dragFileForm p').text(this.files.length + " file(s) selected");
        $('.dragFileForm').find('.dragFileText').text(this.files.length + " file(s) selected");

        var parent = findParentForm(this);
        var vidFile = this.files;
        if (vidFile.length > 0) {
            $(parent).find("#btnSaveVideo").removeClass('d-none');
            $(parent).find("#btnCancelVideo").removeClass('d-none');
            $(parent).find("#btnSaveVideo").text('Upload & Save');            
        } else {
            $(parent).find("#btnSaveVideo").addClass('d-none');
            $(parent).find("#btnCancelVideo").addClass('d-none');
        }
    });
    UploadPodcastVideoBox();
    showHideLinkEvent();
});
function UploadVideoBoxVideoCon(element) {
    if (!$(element).is(':checked')) {
        $('#input_url').attr('readonly', false);
        $("#input_url").prop('required', true);
        $("#input_vidfile").prop('required', false);
        $("#input_vidfile").val('');
        $('#input_vidfile').trigger('onchange');
        $('.uploadVideoBox').addClass('d-none');
        //$('.progressBar').addClass('d-none');
        $('.uploadVideoBox').find(".dragFileText").text('Drag your video file here or click in this area.');
    } else {
        $('.uploadVideoBox').removeClass('d-none');
        //$('.progressBar').removeClass('d-none');
        $('#input_url').attr('readonly', true);
        $("#input_url").prop('required', false);
        $('#input_url').val('');
        $('#input_url').trigger('onchange');
        $("#input_vidfile").prop('required', true);
    }
}
function deleteVideo(element) {
    var confirmDelete = confirm("Are you sure you want to delete this video?");
    if (!confirmDelete)
        return;
    var parent = findParent(element);
    var videoDeleteId = $(element).attr('db-delete-id');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.deleteVideo').val();
    LoaderStart();
    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, videoDeleteId: videoDeleteId},
        success: function (response) {
            // console.log(response);
            location.reload();
        }
    });
}

function deletePodcast(element) {
    var confirmDelete = confirm("Are you sure you want to delete this podcast video?");
    if (!confirmDelete)
        return;
    var parent = findParent(element);
    var podcastVideoDeleteId = $(element).attr('db-delete-id');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.deletePodcast').val();
    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, podcastVideoDeleteId: podcastVideoDeleteId},
        success: function (response) {
            // console.log(response);
            location.reload();
        }
    });
}
function UploadPodcastVideoBox() {
    if (!$('#IsUploadPodcast').is(':checked')) {
        $('#input_url').attr('readonly', false);
        $("#input_url").prop('required', true);
        $("#input_podfile").prop('required', false);
        $('.uploadPodcastBox').addClass('d-none');
        $('.podcastProgressBar').addClass('d-none');
    } else {
        $('.uploadPodcastBox').removeClass('d-none');
        $('.podcastProgressBar').removeClass('d-none');
        $('#input_url').attr('readonly', true);
        $("#input_url").prop('required', false);
        $("#input_podfile").prop('required', true);
    }
}
// function showHideLinkEvent() {
//     if ($('#IsLinkedEvent').is(':checked')) {
//         $('.EventSelectionBox').removeClass('d-none');
//         $('.linkedEvent').val('1');
//     } else {
//         $('.EventSelectionBox').addClass('d-none');
//         $('.linkedEvent').val('0');
//     }

// }
function showHideLinkEvent() {
    if ($('#yesEventLinked').is(':checked')) {
        $('.EventSelectionBox').removeClass('d-none');
        $(".descriptionDiv").addClass('d-none');
        $('.linkedEvent').val('1');
    } else {
        $('.EventSelectionBox').addClass('d-none');
        $(".descriptionDiv").removeClass('d-none');
        $('.linkedEvent').val('0');
    }

}

function videoUrlCheck(element) {
    var parent = findParent(element);
    var vidUrl = $(element).val();
    if (vidUrl != null && vidUrl != "") {
        $(parent).find("#btnSaveVideo").removeClass('d-none');
        $(parent).find("#btnCancelVideo").removeClass('d-none');
    } else {
        $(parent).find("#btnSaveVideo").addClass('d-none');
        $(parent).find("#btnCancelVideo").addClass('d-none');
    }
}

//function videoFileCheck(element) {
//
//}