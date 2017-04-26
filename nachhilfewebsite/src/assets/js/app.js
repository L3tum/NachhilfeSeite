//Class that takes an element (form), and sends an ajax request if the form is valid (if it's not valid display invalidError). When the ajax
//responds with an error message, also display it. When the ajax succeeds call success with the send data as a parameter.
//If anything else than the form should get attached to the formData object, add something to the formDataAppend method. (files for ex.)
class AjaxFormHelper {

    constructor(element, invalidError, ajaxPath, success, formDataAppend = 0) {

        var $me = this;
        if (element[0] != null) {

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
                    if (ajaxPath == "ajax/requestResponse.php") {
                        if ($(ev.target).val() == "denyRequest") {
                            if ($(document.activeElement).parent().find("[name=kostenfrei]").val() == 1) {
                                var result = window.confirm("Da diese die Anfrage für eine kostenfreie Stunde wäre, würden alle anderen Anfragen dieses Benutzers auch gelöscht werden!");
                                if (result) {
                                    $me.runAjax(ajaxPath, element, success, formDataAppend, ev);
                                }
                                else {
                                }
                            }
                        }
                    }
                    $me.runAjax(ajaxPath, element, success, formDataAppend, ev);

                });
            if (ajaxPath == "ajax/Forms/searchForm.php") {
                $(document).ready(function (ev) {
                    ev.target = element;
                    var url = window.location.href;
                    if (url.includes("?")) {
                        $me.runAjaxSpecial(ajaxPath, element, success, element);
                    }
                });
            }
        }

    }

    //sends the actual ajax request
    runAjax(ajaxPath, element, success, formDataAppend, ev) {

        var formData = new FormData(ev.target);

        //Call the formDataAppend method to add custom data to the formData object initialized with the form element
        if (formDataAppend != 0) {
            formDataAppend(formData);
        }

        //console.log(getRootUrl() + ajaxPath);

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
                    success(resultObj, ev.target);
                }
            }
        });
    }

    runAjaxSpecial(ajaxPath, element, success, ev) {

        var formData = new FormData(document.getElementById("search-form"));
        //console.log(getRootUrl() + ajaxPath);

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

class AjaxFormHelperSpecial {

    constructor(element, invalidError, ajaxPath, success, formDataAppend = 0) {

        var $me = this;
        if (element[0] != null) {

            element
                .on("submit", function (ev) {
                    ev.preventDefault();
                    $me.runAjax(ajaxPath, element, success, formDataAppend);
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

/**
 * JS Implementation of MurmurHash3 (r136) (as of May 20, 2011)
 *
 * @author <a href="mailto:gary.court@gmail.com">Gary Court</a>
 * @see http://github.com/garycourt/murmurhash-js
 * @author <a href="mailto:aappleby@gmail.com">Austin Appleby</a>
 * @see http://sites.google.com/site/murmurhash/
 *
 * @param {string} key ASCII only
 * @param {number} seed Positive integer only
 * @return {number} 32-bit positive integer hash
 */

function murmurhash3_32_gc(key, seed) {
    var remainder, bytes, h1, h1b, c1, c1b, c2, c2b, k1, i;

    remainder = key.length & 3; // key.length % 4
    bytes = key.length - remainder;
    h1 = seed;
    c1 = 0xcc9e2d51;
    c2 = 0x1b873593;
    i = 0;

    while (i < bytes) {
        k1 =
            ((key.charCodeAt(i) & 0xff)) |
            ((key.charCodeAt(++i) & 0xff) << 8) |
            ((key.charCodeAt(++i) & 0xff) << 16) |
            ((key.charCodeAt(++i) & 0xff) << 24);
        ++i;

        k1 = ((((k1 & 0xffff) * c1) + ((((k1 >>> 16) * c1) & 0xffff) << 16))) & 0xffffffff;
        k1 = (k1 << 15) | (k1 >>> 17);
        k1 = ((((k1 & 0xffff) * c2) + ((((k1 >>> 16) * c2) & 0xffff) << 16))) & 0xffffffff;

        h1 ^= k1;
        h1 = (h1 << 13) | (h1 >>> 19);
        h1b = ((((h1 & 0xffff) * 5) + ((((h1 >>> 16) * 5) & 0xffff) << 16))) & 0xffffffff;
        h1 = (((h1b & 0xffff) + 0x6b64) + ((((h1b >>> 16) + 0xe654) & 0xffff) << 16));
    }

    k1 = 0;

    switch (remainder) {
        case 3:
            k1 ^= (key.charCodeAt(i + 2) & 0xff) << 16;
        case 2:
            k1 ^= (key.charCodeAt(i + 1) & 0xff) << 8;
        case 1:
            k1 ^= (key.charCodeAt(i) & 0xff);

            k1 = (((k1 & 0xffff) * c1) + ((((k1 >>> 16) * c1) & 0xffff) << 16)) & 0xffffffff;
            k1 = (k1 << 15) | (k1 >>> 17);
            k1 = (((k1 & 0xffff) * c2) + ((((k1 >>> 16) * c2) & 0xffff) << 16)) & 0xffffffff;
            h1 ^= k1;
    }

    h1 ^= key.length;

    h1 ^= h1 >>> 16;
    h1 = (((h1 & 0xffff) * 0x85ebca6b) + ((((h1 >>> 16) * 0x85ebca6b) & 0xffff) << 16)) & 0xffffffff;
    h1 ^= h1 >>> 13;
    h1 = ((((h1 & 0xffff) * 0xc2b2ae35) + ((((h1 >>> 16) * 0xc2b2ae35) & 0xffff) << 16))) & 0xffffffff;
    h1 ^= h1 >>> 16;

    return h1 >>> 0;
}

function isNodeList(nodes) {
    var stringRepr = Object.prototype.toString.call(nodes);

    return typeof nodes === 'object' &&
        /^\[object (HTMLCollection|NodeList|Object)\]$/.test(stringRepr) &&
        (typeof nodes.length === 'number') &&
        (nodes.length === 0 || (typeof nodes[0] === "object" && nodes[0].nodeType > 0));
}


function runMyAjax(ajaxPath, success, data = 0) {

    $.ajax({
        url: getRootUrl() + ajaxPath,
        dataType: 'json',
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function (result) {
            var resultObj = result; //JSON object

            if (resultObj.success == false) {
                toastr.error(resultObj.errorReason);
            }
            else {
                success(resultObj);
            }
        },
        error: function (data) {
            //if error
            console.log("Error!");
            console.log(data);
        }
    });
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

$(document).on("submit", "#user-add-form", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Forms/userAddForm.php", function (result) {
        toastr.success("Hinzufügen erfolgreich!");
    }, {
        'vorname': $("[name=vorname]").val(),
        'nachname': $("[name=nachname]").val(),
        'tel': $("[name=tel]").val(),
        'passwort': murmurhash3_32_gc($("[name=password]").val(), 2476),
        'passwortConfirm': murmurhash3_32_gc($("[name=passwordConfirm]").val(), 2476),
        'email': $("[name=email]").val(),
        'rollen': $("[name=rollen]").val()
    })
});

var loginFormHelper = new AjaxFormHelper($("#login-form"), "Login fehlgeschlagen!", "ajax/Forms/loginForm.php", function (result) {
    location.reload();
}, function (formData) {
    formData.set("passwort", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
});

var userEditFormHelper = new AjaxFormHelper($("#user-edit-form"), "Änderung fehlgeschlagen!", "ajax/Forms/userEditForm.php", function (result) {
    toastr.success("Änderungen übernommen!");
}, function (formdata) {
    var rollen = [];
    $.each($("[name=subjectChoosing]"), function (i, entry) {
        if ($(entry).attr('class').includes("success")) {
            rollen.push($(entry).attr('id'));
        }
    });
    formdata.append('faecher', JSON.stringify(rollen));
    var stufen = [];
    $.each($("[name=yearChoosing]"), function (i, entry) {
        if ($(entry).attr('class').includes("success")) {
            stufen.push($(entry).attr('id'));
        }
    });
    formdata.append('stufen', JSON.stringify(stufen));
    formdata.append('wantsEmails', JSON.stringify($("#wantsEmails").val()));
    formdata.set("passwort", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
    formdata.set("passwort-wiederholung", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
});

var sendMessageFormHelper = new AjaxFormHelper($("#send-message-form"), "Senden fehlgeschlagen!", "ajax/sendMessage.php", function (result) {
    toastr.success("Senden erfolgreich!");
    location.reload();
});

var TuitionEndFormHelper = new AjaxFormHelper($(".tuition-end-form"), "Beenden fehlgeschlagen!", "ajax/tuitionEnd.php", function (result) {
    toastr.success("Beenden erfolgreich!");
    //location.reload();
});

var RemoveNotificationHelper = new AjaxFormHelper($(".remove-notification"), "Beenden fehlgeschlagen!", "ajax/Setters/removeNotification.php", function (result, element) {
    toastr.success("Beenden erfolgreich!");
    $(element).parents('.result-box').remove();
});

var generatePDFFormHelper = new AjaxFormHelper($("#show-pdf-form"), "Fehlgeschlagen!", "", function (result) {

}, function (formData) {
    var btn = $(document.activeElement);
    var buttonVal = btn.attr('value');
    var idBenutzer = $('#pdf-user').val();
    var year = $('#pdf-year').val();
    window.location = getRootUrl() + "user/" + idBenutzer + "/pdf/" + buttonVal + "/" + year;
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


var searchFormHelper = new AjaxFormHelper($("#search-form"), "Suche fehlgeschlagen!", "ajax/Forms/searchForm.php", function (result) {
    toastr.success("Suche erfolgreich!");
    $("#search-results").empty();

    if (result.users.length == 0) {
        $("#search-results").append(
            "<div class='result-box'><div class='row no-padding left'><div class='small-8-centered columns'><div class='row no-padding right'><div class='small-12-centered columns notification-header no-padding align-center text-center'><p>Kein Nutzer gefunden!</p></div><div class='small-12 columns no-padding right'>  </div></div></div> <div class='small-4 columns no-padding both'> <div class='button-group medium '> </div> </div> </div> </div>"
        );
    }
    else {
        var root = getRootUrl();
        var permission = result.canDelete;
        var permission2 = result.canUnblockUsers;
        var html = "<table><thead><tr><th>Benutzer</th><th>Rolle</th><th>Profil</th>";
        if (permission == true) {
            html += "<th>Sperren</th>";
        }
        if (permission2 == true) {
            html += "<th>Entsperren</th>"
        }
        html += "</th></thead><tbody>";
        result.users.forEach(function (entry) {
            html += "<tr><td>" + entry.vorname + " " + entry.name + "</td><td>" + entry.rollenname + "</td><td><a class='tablebutton success' href='" + root + "user/" + entry.idBenutzer.toString() + "/view" + "'>Profil</a></td>";
            if (permission == true) {
                if (entry.gesperrt == null || entry.gesperrt == 0 || entry.gesperrt == false) {
                    html += "<td><button class='tablebutton alert' id='" + entry.idBenutzer + "' name='blockUserNow'>Sperren</button></td>";
                }
                else {
                    html += "<td><p id='hii' class='alert'>Gesperrt</p></td>";
                }
            }
            if (permission2 == true) {
                if (entry.gesperrt == 1) {
                    html += "<td><button class='tablebutton success' id='" + entry.idBenutzer + "' name='unBlockUserNow'>Entsperren</button></td>"
                }
                else {
                    html += "<td><p id='hi' class='success'>Entsperrt</p></td>";
                }
            }
            html += "</tr>";
        });
        html += "</tbody></table>";
        $("#search-results").append(html);
    }
    var stateObj = {"url": "suche"};
    history.pushState(stateObj, "Nachhilfeseite", result.newUrl);
});

$(document).on("click", "[name=blockUserNow]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/blockUser.php", function (result) {
        toastr.success(result.name + " wurde gesperrt!");
        var parent = $(ev.target).parent();
        var id = $(ev.target).attr('id');
        parent.empty();
        var otherParent = parent.parent().find("p").parent();
        parent.append("<p class='alert'>Gesperrt</p>");
        otherParent.empty();
        otherParent.append("<button class='tablebutton success' id='" + id + "' name='unBlockUserNow'>Entsperren</button>");
    }, {'user': $(ev.target).attr('id')})
});


$(document).on("click", "[name=unBlockUserNow]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/unblockUser.php", function (result) {
        toastr.success(result.name + " wurde entsperrt!");
        var parent = $(ev.target).parent();
        var id = $(ev.target).attr('id');
        parent.empty();
        var otherParent = parent.parent().find("p").parent();
        parent.append("<p id='hi' class='success'>Entsperrt</p>");
        otherParent.empty();
        otherParent.append("<button class='tablebutton alert' id='" + id + "' name='blockUserNow'>Sperren</button>");
    }, {'user': $(ev.target).attr('id')})
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

$(document).on("submit", "#appointment-form", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/isFreeLessonsAndHasFreeHours.php", function (result) {
        if (result.isFirst && !result.hasFree) {
            var results = window.confirm("Du hast bereits dein wöchentliches Kontingent ausgeschöpft und müsstest diese Stunde bezahlen! Fortfahren?");
            if (results) {
                var formData = new FormData(ev.target);
                formData.append("hasToPay", JSON.stringify(true));
                runMyAjax("ajax/Forms/appointmentForm.php", function (result) {
                    toastr.success("Termin erfolgreich hinzugefügt!");
                }, formData);
            }
        }
        else if (result.isFirst && result.hasFree) {
            var formData = new FormData(ev.target);
            formData.append("hasToPay", JSON.stringify(false));
            runMyAjax("ajax/Forms/appointmentForm.php", function (result) {
                toastr.success("Termin erfolgreich hinzugefügt!");
            }, formData);
        }
        else {
            var formData = new FormData(ev.target);
            formData.append("hasToPay", JSON.stringify(true));
            runMyAjax("ajax/Forms/appointmentForm.php", function (result) {
                toastr.success("Termin erfolgreich hinzugefügt!");
            }, formData);
        }
    })
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

$(document).on("click", "#add_qual", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/AddQual.php", function (result) {
        toastr.success(result.name + " wurde hinzugefügt!");
        document.getElementById("qual_name").value = "";
        document.getElementById("qual_desc").value = "";
        runMyAjax("ajax/Getters/getAllQuals.php", function (result) {
            var element = $("#delet_qual");
            element.empty()
            result.quals.forEach(function (qual) {
                element.append("<option id='" + qual.idQualifikation + "' name='" + qual.idQualifikation + "' >" + qual.name + "</option>")
            });
        }, {'id': $("#user-id").val()});
    }, {'name': $("#qual_name").val(), 'desc': $("#qual_desc").val(), 'id': $("#user-id").val()})
});

$(document).on("click", "#del_qual", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    runMyAjax("ajax/delQual.php", function (result) {
        toastr.success(result.name + " wurde erfolgreich entfernt!");
        element.parent().find("#delet_qual").find("#" + element.parent().find("#delet_qual").find(':selected').attr('id')).remove();
    }, {
        'id': element.parent().find("#delet_qual").find(':selected').attr('id'),
        'name': element.parent().find("#delet_qual").find("#" + element.parent().find("#delet_qual").find(':selected').attr('id')).text()
    });
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


$(document).on("click", "[name=refuseButton]", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    runMyAjax("ajax/deleteRequest.php", function (result) {
        toastr.success("Termin abgelehnt!");
    }, {'id': element.attr('id')});
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
        else{
            toastr.info("Anscheinend hast du bereits eine kostenlose Verbindung/Anfrage!");
        }
    }
    else if (ev.target.className.includes("firstConnection")) {
        element.removeClass("firstConnection");
        element.addClass("alter");
        $("#connectionFirst").val("Nein");
    }
});

$(document).on("click", '[name=bestaetigenButton]', function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    if (element.hasClass("alert")) {
        runMyAjax("ajax/confirmHourTeacher.php", function (result) {
            toastr.success("Stunde bestätigt!");
            element.removeClass("alert");
            element.addClass("success");
            element.text("Ja");
        }, {'id': element.attr('id')});
    }
});

$(document).on("click", '[name=bestaetigen3Button]', function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    if (element.hasClass("alert")) {
        runMyAjax("ajax/confirmHourStudent.php", function (result) {
            toastr.success("Stunde bestätigt!");
            element.removeClass("alert");
            element.addClass("success");
            element.text("Ja");
        }, {'id': element.attr('id')});
    }
});


