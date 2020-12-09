function showHidecategoriesNav(classname){
    if($(classname).hasClass("eventsTab")){
        $('.eventListDiv').removeClass('d-none');
    } else{
    }
    $('.noEventMsg').addClass('d-none');

    var tabId = $(classname).attr('value');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var url = "0";

    url =  "../../../../allContent/" +
                tabId +
                "/" +
                0 +
                "/" +
                0 +
                "/page=1";
        //        alert(url);
        window.location.replace(url);
}

function showHidecategoriesNavItem(classname){
    if($(classname).hasClass("eventsTab")){
        $('.eventListDiv').removeClass('d-none');
    } else{
    }
    $('.noEventMsg').addClass('d-none');

    var tabId = $(classname).attr('value');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var url = "0";
    var homePageUrl = $(".homePageUrl").val();

    url = homePageUrl + "/" + tabId +
                "/" +
                0 +
                "/page=1";
        //        alert(url);
        window.location.replace(url);
}

function showHideEventListing(eventslist){
    var eventListID = $(eventslist).attr('data-id');
        $('.showHideListDiv').each(function() {
        var eventCategoryID = $(this).find('.eventCatID');
        var eventCategoryIDVal = $(this).find('.eventCatID').val();
        var split_str = eventCategoryIDVal.split(",");
        $(this).removeClass('d-none');
            if (split_str.indexOf(eventListID) !== -1)  {
                $(this).removeClass('d-none');
            } else {
                $(this).addClass('d-none');
            }
        }); 

    // var checkLength = $('.eventListDiv:visible').length;
    var checkLength = $('.showHideListDiv:visible').length;
    if(checkLength == 0){
        // $('.seeMoreEvent').addClass('d-none');
        $('.mobileSeeMoreBtn').addClass('d-none');
        $('.noEventMsg').removeClass('d-none');
    } else {
        // $('.seeMoreEvent').removeClass('d-none');
        $('.mobileSeeMoreBtn').addClass('d-none');
        $('.noEventMsg').addClass('d-none');   
    }
}

function followEvent(eventid){
    var eventId = $(eventid).attr("data-event-id");
    var discriminator = $(eventid).attr("discriminator");
    var saveEventFollower = $('.saveEventFollower').val();
    var userIDFollow = $('.userIDFollow').val();
    var loginRoute = $('.loginRoute').val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var likeButtonSpan = $(eventid).find('.likeButtonSpan');
    var fillHeartValue = $(eventid).find('.likeButtonSpan').find(".fillHeart").attr('value');

    $.ajax({
        url: saveEventFollower,
        method: "POST",
        data: {_token : CSRF_TOKEN,discriminator:discriminator,eventId:eventId,userIDFollow:userIDFollow,fillHeartValue:fillHeartValue},
        success: function (response) {
            console.log(response);
            // if(userIDFollow != '') {
                if(userIDFollow == '') {
                alert('You need to log in/sign up first to follow');
                window.location.href = loginRoute;
            } else {
                if(fillHeartValue == '1'){
                    $(likeButtonSpan).find(".emptyHeart").removeClass('d-none');
                    $(likeButtonSpan).find(".fillHeart").addClass('d-none');
                    $(likeButtonSpan).find(".fillHeart").attr('value', '');
                } else {
                    $(likeButtonSpan).find(".emptyHeart").addClass('d-none');
                    $(likeButtonSpan).find(".fillHeart").removeClass('d-none');
                    $(likeButtonSpan).find(".fillHeart").attr('value', '1');
                }
                // $(likeButtonSpan).find(".emptyHeart").addClass('d-none');
                // $(likeButtonSpan).find(".fillHeart").removeClass('d-none');
            }
        },
        error: function (err) {
            console.log(err);
        }

    });
}

function filterByCategories(categorylist){
    var categoryListID = $(categorylist).attr('data-id');
    var tabId = $('.mainTab').find('.active').attr('value');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var url = "0";

    url =  "../../../../allContent/" +
                tabId +
                "/" +
                categoryListID +
                "/" +
                0 +
                "/page=1";
        //        alert(url);
        window.location.replace(url);
}

function filterByCategoryList(categorylist){
    var categoryListID = $(categorylist).attr('data-id');
    var tabId = $('.mainTab').find('.active').attr('value');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var url = "0";
    var homePageUrl = $(".homePageUrl").val();

    url = homePageUrl + "/" + tabId +
                "/" +
                categoryListID +
                "/page=1";
        //        alert(url);
        window.location.replace(url);
}

function searchTitle(){
    var searchName = $(".serachEvent").val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    var url = "0";
    var homePageUrl = $(".homePageUrl").val();

    if(searchName == ""){
        url =  homePageUrl + "/allContent/" +
                1 +
                "/" +
                0 +
                "/" +
                0 +
                "/page=1";
    } else {
        url =  homePageUrl + "/allContent/" +
                1 +
                "/" +
                0 +
                "/" +
                searchName +
                "/page=1";
    }

    
        //        alert(url);
        window.location.replace(url);

}
