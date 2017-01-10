//Class that takes an element (form), and sends an ajax request if the form is valid (if it's not valid display invalidError). When the ajax
//responds with an error message, also display it. When the ajax succeeds call success with the send data as a parameter.
//If anything else than the form should get attached to the formData object, add something to the formDataAppend method. (files for ex.)
class AjaxFormHelper {

    constructor(element, invalidError, ajaxPath, success, formDataAppend = 0) {

        var $me = this;
        console.log(element);
        if(element[0] != null) {
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



class AjaxDynamicFormHelper {

    constructor(element, ajaxPath, success, formDataAppend = 0) {

        var $me = this;
        $(document)
            .on("submit", element, function (ev) {
                if(element.length != 0) {
                    ev.preventDefault();
                    $me.runAjax(ajaxPath, element, success, formDataAppend);
                }

            });
        //No formvalid as it is not working for some reason
    }

    //sends the actual ajax request
    runAjax(ajaxPath, element, success, formDataAppend) {

        var formData = new FormData();
        formData.append('vorname', document.getElementsByName("vorname")[0].value);
        formData.append('nachname', document.getElementsByName("nachname")[0].value);
        formData.append('email', document.getElementsByName("email")[0].value);
        formData.append('rolle', document.getElementById('rollen').value);

        document.getElementsByName("vorname")[0].value = "";
        document.getElementsByName("nachname")[0].value = "";
        document.getElementsByName("email")[0].value = "";
        document.getElementById('rollen').value = 0;

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
        for (var i = 0; i < faecher.length; i++) {
            if (faecher[i].value == "true") {
                selectedFaecher.push(faecher[i].attributes[1].nodeValue);
            }
        }
        data = {'user': $("#user_to_show").val(), 'faecher': selectedFaecher};
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
        });
    }
}
class AjaxFormHelperNachhilfeFach {