$(document).on("click", '[name=subjectChoosing]', function (ev) {
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

$(document).on("click", '[name=yearChoosing]', function (ev) {
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

//Button listeners
$('#register_new_user').on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    runMyAjax("ajax/Getters/getRollen.php", function (result) {
        var html = `<form data-abide novalidate id="register-form" method="post">
            <div class="row">

                <div class="small-12 medium-6 columns small-centered">
                    <label>Vorname
                        <input name="vorname" type="text" placeholder="Max" required pattern="^[a-zA-ZÄÖÜäöüß]{1,20}$">
                            <span class="form-error">
                                Der Vorname darf nicht leer sein oder aus mehr als 20 Buchstaben bestehen.
                            </span>
                    </label>

                    <label>Nachname
                        <input name="nachname" type="text" placeholder="Mustermann" required pattern="^[a-zA-ZÄÖÜäöüß]{1,20}$">
                            <span class="form-error">
                                Der Nachname darf nicht leer sein oder aus mehr als 20 Buchstaben bestehen.
                            </span>
                    </label>

                    <label>Email
                        <input name="email" type="email" required>
                        <span class="form-error">
                            Das Emailfeld darf nicht leer sein.
                        </span>
                    </label>
                    
                    <label>Rollen
                        <select id="rollen" name="rollen">`;
        result.rollen.forEach(function (rolle) {
            html += ("<option value=" + rolle.idRolle + ">" + rolle.name + "</option>");
        });
        html += `
                        </select>
                    </label>

                    <button class="button" type="submit" value="Submit">Registrieren</button>
                </div>
            </div>
        </form>`;
        $("#results").append(html);
    });
});

$("#show_roles").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();

    runMyAjax("ajax/Getters/getRollen.php", function (result) {
            var html = `<div class="row">
        <div class="small-12 columns">
            <a class="button success" id="add_role" href="${getRootUrl() + 'role/add'}">Rolle hinzufügen</a>`;
            result.rollen.forEach(function (rolle) {
                html += `
<div class="small-10-centered columns data-label">
                        <div class="small-8 columns">
                            <p class='center'>${rolle.name}</p>
                             </div>
                                <div class="small-2 columns">
                                    <a href="${getRootUrl() + 'role/' + rolle.idRolle + '/view'}" class="button warning no-margin-bottom small" value="${rolle.idRolle}" name="roleChange">Anzeigen</a>
                                </div>
                                <div class="small-2 columns">
                                    <a class="button alert no-margin-bottom small" value="${rolle.idRolle}" name="roleDel">Löschen</a>
                                    </div>
</div></div></div>`;
            });
            $("#results").append(html);
        }
    );
});

