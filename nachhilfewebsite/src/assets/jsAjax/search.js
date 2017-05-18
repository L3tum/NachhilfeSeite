/**
 * Created by Tom on 02.05.2017.
 */
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
