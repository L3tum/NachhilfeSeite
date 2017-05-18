/**
 * Created by Tom on 16.05.2017.
 */

var loginFormHelper = new AjaxFormHelper($("#login-form"), "Login fehlgeschlagen!", "ajax/Forms/loginForm.php", function (result) {
    location.reload();
}, function (formData) {
    formData.set("passwort", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
});

var TuitionEndFormHelper = new AjaxFormHelper($(".tuition-end-form"), "Beenden fehlgeschlagen!", "ajax/tuitionEnd.php", function (result) {
    toastr.success("Beenden erfolgreich!");
    //location.reload();
});

var RemoveNotificationHelper = new AjaxFormHelper($(".remove-notification"), "Beenden fehlgeschlagen!", "ajax/Setters/removeNotification.php", function (result, element) {
    toastr.success("Beenden erfolgreich!");
    $(element).parents('.result-box').remove();
});

var requestResponseFormHelper = new AjaxFormHelper($(".request-response-form"), "Senden fehlgeschlagen!", "ajax/requestResponse.php", function (result) {
    var btn = $(document.activeElement);
    if (btn.val() == "acceptRequest") {
        toastr.success("Anfrage angenommen!");
        $(document.activeElement).parents('.result-box').remove();
    }
    else {
        result.requests.forEach(function (request) {
            $("[value=" + request.idAnfrage + "]").parents('.result-box').remove();
        });
        toastr.success("Anfrage abgelehnt!");
    }
}, function (formData) {
    var btn = $(document.activeElement);
    formData.append('response', btn.attr('value'));
});

var editRoleFormHelper = new AjaxFormHelper($("#rolle-edit-form"), "Rolle nicht editierbar!", "ajax/Forms/editRoleForm.php", function (result) {
    toastr.success("Rolle erfolgreich editiert!");
}, function (formdata) {
    var rollen = [];
    $.each($("[name=rollenButton]"), function (i, entry) {
        if ($(entry).attr('class').includes("success")) {
            rollen.push($(entry).val());
        }
    });
    formdata.append('rollen', JSON.stringify(rollen));
});

var addRoleFormHelper = new AjaxFormHelper($("#rolle-add-form"), "Rolle nicht hinzufügbar!", "ajax/addRoleForm.php", function (result) {
    toastr.success("Rolle erfolgreich hinzugefügt!");
}, function (formdata) {
    var rollen = [];
    $.each($("[name=rollenAddingButton]"), function (i, entry) {
        if ($(entry).attr('class').includes("success")) {
            rollen.push($(entry).val());
        }
    });
    formdata.append('rollen', JSON.stringify(rollen));
});

$(document).on("submit", '#register-form', function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/registerUser.php", function (result) {
        toastr.success(result.name + " wurde erfolgreich registriert!");
        document.getElementsByName("vorname")[0].value = "";
        document.getElementsByName("nachname")[0].value = "";
        document.getElementsByName("email")[0].value = "";
        document.getElementById('rollen').value = 0;
    }, {
        'vorname': document.getElementsByName("vorname")[0].value,
        'nachname': document.getElementsByName("nachname")[0].value,
        'email': document.getElementsByName("email")[0].value,
        'rolle': document.getElementById('rollen').value
    });
});


$(document).on("click", "[name='rollenButton']", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    if (ev.target.className.includes("success")) {
        element.removeClass("success");
        element.addClass("alert");
    }
    else {
        element.removeClass("alert");
        element.addClass("success");
    }
});

$(document).on("click", "[name='rollenAddingButton']", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    if (ev.target.className.includes("success")) {
        element.removeClass("success");
        element.addClass("alert");
    }
    else {
        element.removeClass("alert");
        element.addClass("success");
    }
});
