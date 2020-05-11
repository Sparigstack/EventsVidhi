function IsOnlineEvent(element){
    if($(element).is(":checked")){
        $('#Address').attr('readonly',true);
        $('#city').attr('disabled',true);
    }else{
        $('#Address').removeAttr ('readonly',false);
        $('#city').attr('disabled',false);
    }
}
// function imagePreview(element){
// 	var imagePreview = $(element).parent();
// 	$(imagePreview).find(".imagePreview").src =  window.URL.createObjectURL(element.files[0]);
// 	// document.getElementById(previewBoxId).src = window.URL.createObjectURL(this.files[0]);
// }