$(document).on("click", "[name=roleDel]", function (ev) {
    ev.preventDefault();
    var id = $(ev.target).attr('value');
    runMyAjax("ajax/deleteRole.php", function (result) {
        toastr.success(result.name + " wurde erfolgreich gelöscht!");
    }, {'id': id});
});

var rowsTextArray = [];
var $rows;
$("#show_connections").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();
    runMyAjax("ajax/Getters/getConnectionsWithNames.php", function (result) {
        var html = "<table class='hover'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Fach</th><th>Freigeben</th><th>Löschen</th></tr></thead><tbody id='connections'>";
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.fachName + "</td>";
            if (data.blockiert) {
                html += "<td><button class='tablebutton alert' id='" + data.idVerbindung + "' name='unblockConny'>Freigeben</button></td>";
            }
            else {
                html += "<td><p>Freigegeben</p></td>";
            }
            html += "<td><button class='tablebutton alert' id='" + data.idVerbindung + "' name='deleteConny'>Löschen</button></td></tr>";
        });
        html += "</tbody></table>";
        $('#results').append(html);
    });
});

$(document).on("click", "[name=deleteConny]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/deleteConnection.php", function (result) {
        toastr.success("Verbindung gelöscht!");
        $(ev.target).removeClass("alert").addClass("success");
        ev.target.text = "Gelöscht";
    }, {'id': $(ev.target).attr('id')})
});
$(document).on("click", "[name=unblockConny]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/unblockConnection.php", function (result) {
        toastr.success("Verbindung freigegeben!");
        $(ev.target).removeClass("alert").addClass("success");
        ev.target.text = "Freigegeben";
    }, {'id': $(ev.target).attr('id')})
});


