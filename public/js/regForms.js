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

	var MultiSelectCounter = 0;

	$("#answerVal").keyup(function (e) {
		var answerValue = $("#answerVal").val();
		if (e.keyCode === 13) {
        	if (MultiSelectCounter == 0 && $('#hiddenAnswerValues').text() == "") {
            	$('#hiddenAnswerValues').append(answerValue);
        	} else {
            	$('#hiddenAnswerValues').append("," + answerValue);
        	}
        	MultiSelectCounter += 1;
        	$("#answerVal").val("");
        	$("#multipleAnsVal").append('<option selected="selected">' + answerValue + '</option>');
    	}
	});
});

function checkSelectionValue(element){
    var selectedOption = $('#regFormsSelect option:selected').val();
    if(selectedOption != '1'){
        $(".answerDiv").removeClass("d-none");
    } else {
        $(".answerDiv").addClass("d-none");
    }
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