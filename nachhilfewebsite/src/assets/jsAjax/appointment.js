/**
 * Created by Tom on 02.05.2017.
 */

$(document).on("submit", "#appointment-form", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/Getters/isFreeLessonsAndHasFreeHours.php", function (result) {
        if (result.isFirst && !result.hasFree) {
            var results = window.confirm("Du hast bereits dein wöchentliches Kontingent ausgeschöpft und müsstest diese Stunde bezahlen! Fortfahren?");
            if (results) {
                var formData = new FormData(ev.target);
                formData.append("hasToPay", true);
                runMyAjaxFormData("ajax/Forms/appointmentForm.php", function (result) {
                    toastr.success("Termin erfolgreich hinzugefügt!");
                }, formData);
            }
        }
        else if (result.isFirst && result.hasFree) {
            var formData = new FormData(ev.target);
            formData.append("hasToPay", false);
            runMyAjaxFormData("ajax/Forms/appointmentForm.php", function (result) {
                toastr.success("Termin erfolgreich hinzugefügt!");
            }, formData);
        }
        else {
            var formData = new FormData(ev.target);
            formData.append("hasToPay", true);
            runMyAjaxFormData("ajax/Forms/appointmentForm.php", function (result) {
                toastr.success("Termin erfolgreich hinzugefügt!");
            }, formData);
        }
    }, {'idUser': $("#idUser").val(), 'idSubject': $("#idSubject").val(), 'datetime_app': $("#datetime_app").val()})
});

function updateBenutzer(array, jQueryObject, selected = null) {
    jQueryObject.empty();
    jQueryObject.append("<option value='no'>Nichts</option>");
    if (array != false) {
        array.forEach(function (arr) {
            if (selected != null && selected == arr['ID']) {
                jQueryObject.append("<option value='" + arr['ID'] + "' selected>" + arr['vorname'] + " " + arr['name'] + "</option>");
            }
            else {
                jQueryObject.append("<option value='" + arr['ID'] + "'>" + arr['vorname'] + " " + arr['name'] + "</option>");
            }
        })
    }
}
function updateFaecher(array, jQueryObject, selected = null) {
    jQueryObject.empty();
    jQueryObject.append("<option value='no'>Nichts</option>");
    if (array != false) {
        array.forEach(function (arr) {
            if (selected != null && selected == arr['idFach']) {
                if (arr['kostenfrei'] == 1) {
                    jQueryObject.append("<option class='firstConnection' value='" + arr['idFach'] + "' selected>" + arr['name'] + "</option>");
                }
                else {
                    jQueryObject.append("<option value='" + arr['idFach'] + "' selected>" + arr['name'] + "</option>");
                }
            }
            else {
                if (arr['kostenfrei'] == 1) {
                    jQueryObject.append("<option class='firstConnection' value='" + arr['idFach'] + "'>" + arr['name'] + "</option>");
                }
                else {
                    jQueryObject.append("<option value='" + arr['idFach'] + "'>" + arr['name'] + "</option>");
                }
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
            updateFaecher(result.subjects, subjects);
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
            updateFaecher(result.subjects, subjects);
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
            updateFaecher(result.subjects, subjects, idFach);
        });
    }
    //Benutzer wurde ausgewählt und Fach war ausgewählt
    else if (subjects.val() != "no" && $(ev.target).val() != "no") {
        //Update Fächer und wähle das ausgewählte Fach aus
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = subjects.val();
            updateFaecher(result.subjects, subjects, idFach);
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
            updateFaecher(result.subjects, $(ev.target), idFach);
        }, {'user': users.val()});

        //Update Benutzer und selecte den ausgewählten
        var idBenutzer = users.val();
        runMyAjax("ajax/Getters/getAllConnectionUsers.php", function (result) {
            updateBenutzer(result.users, users, idBenutzer);
        });
    }
    //Fach wurde ausgewählt und Benutzer war ausgewählt
    else if (users.val() != "no" && $(ev.target).val() != "no") {
        //Update Fächer und selecte ausgewähltes
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = $(ev.target).val();
            updateFaecher(result.subjects, $(ev.target), idFach);
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