function addComment(element){
	event.preventDefault();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var loginuserID = $('.userIDFollow').val();

    var eventID = $('.eventID').val();
    var commentAnswerDiv = $(element).parent().parent().find(".commentAns").val();
    var saveUserComments = $('.saveUserComments').val();

    if(commentAnswerDiv == ''){
    	$(".commenterror").removeClass("d-none");
    	return;
    }
    $(".spinnerSubmit").removeClass("d-none");

    $.ajax({
        url: saveUserComments,
        method: "POST",
        data: {_token : CSRF_TOKEN, eventID:eventID, loginuserID:loginuserID, commentAnswerDiv:commentAnswerDiv},
        success: function (response) {
            //console.log(response);
            $(".spinnerSubmit").addClass("d-none");
            $(".commenterror").addClass("d-none");
            $('#openCommentPopup').modal('toggle');
            location.reload();
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function showHideComments(comment){
    var txt = $(comment).parent().parent().find(".contentDiv").is(':visible') ? 'Show More' : 'Show Less';
    var txtData = $(comment).parent().parent().find(".show_hide").text(txt);
    if(txt == 'Show Less'){
        $(comment).parent().parent().find('.fullContent').removeClass('d-none');
        $(comment).parent().parent().find('.shortContent').addClass('d-none');
    } else {
        $(comment).parent().parent().find('.fullContent').addClass('d-none');
        $(comment).parent().parent().find('.shortContent').removeClass('d-none');
    }
}

function moreCommentShowHide(){
    var comment = $(".morecmtbtn").val();
    if(comment == "More Comments"){
        $(".morecmtbtn").attr("value","Less Comments");
        $(".commentSection").removeClass("d-none");
        $(".show_hide").text("Show More");
        $('.fullContent').addClass('d-none');
        $('.shortContent').removeClass('d-none');
    } else {
        $(".morecmtbtn").attr("value","More Comments");
        $(".commentSection").addClass("d-none");
    }
}