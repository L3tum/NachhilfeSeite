/**
 * Created by Tom on 02.05.2017.
 */
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
    if(FormData.set) {
        formdata.set("passwort", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
        formdata.set("passwort-wiederholung", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
    }
    else{
        formdata.append("passwort", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
        formdata.append("passwort-wiederholung", murmurhash3_32_gc($("[name=passwort]").val(), 2476));
    }
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