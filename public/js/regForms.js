$(document).ready(function () {

	$(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

	var formRegisterTable = $('#default-datatable-formRegister').DataTable({
        ordering: false,
        aoColumnDefs: [
        {
            bSortable: false,
            aTargets: [2]
        }
        ],
    });

	//var MultiSelectCounter = 0;

//     $(".NewQueForm").each(function(element) {
//         //console.log(element);
//         var answerVal = $(this).find(".answerVal");
//     $(answerVal).keydown(function (e) {
//         var MultiSelectCounter = 0;
//         var answerValue = $(this).val();
//         //var element = $(this);
//         var hiddenAnswerValues = $(this).parent().find(".hiddenAnswerValues");
//         if (e.keyCode === 13) {
//             if (MultiSelectCounter == 0 && $(hiddenAnswerValues).text() == "") {
//                 $(hiddenAnswerValues).append(answerValue);
//             } else {
//                 $(hiddenAnswerValues).append("," + answerValue);
//             }
//             MultiSelectCounter += 1;
//             $(this).val("");
//             $(this).parent().find(".multipleAnsVal").append('<option selected="selected">' + answerValue + '</option>');
//         }
//     });
// });

	// $("#answerVal").keyup(function (e) {
	// 	var answerValue = $("#answerVal").val();
	// 	if (e.keyCode === 13) {
 //        	if (MultiSelectCounter == 0 && $('#hiddenAnswerValues').text() == "") {
 //            	$('#hiddenAnswerValues').append(answerValue);
 //        	} else {
 //            	$('#hiddenAnswerValues').append("," + answerValue);
 //        	}
 //        	MultiSelectCounter += 1;
 //        	$("#answerVal").val("");
 //        	$("#multipleAnsVal").append('<option selected="selected">' + answerValue + '</option>');
 //    	}
	// });
});

function checkSelectionValue(element){
    // var selectedOption = $('#regFormsSelect option:selected').val();
    // if(selectedOption != '1'){
    //     $(".answerDiv").removeClass("d-none");
    // } else {
    //     $(".answerDiv").addClass("d-none");
    // }

    var selectedOption = $(element).parent().find(".regFormsSelect option:selected").val();
    if(selectedOption != '1'){
        $(element).parent().find(".answerDiv").removeClass("d-none");
    } else {
        $(element).parent().find(".answerDiv").addClass("d-none");
    }
}

function setMultipleAnswerValues(element, event){
    var answerVal = $(element).parent().find(".answerVal");
    var MultiSelectCounter = 0;
    if (event.keyCode === 13) {
        var answerValue = $(element).parent().find(".answerVal").val();
        if(answerValue == ""){
            alert("Please Enter Answer Values");
            $(answerValue).focus();
            return;
        }
        var hiddenAnswerValues = $(element).parent().find(".hiddenAnswerValues");
        if (MultiSelectCounter == 0 && $(hiddenAnswerValues).text() == "") {
            $(hiddenAnswerValues).append(answerValue);
        } else {
            $(hiddenAnswerValues).append("," + answerValue);
        }
        MultiSelectCounter += 1;
        $(element).parent().find(".answerVal").val("");
        $(element).parent().find(".multipleAnsVal").append('<option selected="selected" data-id="'+ answerValue +'">' + answerValue + '</option>');
    }
   
    // $(".answerVal").keyup(function (element, e) {
    //     var MultiSelectCounter = 0;
    //     var answerValue = $(element).val();
    //     var element = $(this);
    //     var hiddenAnswerValues = $(element).parent().find(".hiddenAnswerValues");
    //     if (e.keyCode === 13) {
    //         if (MultiSelectCounter == 0 && $(hiddenAnswerValues).text() == "") {
    //             $(hiddenAnswerValues).append(answerValue);
    //         } else {
    //             $(hiddenAnswerValues).append("," + answerValue);
    //         }
    //         MultiSelectCounter += 1;
    //         $(answerValue).val("");
    //         $(element).parent().find(".multipleAnsVal").append('<option selected="selected">' + answerValue + '</option>');
    //     }
    // });
}

function deleteRegForm(element){
	var confirmDelete = confirm("Are you sure you want to delete this registration form?");
    if (!confirmDelete)
        return;
    var parent = findParent(element);
    var regFormDeleteId = $(element).attr('db-delete-id');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.deleteRegForm').val();
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, regFormDeleteId: regFormDeleteId },
        success: function (response) {
        	//console.log(response);
            location.reload();
        }
    });
}

function saveMultipleQuestions(element) {
    event.preventDefault();
    var RegTitle = $(".RegTitle").val();

    if(RegTitle == ""){
        alert("Please fill all fields");
        return;
    }
    var questions = new Array();
    var question;

    var NewQueForm = $(element).parent().parent().find(".NewQueForm");
    var isAlert = false;

    $(NewQueForm).each(function () {
        if($(this).find(".question").val() == "" || ($(this).find(".regFormsSelect").val() != "1" && $(this).find(".hiddenAnswerValues").text() == "")){
            isAlert = true;
        }

    });

    if(isAlert == true){
        alert("Please fill all fields");
        return;
    }
    
    $(NewQueForm).each(function () {
        question = new Object();
        question.question_value = $(this).find(".question").val();

        var requireChecked = $(this).find(".IsRequired").prop("checked");
        if (requireChecked == true) {
            question.IsRequired = true;
        } else {
            question.IsRequired = false;
        }

        var regFormsSelect = $(this).find(".regFormsSelect").val();
        question.answer_type = $(this).find(".regFormsSelect").val();
        var hiddenAnswerValues = $(this).find(".hiddenAnswerValues").text();
        if(regFormsSelect != 1){
            var removeLastCommas = hiddenAnswerValues.replace(/^,|,$/g,'');
            var strSplit = removeLastCommas.replace(/,+/g,',');
            var strSplit1 = strSplit.split(",").join("@~@");
            question.answerValues = strSplit1;
        } else {
            question.answerValues = "";   
        }

        questions.push(question);
        //console.log(questions);
    });
    
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var regFormId = $(".regFormId").val();
    var href = window.location.href;
    var url = "";

    if(href.includes("new") == true){
        url = 'store';
    } else {
        url = 'edit/'+ regFormId;
    }

    $.ajax({
        url: url,
        type: 'post',
        //async: true,
        data: {_token: CSRF_TOKEN, question_inputs: questions, RegTitle:RegTitle},
        success: function (data) {
            //console.log(data);
            window.location.href = "../../org/regForms";
        },
         error: function (data) {
            //console.log(data);
         }
    });
}

function removeAnswerValues(element){
    //alert("in function");
    $(element).on('select2:unselecting', function(e) {
        //alert("in unselecting");
        var str = $(this).parent().find('.hiddenAnswerValues').text();
        var search = e.params.args.data.id;

        var res = str.replace(e.params.args.data.id, "");
        $(this).parent().find('.hiddenAnswerValues').text("");
        $(this).parent().find('.hiddenAnswerValues').append(res);
    });
}

function deleteThisQue(element){
    var confirmDelete = confirm("Are you sure you want to delete this question?");
    if (!confirmDelete)
        return;
    var parent = findParent(element);
    var queFormDeleteId = $(element).attr('db-delete-id');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var urlString = $('.deleteQue').val();
    $.ajax({
        url: urlString,
        type: 'post',
        data: { _token: CSRF_TOKEN, queFormDeleteId: queFormDeleteId },
        success: function (response) {
            //console.log(response);
            location.reload();
        }
    });
}