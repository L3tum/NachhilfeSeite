
//Class that takes an element (form), and sends an ajax request if the form is valid (if it's not valid display invalidError). When the ajax
//responds with an error message, also display it. When the ajax succeeds call success with the send data as a parameter.
//If anything else than the form should get attached to the formData object, add something to the formDataAppend method. (files for ex.)
class AjaxFormHelper {

    constructor(element, invalidError, ajaxPath, success, formDataAppend = 0) {

        var $me = this;
        element
            .on("submit", function(ev) {
                ev.preventDefault();
                return false;
            })
            .on("forminvalid.zf.abide", function(ev) {
                toastr.error(invalidError);
            })
            .on("formvalid.zf.abide", function(ev) {
                ev.preventDefault();
                $me.runAjax(ajaxPath, element, success, formDataAppend);

            });

    }

    //sends the actual ajax request
    runAjax(ajaxPath, element, success, formDataAppend) {

        var formData = new FormData(element[0]);

        //Call the formDataAppend method to add custom data to the formData object initialized with the form element
        if(formDataAppend != 0) {
                formDataAppend(formData);
        }

        //Send the ajax request
        $.ajax({url: getRootUrl() + ajaxPath, dataType : 'json', data : formData, processData: false, contentType: false, type : "POST", success: function(result){
            var resultObj = result; //JSON object
            if(resultObj.success == false) {
                toastr.error(resultObj.errorReason);
            }
            else {
                success(resultObj);
            }
        }});
    }
}

toastr.options = {
    "closeButton": true,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
$(document).foundation();


var loginFormHelper = new AjaxFormHelper($("#login-form"), "Login fehlgeschlagen!", "ajax/loginForm.php", function (result){
    location.reload();
});

var userEditFormHelper = new AjaxFormHelper($("#user-edit-form"), "Änderung fehlgeschlagen!", "ajax/userEditForm.php", function (result){
    toastr.success("Änderungen übernommen!");
});
var searchFormHelper = new AjaxFormHelper($("#search-form"), "Suche fehlgeschlagen!", "ajax/searchForm.php", function (result){
    searchFormHelper.runAjax("ajax/searchForm.php", {users: result}, success, searchFormHelper.append());
    console.log(getRootUrl() + "ajax/searchForm.php");
    console.log(result);
    toastr.success("Suche erfolgreich!");
});
var userChooseHelper = new AjaxFormHelper($("#user-choose-form"), "Benutzer nicht vorhanden!", "ajax/userChooseForm.php", function (result){
    toastr.success("Benutzer abgerufen!");
});

var userEditPasswordField = $('#user-edit-form input[name="passwort"]');
var userEditPasswordFieldSecondary = $('#user-edit-form input[name="passwort-wiederholung"]');
var userEditPasswordFieldSecondaryContainer = $('#user-edit-form label#passwort-wiederholung');

userEditPasswordField.on('input', function() {
    if(userEditPasswordField.val() == "") {
        userEditPasswordFieldSecondaryContainer.slideUp();
        userEditPasswordFieldSecondary.val('');
    }
    else {
        userEditPasswordFieldSecondaryContainer.slideDown();
    }
});

console.log(getRootUrl());
function getRootUrl() {
    return $("script[src]").last().attr("src").split('?')[0].split('/').slice(0, -1).join('/')+'/../../';
}
