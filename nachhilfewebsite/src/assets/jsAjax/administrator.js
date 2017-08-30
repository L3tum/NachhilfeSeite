/**
 * Created by Tom on 01.05.2017.
 */

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
        var html = "<table class='hover'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Fach</th><th>Löschen</th></tr></thead><tbody id='connections'>";
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.fachName + "</td>";
            html += "<td><button class='tablebutton alert' id='" + data.idVerbindung + "' name='deleteConny'>Löschen</button></td></tr>";
        });
        html += "</tbody></table>";
        $('#results').append(html);
    });
});

$(document).on("click", "[name=deleteConny]", function (ev) {
    ev.preventDefault();
    if (window.confirm("Alle Stunden und diese Verbindung werden unwiderruflich gelöscht! Fortfahren?")) {
        runMyAjax("ajax/deleteConnection.php", function (result) {
            toastr.success("Verbindung gelöscht!");
            $(ev.target).removeClass("alert").addClass("success");
            ev.target.text = "Gelöscht";
        }, {'id': $(ev.target).attr('id')})
    }
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
    if (window.confirm("Dadurch wird das Fach, alle Verbindungen und alle Stunden für dieses Fach gelöscht! Fortfahren?")) {
        runMyAjax("ajax/deleteSubject.php", function (result) {
            toastr.success("Fach gelöscht!");
            $("#" + result.id).remove();
        }, {'id': $("#sel_subject").find(':selected').attr('id')})
    }
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

$(document).on("click", "#show_all_hours", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    var html = "<div class='small-12-centered columns'><input type='month' id='pdf_month'><br><button class='button success' id='submit_pdf_month'>Submit</button></div>";
    $("#results").append(html);
});
$(document).on("click", "#submit_pdf_month", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/getAllHours.php", function (result) {
        var html = "<div class='small-12-centered columns'><input type='month' id='pdf_month'><br><button class='button success' id='submit_pdf_month'>Submit</button></div><div class='small-12 columns result-boxes'><div class='result-boxes-inner search'><table><thead><tr><th>Schüler</th><th>Lehrer</th><th>Datum</th><th>Stattgefunden</th><th>Stunde löschen</th></tr></thead><tbody>";
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
                else {
                    html += "<p class='alert'>Stunde weder akzeptiert noch stattgefunden</p>";
                }
                html += "</td>";
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
            else {
                html += "<p class='alert'>Stunde weder akzeptiert noch stattgefunden</p>";
            }
            html += "</td>";
            html += "<td><button class='tablebutton alert' name='deleteHour' id='" + hours.idStunde + "'>Stunde löschen</button></td></tr>"
        }
        html += "</tbody></table></div></div>";
        if ($("#pdf_month").val() != null && $("#pdf_month").val() != "") {
            html += "<div class='small-12 columns'><button class='button success' id='generate_pdf'>PDF aller Stunden für diesen Monat Generieren</button><br><button class='button success' id='generate_pdf_taken'>PDF aller genommenen Stunden für diesen Monat generieren</button><br><button class='button success' id='generate_pdf_given'>PDF aller gegebenen Stunden für diesen Monat generieren</button><br><button class='button alert' id='delete_all_hours'>Alle Stunden dieses Monats löschen</button><br><button class='button alert' id='delete_all_finished_hours'>Alle stattgefundenen Stunden löschen</button></div>";
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

$(document).on("click", "#set_settings", function (ev) {
    ev.preventDefault();
    $("#results").empty();
    runMyAjax("ajax/Getters/getSettings.php", function (result) {

        result.settings.forEach(function (setting) {
            $("#results").append("<div class='small-12-centered columns'><label>" + setting.name + "<input name='setting_id' type='text' placeholder='" + setting.current + "' id='" + setting.name + "'></label></div>");
        });
        $("#results").append("<div class='small-12-centered columns'><button class='button success' id='update_settings'>Update Settings</button></div>")
    })
});
$(document).on("click", "#update_settings", function (ev) {
    ev.preventDefault();
    var names = new Array();
    var values = new Array();
    var settings = $("[name=setting_id]");
    var i = 0;
    settings.each(function (integer, setting) {
        if ($(setting).val() != "") {
            names[i] = $(setting).attr('id');
            values[i] = $(setting).val();
            i++;
        }
    });
    runMyAjax("ajax/Setters/setSettings.php", function (results) {
        toastr.success("Einstellungen erfolgreich aktualisiert!");
        $("#results").empty();
        runMyAjax("ajax/Getters/getSettings.php", function (result) {

            result.settings.forEach(function (setting) {
                $("#results").append("<div class='small-12-centered columns'><label>" + setting.name + "<input name='setting_id' type='text' placeholder='" + setting.current + "' id='" + setting.name + "'></label></div>");
            });
            $("#results").append("<div class='small-12-centered columns'><button class='button success' id='update_settings'>Update Settings</button></div>")
        })
    }, {'names': names, 'values': values})
});

$(document).on("click", "#add_setting", function (ev) {
    ev.preventDefault();
    $("#results").empty();

    $("#results").append("<div class='small-12-centered columns'><input name='setting_name' type='text' placeholder='Name...' id='setting_name'><br><input name='setting_value' type='text' placeholder='Wert...' id='setting_value'></div>");
    $("#results").append("<div class='small-12-centered columns'><button class='button success' id='insert_setting'>Füge Einstellung ein</button></div>")
});
$(document).on("click", "#insert_setting", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Setters/setSetting.php", function (result) {
        toastr.success("Einstellung erfolgreich hinzugefügt!");
    }, {'name': $("#setting_name").val(), 'value': $("#setting_value").val()})
});
$(document).on("click", "#exec_sql", function (ev) {
    ev.preventDefault();
    var html = "<div class='small-12-centered columns'><input name='sql' type='text' id='sql'><br><button class='button success' id='execute_sql'>Führe SQL aus</button></div>";
    $("#results").append(html);
});
$(document).on("click", "#execute_sql", function (ev) {
    ev.preventDefault();
    var sql = $("#sql").val();
    runMyAjax("ajax/runSQL.php", function(result){
        toastr.success("Erfolgreich ausgeführt!");
    }, {'sql' : sql});
});
