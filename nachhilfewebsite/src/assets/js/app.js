
class AjaxFormHelper {

    constructor(element, invalidError, ajaxPath) {

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
                console.log("TESTTEST");
                $me.runAjax(ajaxPath, element);
            });

    }

    runAjax(ajaxPath, element) {

        $.ajax({url: ajaxPath, dataType : 'json', data : element.serialize(), type : "POST", success: function(result){
            var $resultObj = result;
            if($resultObj.success == false) {
                toastr.error($resultObj.errorReason);
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


var loginFormHelper = new AjaxFormHelper($("#login-form"), "Login fehlgeschlagen!", "ajax/loginForm.php");

/*
$("#login-form")
    .on("forminvalid.zf.abide", function(ev) {
        toastr.error('Login fehlgeschlagen!');
    })
    .on("formvalid.zf.abide", function(ev) {
        console.log("TESTTEST");
        var formHelper = new AjaxFormHelper(ev);
        formHelper.runAjax("ajax/loginForm.php")
        //ev.preventDefault();
        //$.ajax("ajax/loginForm.php");
    });
*/

