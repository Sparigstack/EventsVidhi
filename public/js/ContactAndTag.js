$(document).ready(function () {
    var contactsTable = $('#default-datatable-contacts').DataTable({
        // columnDefs: [
        //     {orderable: false, targets: 4},
        // ],
        ordering: false,
        aoColumnDefs: [
            {
                bSortable: false,
                aTargets: [5]
            }
        ],
        buttons: [{extend: 'excel',
                text: 'export to excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }}, {
                extend: 'csv',
                text: 'export to csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }}, ],
    });
    // contactsTable.buttons().container().appendTo('#default-datatable-contacts_wrapper .col-md-6:eq(0)');
    contactsTable.buttons().container().appendTo('#default-datatable-contacts_wrapper .col-md-6:eq(1)');
    $("#default-datatable-contacts_wrapper").find($(".dt-buttons")).css("float", "right");
    $("#default-datatable-contacts_wrapper").find($(".dt-buttons")).find($(".buttons-csv")).css("border-radius", "0.25rem");

    $('.dt-buttons').each(function () {
            $(this).append('<div class="dropdown"><a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown"><button class="btn btn-outline-primary ml-2 pull-right">Bulk Actions</button></a><div class="dropdown-menu dropdown-menu-right bulkActionDropDown"><a class="dropdown-item backColorDropdownItem" href="javascript:void();" data-toggle="modal" data-target="#openEmailPopup">Email</a></div></div>');
        });

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
        data: {_token: CSRF_TOKEN, id: DataID},
        success: function (response) {
            $(parent).remove();
            LoaderStop();
            // console.log(response);
        }
    });
}
function Approve(element) {
    var confirmDelete = confirm("Approve this contact?");
    if (!confirmDelete) {
        return false;
    }
    LoaderStart();
    var parent = findParent(element);
    var CSRF_TOKEN = $('.csrf-token').val();
    var DataID = $(element).attr('data-id');
    var urlString = $('.ApproveContact').val();
    urlString += "/" + DataID;
    showInputLoader(element);
    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, id: DataID},
        success: function (response) {
            $(element).find('.fa-square-o').removeClass('fa-square-o').addClass('fa-check-square');
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

function deleteContact(element) {
    var confirmDelete = confirm("Are you sure you want to delete this contact?");
    if (!confirmDelete)
        return;
    var parent = findParent(element);
    var contactDeleteId = $(element).attr('db-delete-id');
    var CSRF_TOKEN = $('.csrf-token').val();
    var urlString = $('.deleteContact').val();
    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, contactDeleteId: contactDeleteId},
        success: function (response) {
            // console.log(response);
            location.reload();
        }
    });
}

function tagsSelect(element) {
    var urlString = $(".urlString").val();
    var tagsHiddenText = $("#HiddenCategoyID").text();
    var tagsHiddenTrim = $.trim(tagsHiddenText);
    var tagsHidden = tagsHiddenTrim.replace(' ', ',');
    window.location.href = urlString += '/' + tagsHidden;
}

function showNewCustomField(element) {
    var newCustomField0 = $("#newCustomField0");
    var newForm = $(newCustomField0).clone();
    var number = Math.floor(Math.random() * 999);
    $(newForm).attr('id', "newCustomField" + number);
    $(newForm).removeClass('d-none');
    $(element).parent().parent().prepend(newForm);


}

function saveCustomField(element) {
    var parent = findParent(element);
    var fieldName = $(parent).find('.fieldName').val();
    if (fieldName == "") {
        alert("Please provide Field Name.");
        return;
    }

    var fieldType = $(parent).find('.fieldType').val();
    if (fieldType == "" || fieldType == undefined || fieldType == null) {
        alert("Please choose type for your field.");
        return;
    }
    var urlString = $(parent).find('.addCustomField').val();
    var CSRF_TOKEN = $(parent).find('input[name=_token]').val();
    LoaderStart();
    $.ajax({
        url: urlString,
        type: 'post',
        data: {_token: CSRF_TOKEN, name: fieldName, DisplayType: fieldType},
        success: function (response) {
            $(parent).remove();
            var newFieldType = "";
            var dateClass = "";
            var placeHolder = "Enter " + fieldName;
            if (fieldType == 1) {
                newFieldType = "text";
            } else if (fieldType == 2)
                newFieldType = "number";
            else if (fieldType == 3){
                newFieldType = "datetime";
                dateClass = "date";
            }
                

            var fieldId = fieldName.replace(/ /g, "");

            var newFieldHtml = "<div class='form-group'><label for=''>" + fieldName + "</label><input type='" + newFieldType + "' placeholder='" + placeHolder + "' value='' class='form-control "+dateClass+"' autocomplete='off' name='"+fieldId+"' id='"+fieldId+"'></div>";
            $('.newContactForm').find(".customFieldsContainer").append(newFieldHtml);
            
            LoaderStop();
        }
    });
}

function removeCustomField(element){
    var parent = findParent(element);
    $(parent).remove();
}

function AddNewTag(element){
    alert("fire event");
}