$("#show_pending_hours").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();
    runMyAjax("ajax/Getters/getPendingHours.php", function (result) {
        var html = "<table class='hover'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Datum</th><th>Raum</th></tr></thead><tbody>";
        if (Object.prototype.toString.call(result.data) === '[object Array]') {
            result.data.forEach(function (data) {
                html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.datum + "</td><td>" + data.raumNummer + "</td></tr>";
            });
        }
        else {
            html += "<tr><td>" + result.data.lehrerVorname + " " + result.data.lehrerName + "</td><td>" + result.data.nehmerVorname + " " + result.data.nehmerName + "</td><td>" + result.data.datum + "</td><td>" + result.data.raumNummer + "</td></tr>";
        }
        html += "</tbody></table>";
        $('#results').append(html);
    });
});

$("#show_unpaid_hours").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();
    runMyAjax("ajax/getUnpaidHours.php", function (result) {
        var html = "<div class='small-12-centered columns align-center'><table id='unpaid_table'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Datum</th><th>Bezahlt</th><th>Bezahlt(Admin)</th></tr></thead><tbody>";
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.datum + "</td>";
            if (data.lehrerBezahlt == 1) {
                html += "<td class='align-center'><p class='text-center success'>Bezahlt</p></td>";
            }
            else {
                html += "<td class='align-center'><p class='text-center alert'>Unbezahlt</p></td>";
            }
            if (data.adminBezahlt == 1) {
                html += "<td class='align-center'><p class='text-center success'>Bezahlt</p></td></tr>";
            }
            else {
                html += "<td><a id='" + data.idStunde + "' name='confirm_payment_admin' class='tablebutton alert'>Bestätige Zahlung</a></td></tr>";
            }
        });
        html += "</tbody></table></div>";
        $('#results').append(html);
    });
});

$(document).on("click", "a[name='confirm_payment_admin']", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/confirmPaymentAdmin.php", function (result) {
        toastr.success("Bezahlung bestätigt!");
        var parent = $(ev.target).parent();
        parent.empty();
        parent.append("<p class='text-center success'>Bezahlt</p>");
    }, {'idStunde': $(ev.target).attr('id')});
});

$("#show_free_rooms").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();
    var html = `<div class="row">
<div class="small-12 columns">
<div class="small-10-centered columns">
                        <div class="small-8 columns">
                        <div class="small-6 columns no-padding both">
                        <input type="date" min="${getCurrentDate()}" id="datePicker">
                        </div>
                        <div class="small-6 columns no-padding both">
                        <input type="time" id="timePicker">
                        </div>
                        </div>
                        <div class="small-2 columns">
                        <a class="button" type="submit" id="datePickButton">Suche</a>
</div>
</div>
<p>Die Räume werden auf Zeitpunkt+45 Minuten geprüft!</p>
<h3>Freie Räume</h3>
<div class="row" id="rooms">
</div>
</div>`;
    $('#results').append(html);
});

$(document).on("click", "#datePickButton", function (ev) {
    ev.preventDefault();
    $("#rooms").empty();
    runMyAjax("ajax/Getters/getFreeRooms.php", function (result) {
        var html = `<div class="small-12 columns">`;
        result.raeume.forEach(function (raum) {
            html += "<p class='data-label'>" + raum.raumNummer + "</p>"
        })
        html += "</div>";
        $("#rooms").append(html);
    }, {'date': $("#datePicker").val(), 'time': $("#timePicker").val() + ":00"});
});

$("#show_taken_rooms").on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    var html = `<div class="row">
<div class="small-12 columns">
<div class="small-10-centered columns">
                        <div class="small-8 columns">
                        <div class="small-6 columns no-padding both">
                        <input type="date" min="${getCurrentDate()}" id="datePickerTaken">
                        </div>
                        <div class="small-6 columns no-padding both">
                        <input type="time" id="timePickerTaken">
                        </div>
                        </div>
                        <div class="small-2 columns">
                        <a class="button" type="submit" id="datePickButtonTaken">Suche</a>
</div>
</div>
<p>Die Räume werden auf Zeitpunkt+45 Minuten geprüft!</p>
<p>Ohne Eingabe werden alle Buchungen angezeigt!</p>
<h3>Gebuchte Räume</h3>
<div class="row" id="rooms">
</div>
</div>`;
    $('#results').append(html);
});

$(document).on("click", "#datePickButtonTaken", function (ev) {
    ev.preventDefault();
    $("#rooms").empty();
    runMyAjax("ajax/Getters/getTakenRooms.php", function (result) {
        var html = `<div class="small-12-centered columns"><table id='taken_rooms_table'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Datum</th><th>Raum</th></tr></thead><tbody>`;
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.datum + "</td><td>" + data.raumNummer + "</td></tr>"
        });
        html += "</tbody></table></div>";
        $("#rooms").append(html);
    }, {'date': $("#datePickerTaken").val(), 'time': $("#timePickerTaken").val() + ":00"});
});