    constructor() {
        var $me = this;
        $('[name=fachButton]').on("click", function (ev) {
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

class AjaxFormHelperRolleRecht{
    constructor(){
        var $me = this;
        $('[name=rollenButton]').on("click", function(ev){
            ev.preventDefault();
            $me.runNow(ev.target);
        })
    }
    runNow(element){
        if(element.className.includes("success")){
            element.className = "tablebutton alert";
        }
        else{
            element.className = "tablebutton success";
        }
    }
}

class AjaxFormHelperRolle{
    constructor(element, invalidError, ajaxPath, success, formDataAppend = 0) {
        var $me = this;
        element.on("submit", function (ev) {
            ev.preventDefault();
        }).on("forminvalid.zf.abide", function (ev) {
            toastr.error(invalidError);
        }).on("formvalid.zf.abide", function(ev){
            ev.preventDefault();
            $me.runAjaxRolle(ajaxPath, element, success, formDataAppend);
        })
    }
    runAjaxRolle(ajaxPath, element, success, formDataAppend){
        var rollen = $("[name=rollenButton]");

    }
}

function runMyAjax(ajaxPath, success, data = 0) {
    $.ajax({
        url: getRootUrl() + ajaxPath,
        dataType: 'json',
        type: "POST",
        data: data,
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

var sendMessageFormHelper = new AjaxFormHelper($("#send-message-form"), "Senden fehlgeschlagen!", "ajax/sendMessage.php", function (result) {
    toastr.success("Nachricht gesendet!");
    location.reload();
});

var requestResponseFormHelper = new AjaxFormHelper($("#request-response-form"), "Senden fehlgeschlagen!", "ajax/requestResponse.php", function (result) {
    toastr.success("Nachricht gesendet!");
    location.reload();
}, function(formData) {
    var $btn = $(document.activeElement);
    formData.append('response', $btn.attr('value'))

});



var searchFormHelper = new AjaxFormHelper($("#search-form"), "Suche fehlgeschlagen!", "ajax/searchForm.php", function (result) {
    toastr.success("Suche erfolgreich!");
    $("#search-results").empty();

    if (result.users.length == 0) {
        $("#search-results").append(
            "<div class='result-box'><div class='row no-padding left'><div class='small-8-centered columns'><div class='row no-padding right'><div class='small-12-centered columns notification-header no-padding align-center text-center'><p>Kein Nutzer gefunden!</p></div><div class='small-12 columns no-padding right'>  </div></div></div> <div class='small-4 columns no-padding both'> <div class='button-group medium '> </div> </div> </div> </div>"
        );
    }
    else {
        var root = getRootUrl();
        var permission;
        runMyAjax("ajax/getPermissionUser.php", function(result){
            permission = result.permission;
        }, {'permission':'blockUser'});
        var html = "<table><thead><tr><th>Benutzer</th><th>Profil</th>";
        if(permission){
            html += "<th>Sperren</th></thead><tbody>";
        }
        else{
            html += "</th></thead><tbody>";
        }
        result.users.forEach(function (entry) {
            $("#search-results").append(
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

$(document).on("click", "a[name=blockUserNow]", function(result){

}, {'user' : $(this).attr('id')});

var nachhilfeAnfrage = new AjaxFormHelperNachhilfeAnfrage($("#nachhilfeAnfragenButton"), "Anfrage fehlgeschlagen!", "ajax/nachhilfeAnfrage.php", function (result) {
    toastr.success("Anfrage erfolgreich!");
});

var nachhilfeAnfrageFach = new AjaxFormHelperNachhilfeFach();

var registerFormHelper = new AjaxDynamicFormHelper($('#register-form'), "ajax/registerUser.php", function (result) {
    toastr.success(result.name + " wurde erfolgreich registriert!");
});

//Button listeners
$('#register_new_user').off("click").on("click", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    runMyAjax("ajax/getRollen.php", function (result) {
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

$("#show_roles").off("click").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();

    runMyAjax("ajax/getRollen.php", function (result) {
            var html = "";
            result.rollen.forEach(function (rolle) {
                html += `<div class="row">
<div class="small-12 columns">
<div class="small-10-centered columns data-label">
                        <div class="small-8 columns">
                            <p class='center'>${rolle.name}</p>
                             </div>
                                <div class="small-2 columns">
                                    <a href="${getRootUrl() + 'role/' + rolle.idRolle + '/view'}" class="labelled warning" value="${rolle.idRolle}" name="roleChange">Anzeigen</a>
                                </div>
                                <div class="small-2 columns">
                                    <a class="labelled alter" value="${rolle.idRolle}" name="roleDel">Löschen</a>
                                    </div>
</div></div></div>`;
            });
            $("#results").append(html);
        }
    );
});

var rowsTextArray = [];
var $rows;
$("#show_connections").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();
    runMyAjax("ajax/getConnectionsWithNames.php", function (result) {
        var html = "<div class='row'><div class='small-6 columns'><input type='text' id='filter'></div></div><table class='hover'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Fach</th></tr></thead><tbody id='connections'>";
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.fachName + "</td></tr>";
        });
        html += "</tbody></table>";
        $('#results').append(html);
        $rows = $("#connections tr");
        var i = 0;
        $.each($rows, function () {
            rowsTextArray[i] = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            i++;
        });
    });
});
$(document).on('keyup', $("#filter"), function () {
    var val = $.trim($("#filter").val()).replace(/ +/g, ' ').toLowerCase();
    if (typeof $rows !== 'undefined') {
        $rows.show().filter(function (index) {
            return (rowsTextArray[index].indexOf(val) === -1);
        }).hide();
    }
});

$("#show_pending_hours").on("click", function (ev) {
    ev.preventDefault();
    $('#results').empty();
    runMyAjax("ajax/getPendingHours.php", function (result) {
        var html = "<table class='hover'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Datum</th><th>Raum</th></tr></thead><tbody>";
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.datum + "</td><td>" + data.raumNummer + "</td></tr>";
        });
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
        var parent = $("a[name='confirm_payment_admin']").parent();
        parent.empty();
        parent.append("<p class='text-center success'>Bezahlt</p>");
    }, {'idStunde': $("a[name='confirm_payment_admin']").attr('id')});
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
    runMyAjax("ajax/getFreeRooms.php", function (result) {
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
    runMyAjax("ajax/getTakenRooms.php", function (result) {
        var html = `<div class="small-12-centered columns"><table id='taken_rooms_table'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Datum</th><th>Raum</th></tr></thead><tbody>`;
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName +"</td><td>" + data.datum + "</td><td>" + data.raumNummer + "</td></tr>"
        });
        html += "</tbody></table></div>";
        $("#rooms").append(html);
    }, {'date': $("#datePickerTaken").val(), 'time': $("#timePickerTaken").val() + ":00"});
});

$("#show_complaints").on("click", function(ev){
    ev.preventDefault();
    $("#results").empty();
    runMyAjax("ajax/getComplaints.php", function(result){
        var html = `<div class="small-12-centered columns"><table id='taken_rooms_table'><thead><tr><th>Gegen</th><th>Von</th><th>Grund</th><th>Löschen</th></tr></thead><tbody>`;
        var i = 0;
        result.data.forEach(function(data){
           html += "<tr><td>" + data.gegenVorname + " " + data.gegenName + "</td><td>" + data.vonVorname + " " + data.vonName + "</td><td>" + data.grund + "</td><td><button class='tablebutton alert' name='deleteBeschwerde' value='" + data.gegenID + "," + data.vonID + "' id='" + i + "'>Löschen</button></td></tr>"
            i++;
        });
        html += "</tbody></table></div>";
        $('#results').append(html);
    });
});

$(document).on("click", 'button[name=deleteBeschwerde]', function(ev){
    ev.preventDefault();
    runMyAjax("ajax/deleteComplaint.php", function(result){
        toastr.success("Beschwerde gelöscht!");
        var parent = $("#" + result.id).parent();
        parent.empty();
        parent.append("<p class='success'>Gelöscht!</p>");
    }, {'ID':$(this).attr('id'), 'IDs' : $(this).val()});
});

var editRoleFormHelper = new AjaxFormHelper("#role-edit-form", "Rolle nicht editierbar!", "ajax/editRoleForm.php", function(result){
    toastr.success("Rolle erfolgreich editiert!");
});



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
