/**
 * Created by Tom on 02.05.2017.
 */

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

$(document).on("click", "[name=refuseButton]", function (ev) {
    ev.preventDefault();
    var element = $(ev.target);
    runMyAjax("ajax/deleteRequest.php", function (result) {
        element.parent().parent().remove();
        toastr.success("Termin abgelehnt!");
    }, {'id': element.attr('id')});
});