$("#show_complaints").on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    runMyAjax("ajax/Getters/getComplaints.php", function (result) {
        var html = `<div class="small-12-centered columns"><table id='taken_rooms_table'><thead><tr><th>Gegen</th><th>Von</th><th>Grund</th><th>Löschen</th></tr></thead><tbody>`;
        var i = 0;
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.gegenVorname + " " + data.gegenName + "</td><td>" + data.vonVorname + " " + data.vonName + "</td><td>" + data.grund + "</td><td><button class='tablebutton alert' name='deleteBeschwerde' value='" + data.gegenID + "," + data.vonID + "' id='" + i + "'>Löschen</button></td></tr>"
            i++;
        });
        html += "</tbody></table></div>";
        $('#results').append(html);
    });
});

$(document).on("click", 'button[name=deleteBeschwerde]', function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/deleteComplaint.php", function (result) {
        toastr.success("Beschwerde gelöscht!");
        var parent = $("#" + result.id).parent();
        parent.empty();
        parent.append("<p class='success'>Gelöscht!</p>");
    }, {'ID': $(ev.target).attr('id'), 'IDs': $(ev.target).val()});
});

$("#add_subject").on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    var html = "<div class='small-12-centered columns'><input type='text' id='subject_name' name='subject_name' required placeholder='Deutsch'><button class='button' type='submit' name='submitSubject' id='submitSubject'>Submit</button></div>";
    $("#results").append(html);
});
$(document).on("click", "#submitSubject", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/AddSubject.php", function (result) {
        toastr.success(result.name + " wurde erfolgreich hinzugefügt!");
        $("#results").empty();
    }, {'subject': $("#subject_name").val()});
});

$("#del_subject").on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    var html = "<div class='small-12-centered columns'><label>Fächer<select id='sel_subject' name='sel_subject'>";
    runMyAjax("ajax/Getters/getAllSubjects.php", function (result) {
        result.subjects.forEach(function (subject) {
            html += "<option id='" + subject['idFach'] + "' name='" + subject['idFach'] + "'>" + subject['name'] + "</option>";
        });
        html += "</select></label><button class='button alert' id='deleteSUBJECT'>Fach Löschen</button></div>";
        $("#results").append(html);
    });
});
$(document).on("click", "#deleteSUBJECT", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/deleteSubject.php", function (result) {
        toastr.success("Fach gelöscht!");
        $("#" + result.id).remove();
    }, {'id': $("#sel_subject").find(':selected').attr('id')})
});

$("#add_year").on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    var html = "<div class='small-12-centered columns'><input type='text' id='year' name='year' required placeholder='Stufe'><button class='button' type='submit' name='submitYear' id='submitYear'>Submit</button></div>";
    $("#results").append(html);
});
$(document).on("click", "#submitYear", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/AddYear.php", function (result) {
        toastr.success(result.name + " wurde erfolgreich hinzugefügt!");
        $("#results").empty();
    }, {'year': $("#year").val()});
});

$("#del_year").on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    var html = "<div class='small-12-centered columns'><label>Stufen<select id='sel_year' name='sel_year'>";
    runMyAjax("ajax/Getters/getAllYears.php", function (result) {
        result.years.forEach(function (year) {
            html += "<option id='" + year['idStufe'] + "' name='" + year['idStufe'] + "'>" + year['name'] + "</option>";
        });
        html += "</select></label><button class='button alert' id='deleteYEAR'>Schüljahr Löschen</button></div>";
        $("#results").append(html);
    });
});
$(document).on("click", "#deleteYEAR", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/deleteYear.php", function (result) {
        toastr.success("Jahr geläscht!");
        $("#" + result.id).remove();
    }, {'id': $("#sel_year").find(':selected').attr('id')})
});

$(document).on("click", "[name=acceptAppointment]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/acceptAppointment.php", function (result) {
        toastr.success("Termin angenommen!");
        var parent = $(ev.target).parent().parent();
        parent.empty();
        parent.append("<td class='success'>Ja</td>");
    }, {'id': $(ev.target).attr('id')})
});
$(document).on("click", "[name=denyAppointment]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/denyAppointment.php", function (result) {
        toastr.success("Termin abgelehnt!");
        var parent = $(ev.target).parent().parent().parent();
        parent.remove();
    }, {'id': $(ev.target).attr('id')});
});

function updateBenutzer(array, jQueryObject, selected=null){
    jQueryObject.empty();
    jQueryObject.append("<option value='no'>Nichts</option>");
    if(array != false) {
        array.forEach(function (arr) {
            if (selected != null && selected == arr['ID']) {
                jQueryObject("<option value='" + arr['ID'] + "' selected>" + arr['vorname'] + " " + arr['name'] + "</option>");
            }
            else {
                jQueryObject.append("<option value='" + arr['ID'] + "'>" + arr['vorname'] + " " + arr['name'] + "</option>");
            }
        })
    }
}
function updateFächer(array, jQueryObject, selected=null){
    jQueryObject.empty();
    jQueryObject.append("<option value='no'>Nichts</option>");
    if(array != false) {
        array.forEach(function (arr) {
            if (selected != null && selected == arr['idFach']) {
                jQueryObject("<option value='" + arr['idFach'] + "' selected>" + arr['name'] + "</option>");
            }
            else {
                jQueryObject.append("<option value='" + arr['idFach'] + "'>" + arr['name'] + "</option>");
            }
        })
    }
}

