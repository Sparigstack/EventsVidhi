$(function () {
    var availableStorage=$(".AvailableStorageValue").val();
    var totalVidCount=$(".totalVidCount").val();
    var totalPodCount=$(".totalPodCount").val();
    if(parseFloat(availableStorage) > 3.000 || parseInt(totalVidCount) > 3 || parseInt(totalPodCount) > 3){
        $(".notCancelPlan").removeClass("d-none");
        $(".CancelPlan").addClass("d-none");
    } else{
        $(".notCancelPlan").addClass("d-none");
        $(".CancelPlan").removeClass("d-none");
    }
});

function SaveUserSetting(element){
  
    LoaderStart();
    var updateType=$(element).attr('data_type');
    var key="";
    if(updateType=='username'){
        key="username";
        value=$(element).val();
    }else if(updateType=='AutoAproveFollower'){
        key="AutoAproveFollower";
        if ($(element).is(":checked")) {
            value=true;
        }else{
            value=false;
        }
    }
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.urlToCall').val();
    showInputLoader(element);
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, key:key,value:value  },
        success: function (response) {
           console.log(response);
           if(response=='uernameExist'){
               $('.usernameExist').text('User name already taken please try another user name!');
           }else{
            $('.usernameExist').text('');
           }
           LoaderStop();
            // console.log(response);
        },
        error: function (response) {
            console.log(response);
            LoaderStop();
             // console.log(response);
         }
    });
}

function CancelSubscription(element){
    var planName = $('.planName').val();
    var confirmCancel = confirm("Are you sure you want to cancel your " + planName + " and move to Basic Plan?");
    if (!confirmCancel)
        return;
    var userId = $(element).attr('data-id');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.cancelSubscription').val();
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, userId: userId },
        success: function (response) {
            //console.log(response);
            location.reload();
        }
    });
}