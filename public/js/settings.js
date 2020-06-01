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