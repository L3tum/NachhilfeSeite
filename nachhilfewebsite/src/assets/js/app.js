
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

    runAjax(ajaxPath, element, success, formDataAppend) {

        var formData = new FormData(element[0]);

        if(formDataAppend != 0) {
                formDataAppend(formData);
        }


        $.ajax({url: ajaxPath, dataType : 'json', data : formData, processData: false, contentType: false, type : "POST", success: function(result){
            var resultObj = result;
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

