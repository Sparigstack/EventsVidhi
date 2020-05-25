$(document).ready(function() {
    $('.dragFileForm input').change(function() {
        $('.dragFileForm p').text(this.files.length + " file(s) selected");
    });
    UploadPodcastVideoBox();
    showHideLinkEvent();
});
function UploadVideoBoxVideoCon() {
    if (!$('#IsUploadVideo').is(':checked')) {
        $('#input_url').attr('readonly', false);
        $("#input_url").prop('required', true);
        $("#input_vidfile").prop('required', false);
        $('.uploadVideoBox').addClass('d-none');
    } else {
        $('.uploadVideoBox').removeClass('d-none');
        $('#input_url').attr('readonly', true);
        $("#input_url").prop('required', false);
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
    } else {
        $('.uploadPodcastBox').removeClass('d-none');
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