$(document).on("change", "#idUser", function (ev) {
    ev.preventDefault();
    var subjects = $("#idSubject");
    //Benutzer wurde abgewählt und Fach war nie ausgewählt
    if ($(ev.target).val() == "no" && subjects.val() == "no") {
        //Update Fächer
        runMyAjax("ajax/Getters/getAllSubjects.php", function (result) {
            updateFächer(result.subjects, subjects);
        });
        //Update Benutzer
        runMyAjax("ajax/Getters/getAllConnectionUsers.php", function (result) {
            updateBenutzer(result.users, $(ev.target));
        });
    }
    //Benutzer wurde ausgewählt und Fach war nie ausgewählt
    else if ($(ev.target).val() != "no" && subjects.val() == "no") {
        //Update Fächer
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            updateFächer(result.subjects, subjects);
        }, {'user': $(ev.target).val()});
    }
    //Benutzer wurde abgewählt und Fach war ausgewählt
    else if (subjects.val() != "no" && $(ev.target).val() == "no") {
        //Update Benutzer
        runMyAjax("ajax/Getters/getUsersBySubject.php", function (result) {
            updateBenutzer(result.users, $(ev.target));
        }, {'fach': subjects.val()});
        //Update Fächer und select das ausgewählte Fach
        runMyAjax("ajax/Getters/getAllSubjects.php", function (result) {
            var idFach = subjects.val();
            updateFächer(result.subjects, subjects, idFach);
        });
    }
    //Benutzer wurde ausgewählt und Fach war ausgewählt
    else if (subjects.val() != "no" && $(ev.target).val() != "no") {
        //Update Fächer und wähle das ausgewählte Fach aus
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = subjects.val();
            updateFächer(result.subjects, subjects, idFach);
        }, {'user': $(ev.target).val()})
    }
});
$(document).on("change", "#idSubject", function (ev) {
    ev.preventDefault();
    var users = $("#idUser");
    //Fach wurde ausgewählt und Benutzer war nie ausgewählt
    if (users.val() == "no" && $(ev.target).val() != "no") {
        //Update Benutzer
        runMyAjax("ajax/Getters/getUsersBySubject.php", function (result) {
            updateBenutzer(result.users, users);
        }, {'fach': $(ev.target).val()});
    }
    //Fach wurde abgewählt und Benutzer war nie ausgewählt
    else if (users.val() == "no" && $(ev.target).val() == "no") {
        //Update Benutzer
        runMyAjax("ajax/Getters/getAllConnectionUsers.php", function (result) {
            updateBenutzer(result.users, users);
        });
        /* unnecessary (I think)
        //Update Fächer
        runMyAjax("ajax/Getters/getAllSubjects.php", function (result) {
            $(ev.target).empty();
            $(ev.target).append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    $(ev.target).append("<option value='" + subject['idFach'] + "'>" + subject['name'] + "</option>");
                });
            }
        });
        */
    }
    //Fach wurde abgewählt und Benutzer war ausgewählt
    else if ($(ev.target).val() == "no" && users.val() != "no") {
        //Update Fächer
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = $(ev.target).val();
            updateFächer(result.subjects, $(ev.target), idFach);
        }, {'user': users.val()});

        //Update Benutzer und selecte den ausgewählten
        var idBenutzer = users.val();
        runMyAjax("ajax/Getters/getAllConnectionUsers.php", function(result){
           updateBenutzer(result.users, users, idBenutzer);
        });
    }
    //Fach wurde ausgewählt und Benutzer war ausgewählt
    else if (users.val() != "no" && $(ev.target).val() != "no") {
        //Update Fächer und selecte ausgewähltes
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = $(ev.target).val();
            updateFächer(result.subjects, $(ev.target), idFach);
        }, {'user': users.val()});
        //Update Benutzer und selecte den ausgewählten
        var idBenutzer = users.val();
        runMyAjax("ajax/Getters/getUsersBySubject.php", function (result) {
            updateBenutzer(result.users, users, idBenutzer);
        }, {'fach': $(ev.target).val()});
    }
});

var date = null;
var time = null;
$(document).on("focusout", "#datetime_app", function (ev) {
    ev.preventDefault();
    date = $(ev.target).val();
    if (date != null && time != null) {
        updateRooms();
    }
});
$(document).on("focusout", "#time_app", function (ev) {
    ev.preventDefault();
    time = $(ev.target).val();
    if (date != null && time != null) {
        updateRooms();
    }
});

$(document).on("click", "#add_right", function (ev) {
    ev.preventDefault();
    var html = "<div class='small-12-centered columns'><input type='text' placeholder='Berechtigung' id='berechtigung_name' required><input type='text' id='berechtigung_desc' placeholder='Beschreibung (optional)'><br><button class='button success' id='submit_right' name='Submit'>Submit</button>";
    $("#results").empty();
    $("#results").append(html);
});
$(document).on("click", "#submit_right", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Setters/addBerechtigung.php", function (result) {
        toastr.success("Berechtigung erfolgreich hinzugefügt!");
        $("#berechtigung_name").val('');
        $("#berechtigung_desc").val('');
    }, {'name': $("#berechtigung_name").val(), 'desc': $("#berechtigung_desc").val()})
});

$(document).on("click", "#exec_sql", function (ev) {
    ev.preventDefault();
    var html = "<div class='small-12-centered columns'><input type='text' placeholder='SQL' id='sql' required><br><button class='button success' id='submit_sql' name='Submit'>Submit</button>";
    $("#results").empty();
    $("#results").append(html);
});
$(document).on("click", "#submit_sql", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/runSQL.php", function (result) {
        toastr.success("SQL erfolgreich ausgeführt!");
        $("#sql").val('');
    }, {'sql': $("#sql").val()})
});

