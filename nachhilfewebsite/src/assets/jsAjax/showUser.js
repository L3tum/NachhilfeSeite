/**
 * Created by Tom on 02.05.2017.
 */

var generatePDFFormHelper = new AjaxFormHelper($("#show-pdf-form"), "Fehlgeschlagen!", "", function (result) {

}, function (formData) {
    var btn = $(document.activeElement);
    var buttonVal = btn.attr('value');
    var idBenutzer = $('#pdf-user').val();
    var year = $('#pdf-year').val();
    window.location = getRootUrl() + "user/" + idBenutzer + "/pdf/" + buttonVal + "/" + year;
});

$(document).on("click", "#nachhilfeAnfragenButton", function (ev) {
    ev.preventDefault();

    var faecher = $('[name=fachButton]');
    var selectedFaecher = [];
    var firstConnection = null;
    var firstRequest = null;

    $.each(faecher, function (i, fach) {
        if ($(fach).hasClass("warning")) {
            selectedFaecher.push($(fach).attr('id'));
        }
        else if ($(fach).hasClass("firstRequest")) {
            firstRequest = $(fach).attr('id');
        }
        else if ($(fach).hasClass("firstConnection")) {
            firstConnection = $(fach).attr('id');
        }
    });

    runMyAjax("ajax/nachhilfeAnfrage.php", function (result) {

        toastr.success("Anfrage gesendet!");
        /*
         selectedFaecher.forEach(function (fache) {
         var parent = $("#" + fache).parent();
         var fachen = $("#" + fache).text();
         parent.empty();
         if (firstRequest == null && firstConnection == null) {
         parent.append("<p type='button' id=" + fache + " name='fachButton' class='labelled secondary center'>" + fachen + "</p><input type='hidden' value='Ja' id='" + fache + "isAnfrage'>");
         }
         else {
         parent.append("<div class='data-label secondary'><p class='center'>" + fachen + "</p></div>")
         }
         });
         if (firstConnection != null) {
         var parent = $("#" + firstConnection).parent();
         var fachen = $("#" + firstConnection).text();
         parent.empty();
         parent.append("<div class='data-label firstConnection'><p class='center'>" + fachen + "</p></div>");
         $("#connectionFirst").val("Ja");
         buttons = $("[name=fachButton]");
         buttons.forEach(function(button){

         });
         }
         else if (firstRequest != null) {
         var parent = $("#" + firstConnection).parent();
         var fachen = $("#" + firstConnection).text();
         parent.empty();
         parent.append("<div class='data-label firstRequest'><p class='center'>" + fachen + "</p></div>")
         $("#anfrageFirst").val("Ja");
         }
         */
        location.reload();
    }, {
        'user': $("#user_to_show").val(),
        'faecher': selectedFaecher,
        'firstConnection': firstConnection,
        'firstRequest': firstRequest
    })
});
$(document).on("click", '[name=fachButton]', function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    if (ev.target.className.includes("success")) {
        element.removeClass("success");
        element.addClass("warning");
    }
    else if (ev.target.className.includes("warning")) {
        if ($("#" + element.attr('id') + "connection").val() == "Nein" && $("#anfrageFirst").val() == "Nein") {
            element.removeClass("warning");
            element.addClass("firstRequest");
            $("#anfrageFirst").val("Ja");
        }
        else {
            element.removeClass("warning");
            element.addClass("success");
        }
    }
    else if (ev.target.className.includes("firstRequest")) {
        if ($("#" + element.attr('id') + "ísAnfrage").val() == "Ja") {
            element.removeClass("firstRequest");
            element.addClass("secondary");
            $("#anfrageFirst").val("Nein");
        }
        else {
            element.removeClass("firstRequest");
            element.addClass("success");
            $("#anfrageFirst").val("Nein");
        }
    }
    else if (ev.target.className.includes("secondary")) {
        if ($("#anfrageFirst").val() == "Nein" && $("#connectionFirst").val() == "Nein") {
            element.removeClass("secondary");
            element.addClass("firstRequest");
            $("#anfrageFirst").val("Ja");
        }
    }
    else if (ev.target.className.includes("alter")) {
        if ($("#connectionFirst").val() == "Nein" && $("#anfrageFirst").val() == "Nein") {
            element.removeClass("alter");
            element.addClass("firstConnection");
            $("#connectionFirst").val("Ja");
        }
        else {
            toastr.info("Anscheinend hast du bereits eine kostenlose Verbindung/Anfrage!");
        }
    }
    else if (ev.target.className.includes("firstConnection")) {
        element.removeClass("firstConnection");
        element.addClass("alter");
        $("#connectionFirst").val("Nein");
    }
});

$(document).on("click", "#alerting", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    var parent = element.parent();
    parent.empty();
    parent.append("<div class='data-label'><input type='text' id='reasoning'><button class='button alert' id='submitting'>Submit</button></div>");
});
$(document).on("click", "#submitting", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    var parent = element.parent().parent();
    if ($("#reasoning").val() == "") {
        var id = $("#alerting").attr('name');
        parent.empty();
        parent.append("<a class='button alert' type='submit' name='" + id + "' id='alerting'>Nutzer melden</a>");
        toastr.error("Keinen Grund angegeben!");
    }
    else {
        runMyAjax("ajax/reportUser.php", function (result) {
            toastr.success("Benutzer gemeldet!");
            var id = $("#user_to_show").val();
            parent.empty();
            parent.append("<a class='button alert' type='submit' name='" + id + "' id='alerting'>Nutzer melden</a>");
        }, {'reason': $("#reasoning").val(), 'id': $("#user_to_show").val()})
    }
});

$(document).on("click", "#blockUserButton", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/blockUser.php", function (result) {
        toastr.success(result.name + " wurde gesperrt!");
        var parent = $(ev.target).parent();
        parent.empty();
        parent.append(`
            <div class="row actions">
            <div class="small-12 columns">
            <a id="unblockUserButton" class="button warning" type="submit" value="Submit">Benutzer entblocken</a>
        </div>
        </div>`);
    }, {'user': $("#user_to_show").val()})
});
$(document).on("click", "#unblockUserButton", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/unblockUser.php", function (result) {
        toastr.success(result.name + " wurde entsperrt!");
        var parent = $(ev.target).parent();
        parent.empty();
        parent.append(`
            <div class="row actions">
            <div class="small-12 columns">
            <a id="blockUserButton" class="button alert" type="submit" value="Submit">Benutzer blockieren</a>
        </div>
        </div>`);
    }, {'user': $("#user_to_show").val()})
});
