//Class that takes an element (form), and sends an ajax request if the form is valid (if it's not valid display invalidError). When the ajax
//responds with an error message, also display it. When the ajax succeeds call success with the send data as a parameter.
//If anything else than the form should get attached to the formData object, add something to the formDataAppend method. (files for ex.)
class AjaxFormHelper {

    constructor(element, invalidError, ajaxPath, success, formDataAppend = 0) {

        var $me = this;
        element
            .on("submit", function (ev) {
                ev.preventDefault();
                return false;
            })
            .on("forminvalid.zf.abide", function (ev) {
                toastr.error(invalidError);
            })
            .on("formvalid.zf.abide", function (ev) {
                ev.preventDefault();
                $me.runAjax(ajaxPath, element, success, formDataAppend);

            });
        if (ajaxPath == "ajax/searchForm.php") {
            $(document).on("ready", function (ev) {
                ev.preventDefault();
                var url = window.location.href;
                if (url.includes("?")) {
                    $me.runAjax(ajaxPath, element, success, formDataAppend);
                }
            });
        }
    }

    //sends the actual ajax request
    runAjax(ajaxPath, element, success, formDataAppend) {

        var formData = new FormData(element[0]);

        //Call the formDataAppend method to add custom data to the formData object initialized with the form element
        if (formDataAppend != 0) {
            formDataAppend(formData);
        }

        //Send the ajax request
        $.ajax({
            url: getRootUrl() + ajaxPath,
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            type: "POST",
            success: function (result) {
                var resultObj = result; //JSON object
                if (resultObj.success == false) {
                    toastr.error(resultObj.errorReason);
                }
                else {
                    success(resultObj);
                }
            }
        });
    }
}

class AjaxFormHelperNachhilfeAnfrage {

    constructor(element, invalidError, ajaxPath, success, formDataAppend = 0) {
        var $me = this;
        element.on("click", function (ev) {
            ev.preventDefault();
            $me.runAjaxNachhilfe(ajaxPath, element, success, formDataAppend);
        }).on("forminvalid.zf.abide", function (ev) {
            toastr.error(invalidError);
        })
    }

    runAjaxNachhilfe(ajaxPath, element, success, data) {
        var faecher = $('[name=fachButton]');
        var selectedFaecher = [];
        for(var i = 0; i < faecher.length; i++) {
            if (faecher[i].value == "true") {
                selectedFaecher.push(faecher[i].attributes[1].nodeValue);
            }
        }
        data = {'user': $("#user_to_show").val(), 'faecher': selectedFaecher};
        console.log(data);
        $.ajax({
            url: getRootUrl() + ajaxPath,
            data: data,
            type: "POST",
            dataType: 'json',
            success: function (result) {
                var resultObj = result;
                if (resultObj.success == false) {
                    toastr.error(resultObj.errorReason);
                }
                else {
                    success(resultObj);
                }
            }
        })
    }
}
class AjaxFormHelperNachhilfeFach {

    constructor() {
        var $me = this;
        $('[name=fachButton]').on("click", function (ev){
            ev.preventDefault();
            $me.runNOW(ev.target);
        })
    }

    runNOW(element) {
        if (element.className.includes("success")) {
            element.className = "labelled warning center";
            element.value = "true";
        }
        else {
            element.className = "labelled success center";
            element.value = "false";
        }
    }
}

toastr
    .options = {
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

var loginFormHelper = new AjaxFormHelper($("#login-form"), "Login fehlgeschlagen!", "ajax/loginForm.php", function (result) {
        location.reload();
    });

var userEditFormHelper = new AjaxFormHelper($("#user-edit-form"), "Änderung fehlgeschlagen!", "ajax/userEditForm.php", function (result) {
        toastr.success("Änderungen übernommen!");
    });

var searchFormHelper = new AjaxFormHelper($("#search-form"), "Suche fehlgeschlagen!", "ajax/searchForm.php", function (result) {
        toastr.success("Suche erfolgreich!");
        $('.result-boxes-inner').empty();

        if (result.users.length == 0) {
            $('.result-boxes-inner').append(
                "<div class='result-box'><div class='row no-padding left'><div class='small-8-centered columns'><div class='row no-padding right'><div class='small-12-centered columns notification-header no-padding align-center text-center'><p>Kein Nutzer gefunden!</p></div><div class='small-12 columns no-padding right'>  </div></div></div> <div class='small-4 columns no-padding both'> <div class='button-group medium '> </div> </div> </div> </div>"
            );
        }
        else {
            var root = getRootUrl();
            result.users.forEach(function (entry) {
                $('.result-boxes-inner').append(
                    //"<a target='_blank' href='" + root + "user/" + entry.idBenutzer.toString() + "/view" + "' class='button expanded round secondary'>" + entry.vorname + " " + entry.name + "</a><br>"
                    "<div class='result-box'>" +
                    "<div class='row align-center text-center'>" +
                    "<div class='small-12-centered columns'>" +
                    "<div class='row'>" +
                    "<div class='small-12-centered columns notification-header no-padding align-center text-center'>" +
                    "<a class='button radius success' href='" + root + "user/" + entry.idBenutzer.toString() + "/view" + "'>" + entry.vorname + " " + entry.name + "</a>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                    //"<div class='result-box'><div class='row no-padding left'><div class='small-12 columns'><div class='row no-padding right'><div class='small-8 columns no-padding both align-center text-center' style='vertical-align:middle;'><a style='vertical-align:middle;' href='" + root + "user/" + entry.idBenutzer.toString() + "/view" + "' target='_blank'>" + entry.vorname + " " + entry.name + "</a></div><div class='small-4 columns no-padding right'>  </div><div class='small-4 columns text-center align-center'> <div class='button-group-centered small-centered'><a href='" + root + "user/" + entry.idBenutzer.toString() + "/view" + "' target='_blank' class='button radius success' type='submit' value='Submit'>Profil</a></div></div></div> </div> </div> </div>"
                )
            });
        }
        var stateObj = {"url": "suche"};
        history.pushState(stateObj, "Nachhilfeseite", result.newUrl);
    });

var nachhilfeAnfrageAbuse = new AjaxFormHelperNachhilfeAnfrage($("#nachhilfeAnfragenButton"), "Anfrage fehlgeschlagen!", "ajax/MakeNachhilfeanfrageGreatAgain.php", function (result) {
        toastr.success("Anfrage erfolgreich!");
    });

var nachhilfeAnfrageFach = new AjaxFormHelperNachhilfeFach();

var userEditPasswordField = $('#user-edit-form input[name="passwort"]');

var userEditPasswordFieldSecondary = $('#user-edit-form input[name="passwort-wiederholung"]');

var userEditPasswordFieldSecondaryContainer = $('#user-edit-form label#passwort-wiederholung');

userEditPasswordField.on(
        'input'
        ,
        function () {
            if (userEditPasswordField.val() == "") {
                userEditPasswordFieldSecondaryContainer.slideUp();
                userEditPasswordFieldSecondary.val('');
            }
            else {
                userEditPasswordFieldSecondaryContainer.slideDown();
            }
        }
    );

function getRootUrl() {
    return $("script[src]").last().attr("src").split('?')[0].split('/').slice(0, -1).join('/') + '/../../';
}