$(document).on("click", "#show_all_hours", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    var html = "<div class='small-12-centered columns'><input type='month' id='pdf_month'><br><button class='button success' id='submit_pdf_month'>Submit</button></div>";
    $("#results").append(html);
});
$(document).on("click", "#submit_pdf_month", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/getAllHours.php", function (result) {
        var html = "<div class='small-12-centered columns'><input type='month' id='pdf_month'><br><button class='button success' id='submit_pdf_month'>Submit</button></div><div class='small-12 columns result-boxes'><div class='result-boxes-inner search'><table><thead><tr><th>Schüler</th><th>Lehrer</th><th>Datum</th><th>Stattgefunden</th><th>Verbindung Blockiert</th><th>Stunde freigeben</th><th>Stunde löschen</th></tr></thead><tbody>";
        if (Object.prototype.toString.call(result.hours) === '[object Array]') {
            result.hours.forEach(function (hour) {
                html += "<tr><td>" + hour.studentVorname + " " + hour.studentName + "</td><td>" + hour.teacherVorname + " " + hour.teacherName + "</td><td>" + hour.date + "</td><td>";
                if (hour.bestaetigtSchueler == 1 && hour.bestaetigtLehrer == 1 && hour.akzeptiert == 1) {
                    html += "<p class='success'>Ja</p>";
                }
                else if (hour.bestaetigtSchueler == 1 && hour.akzeptiert == 1) {
                    html += "<p class='warning'>Ja, laut Schüler</p>";
                }
                else if (hour.bestaetigtLehrer == 1 && hour.akzeptiert == 1) {
                    html += "<p class='warning'>Ja, laut Lehrer</p>";
                }
                else if (hour.akzeptiert == 1) {
                    html += "<p class='alert'>Stunde akzeptiert aber nicht stattgefunden</p>";
                }
                else if (hour.akzeptiert == -1) {
                    html += "<p class='alert'>Stunde wurde blockiert</p>";
                }
                else {
                    html += "<p class='alert'>Stunde weder akzeptiert noch stattgefunden</p>";
                }
                html += "</td><td>";
                if (hour.blockiert == 1) {
                    html += "<p class='alert'>Verbindung blockiert</p></td><td><button class='tablebutton alert' name='unblockHour' id='" + hour.idStunde + "'>Stunde freigeben</button></td>";
                }
                else {
                    html += "<p class='success'>Verbindung nicht blockiert</p></td><td><p>Nichts</p></td>";
                }
                html += "<td><button class='tablebutton alert' name='deleteHour' id='" + hour.idStunde + "'>Stunde löschen</button></td></tr>";
            });
        }
        else {
            html += "<tr><td>" + result.hours.studentVorname + " " + result.hours.studentName + "</td><td>" + result.hours.teacherVorname + " " + result.hours.teacherName + "</td><td>" + result.hours.date + "</td><td>";
            if (result.hours.bestaetigtSchueler == 1 && result.hours.bestaetigtLehrer == 1 && result.hours.akzeptiert == 1) {
                html += "<p class='success'>Ja</p>";
            }
            else if (result.hours.bestaetigtSchueler == 1 && result.hours.akzeptiert == 1) {
                html += "<p class='warning'>Ja, laut Schüler</p>";
            }
            else if (hours.bestaetigtLehrer == 1 && hours.akzeptiert == 1) {
                html += "<p class='warning'>Ja, laut Lehrer</p>";
            }
            else if (hours.akzeptiert == 1) {
                html += "<p class='alert'>Stunde akzeptiert aber nicht stattgefunden</p>";
            }
            else if (hours.akzeptiert == -1) {
                html += "<p class='alert'>Stunde wurde blockiert</p>";
            }
            else {
                html += "<p class='alert'>Stunde weder akzeptiert noch stattgefunden</p>";
            }
            if (hour.blockiert == 1) {
                html += "<p class='alert'>Verbindung blockiert</p></td><td><button class='tablebutton alert' name='unblockHour' id='" + hour.idStunde + "'>Stunde freigeben</button></td>";
            }
            else {
                html += "<p class='success'>Verbindung nicht blockiert</p></td><td><p>Nichts</p></td>";
            }
            html += "</td>";
            html += "<td><button class='tablebutton alert' name='deleteHour' id='" + hours.idStunde + "'>Stunde löschen</button></td></tr>"
        }
        html += "</tbody></table></div></div>";
        if ($("#pdf_month").val() != null && $("#pdf_month").val() != "") {
            html += "<div class='small-12 columns'><button class='button success' id='generate_pdf'>PDF aller Stunden für diesen Monat Generieren</button><br><button class='button success' id='generate_pdf_taken'>PDF aller genommenen Stunden für diesen Monat generieren</button><br><button class='button success' id='generate_pdf_given'>PDF aller gegebenen Stunden für diesen Monat generieren</button><br><button class='button alert' id='delete_all_hours'>Alle Stunden dieses Monats löschen</button><br><button class='button alert' id='delete_all_blocked_hours'>Alle blockierten Stunden dieses Monats löschen</button><br><button class='button alert' id='delete_all_finished_hours'>Alle stattgefundenen Stunden löschen</button></div>";
        }
        var val = $("#pdf_month").val();
        $("#results").empty();
        $("#results").append(html);
        $("#pdf_month").val(val);
    }, {'date': $("#pdf_month").val()});
});
$(document).on("click", "[name=deleteHour]", function (ev) {
    ev.preventDefault();
    var confirm = window.confirm("Dies löscht die Stunde unwiderruflich!");
    if (confirm) {
        runMyAjax("ajax/deleteHour.php", function (result) {
            toastr.success("Stunde gelöscht!");
            $("#" + result.id).parent().parent().remove();
        }, {'id': $(ev.target).attr('id')})
    }
});
$(document).on("click", "[name=unblockHour]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/unblockHour.php", function (result) {
        toastr.success("Stunde freigegeben!");
        $(ev.target).removeClass("alert").addClass("success");
        ev.target.text = "Freigegeben";
    }, {'id': $(ev.target).attr('id')})
});

$(document).on("click", "#generate_pdf", function (ev) {
    ev.preventDefault();
    var year = $('#pdf_month').val();
    window.location = getRootUrl() + "spdf/" + "all/" + year;
});
$(document).on("click", "#generate_pdf_taken", function (ev) {
    ev.preventDefault();
    var year = $('#pdf_month').val();
    window.location = getRootUrl() + "spdf/" + "taken/" + year;
});
$(document).on("click", "#generate_pdf_given", function (ev) {
    ev.preventDefault();
    var year = $('#pdf_month').val();
    window.location = getRootUrl() + "spdf/" + "given/" + year;
});
$(document).on("click", "#delete_all_hours", function (ev) {
    ev.preventDefault();
    var month = $("#pdf_month").val();
    runMyAjax("ajax/deleteAllHours.php", function (result) {
        toastr.success("Alle Stunden gelöscht!");
    }, {'id': month})
});
$(document).on("click", "#delete_all_blocked_hours", function (ev) {
    ev.preventDefault();
    var month = $("#pdf_month").val();
    runMyAjax("ajax/deleteBlockedHours.php", function (result) {
        toastr.success("Alle Stunden gelöscht!");
    }, {'id': month})
});
$(document).on("click", "#delete_all_finished_hours", function (ev) {
    ev.preventDefault();
    var month = $("#pdf_month").val();
    runMyAjax("ajax/deleteFinishedHours.php", function (result) {
        toastr.success("Alle Stunden gelöscht!");
    }, {'id': month})
});

$(document).on("click", "#del_user", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/getAllBlockedUsers.php", function (result) {
        var html = "<table><thead><tr><th>Benutzer</th><th>Löschen</th></tr></thead><tbody>";
        result.users.forEach(function (user) {
            html += "<tr><td>" + user.vorname + " " + user.name + "</td><td><button class='tablebutton alert' name='delete_user' id='" + user.idBenutzer + "'>Löschen</button></td></tr>";
        });
        html += "</tbody></table>";
        $("#results").empty();
        $("#results").append(html);
    });
});
$(document).on("click", "[name=delete_user]", function (ev) {
    ev.preventDefault();
    if (window.confirm("Dadurch wird der Benutzer unwiderruflich gelöscht!")) {
        runMyAjax("ajax/deleteUser.php", function (result) {
            toastr.success("Benutzer erfolgreich gelöscht!");
            $(ev.target).parent().parent().remove();
        }, {'id': $(ev.target).attr('id')});
    }
});

$(document).on("click", "#sendMail", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/SendMailTest.php", function (result) {
        toastr.success(result.hi);
    })
});

$(document).on("click", "#wantsEmails", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    if (ev.target.className.includes("success")) {
        element.removeClass("success");
        element.addClass("alert");
        element.val(false);
    }
    else {
        element.removeClass("alert");
        element.addClass("success");
        element.val(true);
    }
});
$(document).on("click", "#unblock_user", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/getAllBlockedUsers.php", function (result) {
        var html = "<table><thead><tr><th>Benutzer</th><th>Freischalten</th></tr></thead><tbody>";
        result.users.forEach(function (user) {
            html += "<tr><td>" + user.vorname + " " + user.name + "</td><td><button class='tablebutton alert' name='unblock_user_id' id='" + user.idBenutzer + "'>Freischalten</button></td></tr>";
        });
        html += "</tbody></table>";
        $("#results").empty();
        $("#results").append(html);
    })
});
$(document).on("click", "[name=unblock_user_id]", function (ev) {
    ev.preventDefault();
    if (window.confirm("Dadurch wird der Benutzer freigeschaltet!")) {
        runMyAjax("ajax/unblockUser.php", function (result) {
            toastr.success("Benutzer erfolgreich freigeschaltet!");
            $(ev.target).parent().parent().remove();
        }, {'user': $(ev.target).attr('id')});
    }
});

$(document).on("click", "#add_user", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    runMyAjax("ajax/Getters/getAllRoles.php", function (results) {
        var html = "";
        html = `<div class="row">
<form data-abide novalidate id="user-add-form" method="post">
                        <div class="small-12 medium-6 columns small-centered">
                            <br>
                            <label>Vorname
                                <input name="vorname" type="text" placeholder="Max">
                                <span class="form-error">
                                    Der Vorname ist invalid!
                                </span>
                            </label>

                            <label>Nachname
                                <input name="nachname" type="text" placeholder="Mustermann">
                                <span class="form-error">
                                    Der Nachname ist invalid!
                                </span>
                            </label>
                            
                            <label>Email
                                <input name="email" type="email" placeholder="abc@def.ghi">
                                <span class="form-error">
                                    Die Email ist invalid!
                                </span>
                            </label>
                            
                            <label>Telefonnummer
                                <input name="tel" type="tel" placeholder="012345678">
                                <span class="form-error">
                                    Die Telefonnummer ist invalid!
                                </span>
                            </label>
                            
                            <label>Passwort
                                <input name="password" type="password" placeholder="placeholder">
                                <span class="form-error">
                                    Das Passwort ist invalid!
                                </span>
                            </label>
                            
                            <label>Passwort bestätigen
                                <input name="passwordConfirm" type="password" placeholder="placeholder">
                                <span class="form-error">
                                    Das Passwort ist invalid!
                                </span>
                            </label>

                            <div class="row">
                                <div class="large-12 columns">
                                    <label>Rollen
                                        <select id="rollen" name="rollen">
                                            <option value="hallo">Keine Rolle</option>`;

        results.roles.forEach(function (role) {
            html += "<option value='" + role.idRolle + "'>" + role.name + "</option>";
        });

        html += `</select>
                                    </label>

                                    <button class="button" type="submit" value="Submit" id="add">Hinzufügen</button>
                                </div>

                            </div>
                        </div>
                        </form>
                    </div>`
        $("#results").append(html);
    });
});

$(document).on("click", "#setMaxNumberStudents", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/getMaxNumberOfStudents.php", function (result) {
        var html = "<div class='small-12-centered columns'><input type='text' placeholder='" + result.number + "' id='maxNumber' required><br><button class='button success' id='submit_maxNumberStudents' name='Submit'>Submit</button>";
        $("#results").empty();
        $("#results").append(html);
    });
});
$(document).on("click", "#submit_maxNumberStudents", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Setters/setMaxNumberOfStudents.php", function (result) {
        toastr.success("Erfolgreich gesetzt!");
    }, {'number': $("#maxNumber").val()})
});

$(document).on("click", "#setMaxNumberLessons", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/getMaxNumberOfFreeLessons.php", function (result) {
        var html = "<div class='small-12-centered columns'><input type='text' placeholder='" + result.number + "' id='maxNumber' required><br><button class='button success' id='submit_maxNumberLessons' name='Submit'>Submit</button>";
        $("#results").empty();
        $("#results").append(html);
    });
});
$(document).on("click", "#submit_maxNumberLessons", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Setters/setMaxNumberOfFreeLessons.php", function (result) {
        toastr.success("Erfolgreich gesetzt!");
    }, {'number': $("#maxNumber").val()})
});
$(document).ready(function (ev) {
    runMyAjax("ajax/Getters/needsNotification.php", function (result) {
        if (result.ja) {
            toastr.info("Du hast neue Nachrichten!");
        }
    });
});

function updateRooms() {
    runMyAjax("ajax/Getters/getFreeRooms.php", function (result) {
        if (Object.prototype.toString.call(result.raeume) === '[object Array]') {
            var idRoom = $("#idRoom");
            idRoom.empty();
            idRoom.append("<option value='no'>Nichts</option>");
            result.raeume.forEach(function (raum) {
                idRoom.append("<option value='" + raum.raumNummer + "'>" + raum.raumNummer + "</option>")
            })
        }
    }, {'date': date, 'time': time})
}

function getCurrentDate() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }

    return today = mm + '.' + dd + '.' + yyyy;
}


var userEditPasswordField = $('#user-edit-form input[name="passwort"]');

var userEditPasswordFieldSecondary = $('#user-edit-form input[name="passwort-wiederholung"]');

var userEditPasswordFieldSecondaryContainer = $('#user-edit-form label#passwort-wiederholung');

userEditPasswordField.on(
    'input',
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
