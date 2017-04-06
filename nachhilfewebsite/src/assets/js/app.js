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
    runAjaxSpecial(ajaxPath, element, success, ev){

        var formData = new FormData(document.getElementById("search-form"));

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

var authorized = false;

if(document.getElementById("login-form") == null) {
    runMyAjax("ajax/isAuthorized.php", function (results) {
        authorized = results.authorized;
        if (authorized) {
            cheet('up up down down left right left right b a', function () {
                $(document.body).append(`<div name="kill" class="error" style="position:fixed; top:50%; left:45%;z-index:999;"><p>Konami detected #FucKonami</p></div>`);
                setTimeout(kill, 10000);
                setup();
            });
        }
    });
}

var run = false;
var insane = false;
if (window.location.href.includes("insane=true") && authorized) {
    insane = true;
}
if (window.location.href.includes("setup") && authorized) {
    $(document.body).append(`<div name="kill" class="error" style="position:fixed; top:50%; left:45%;z-index:999;"><p>Konami detected #FucKonami</p></div>`);
    setTimeout(kill, 10000);
    setup();
}
if (window.location.href.includes("wubwubwub") && authorized) {
    setInterval(wubwubwub, 1);
    startYoutube("https://www.youtube.com/embed/wr15eJAGkiM");
}

function kill() {
    $("[name=kill]").remove();
    clearTimeout();
}

function setup() {
    if (run == false) {
        if ($("#bullshittery") != null) {
            $("#bullshittery").append(`<div class="small-12 medium-6 columns">
        <h1>Umweltschutz.</h1>

        <label>
            Uns liegen Tiere und Pflanzen sehr am Herzen. Da trifft es sich um so besser, dass wir dazu beitragen können,
            Deinen Papierverbrauch und den Deiner Schule deutlich zu reduzieren.
            Denn auch wenn wir alle beim Papierfliegerbasteln viel Spaß hatten, haben wir festgestellt,
            dass Papier und Druckfarben der Umwelt schaden.
            Nun ist diese Seite für deine Nachhilfeplanung zuständig!
        </label><br>
        <label>
            Darüber hinaus leisten auch wir gerne unseren Beitrag mit einem klimaneutralen Hosting unseres Angebots.
            Das bedeutet, dass entstandene Emissionen von unserem Hosting-Partner durch die Unterstützung von Projekten
            für den Klimaschutz ausgeglichen werden.
        </label>
    </div>
    <div class="small-12 medium-6 columns">
        <img src="https://farm3.static.flickr.com/2904/14598404786_f7a5f0c8b5_b.jpg">
    </div>`);
        }
    }
    if (window.location.href.includes("user") && !run) {
        startYoutube("https://www.youtube.com/embed/wjXUBG15eZ8");
    }
    else if (window.location.href.includes("suche") && !run) {
        startYoutube("https://www.youtube.com/embed/drFsXLChrWc");
    }
    else if (window.location.href.includes("termine") && !run) {
        startYoutube("https://www.youtube.com/embed/Afl9WFGJE0M");
    }
    else if (run == false || insane == true) {
        var rand = Math.floor((Math.random() * 14) + 1);
        switch (rand) {
            case 1: {
                startYoutube("https://www.youtube.com/embed/_-tF5h5WHMs");
                startBlonske("http://www.gymnasium-lohmar.org/php/kollegen/Fotos/BLN.jpg", "Blonski", "bln");
                break;
            }
            case 2: {
                startYoutube("https://www.youtube.com/embed/pdcMQjXqDMg");
                startBlonske("http://www.gymnasium-lohmar.org/php/kollegen/Fotos/BAR.jpg", "Barti", "bar");
                break;
            }
            case 3: {
                startYoutube("https://www.youtube.com/embed/j4WGWg8e_oE");
                startBlonske("http://www.gymnasium-lohmar.org/php/kollegen/Fotos/FRA.jpg", "Franki", "fra");
                break;
            }
            case 4: {
                startYoutube("https://www.youtube.com/embed/2tmc8rJgxUI");
                startBlonske("http://www.gymnasium-lohmar.org/php/kollegen/Fotos/BTL.jpg", "Hänsel und Bretl", "btl");
                break;
            }
            case 5: {
                startYoutube("https://www.youtube.com/embed/2qetI-4XvRg");
                startBlonske("http://www.gymnasium-lohmar.org/php/kollegen/Fotos/RIC.jpg", "Richter in Bernburg", "ric");
                break;
            }
            case 6: {
                startYoutube("https://www.youtube.com/embed/lcYDbPluL1g");
                startBlonske("http://www.gymnasium-lohmar.org/php/kollegen/Fotos/BGM.jpg", "Bergmann", "bgm");
                break;
            }
            case 7: {
                startYoutube("https://www.youtube.com/embed/iILl1CyKYaA");
                startBlonske("http://bilder1.n-tv.de/img/incoming/crop19692704/9974992653-cImg_16_9-w680/Der-designierte-SPD-Kanzlerkandidat-Martin-Schulz-blickt-am-07.jpg", "Schulz", "schulz");
                break;
            }
            case 8: {
                startYoutube("https://www.youtube.com/embed/epNbV-bx2L0");
                startBlonske("https://i.redd.it/jy0usj55fl0y.jpg", "Kepetry", "kpt");
                break;
            }
            case 9: {
                startYoutube("https://www.youtube.com/embed/u9Dg-g7t2l4");
                break;
            }
            case 10: {
                startYoutube("https://www.youtube.com/embed/-iiAtLFkVps");
                break;
            }
            case 11: {
                startYoutube("https://www.youtube.com/embed/QwhPOlIuSXM");
                break;
            }
            case 12: {
                startYoutube("https://www.youtube.com/embed/g4LofIXbvrM");
                break;
            }
            case 13: {
                startYoutube("https://www.youtube.com/embed/reOLeLX0Q9U");
                break;

            }
            case 14: {
                startYoutube("https://www.youtube.com/embed/Bqfk7oBMsW4");
                break;
            }
        }
        run = true;
    }
    else if (run == true && insane == false) {
        if (window.location.href.includes("setup")) {
            window.location.reload();
        }
        else {
            window.location.replace(window.location + "&setup");
        }
    }
}
function startBlonske(src, name, id) {
    var rand = Math.random();
    $(document.body).append(`<div name="blonski` + rand + `" style="position:fixed; top:50%; left:0px"><img src="` + src + `" alt="` + name + `"></div>`);
    animateDiv("blonski" + rand);
}

function startYoutube(src) {
    var rand = Math.random();
    $(document.body).append(`<div style="position:fixed;top:25%;left:0px" name="bull` + rand + `"><iframe id="holz" width="560" height="315" src="` + src + `?autoplay=1&loop=1&vq=small&enablejsapi=1rel=0&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe></div>`)
    animateDiv("bull" + rand);
}

function makeNewPosition(element) {

    // Get viewport dimensions (remove the dimension of the div)
    var h = $(window).height() - element.clientHeight;
    var w = $(window).width() - element.clientWidth;

    var nh = Math.floor(Math.random() * h);
    var nw = Math.floor(Math.random() * w);

    return [nh, nw];

}

function animateDiv(elementName) {
    var elements = document.getElementsByName(elementName);
    if (isNodeList(elements)) {
        Array.from(elements).forEach(function (element) {
            var newq = makeNewPosition(element);
            var oldq = $(element).offset();
            var speed = calcSpeed([oldq.top, oldq.left], newq);
            $(element).animate({top: newq[0], left: newq[1]}, speed, function () {
                animateDiv(elementName);
            });
        })
    }
    else {
        var newq = makeNewPosition();
        var oldq = $(elements).offset();
        var speed = calcSpeed([oldq.top, oldq.left], newq);
        $(elements).animate({top: newq[0], left: newq[1]}, speed, function () {
            animateDiv();
        });
    }
};

function calcSpeed(prev, next) {

    var x = Math.abs(prev[1] - next[1]);
    var y = Math.abs(prev[0] - next[0]);

    var greatest = x > y ? x : y;

    var speedModifier = 0.1;

    var speed = Math.ceil(greatest / speedModifier);

    return speed;

}

function wubwubwub() {
    var color = rainbow(1000, Math.floor((Math.random() * 1000) + 0));
    var random = Math.floor((Math.random() * 2) + 0);
    if (random == 0) {
        var elements = document.getElementsByTagName("*");
        var rand = Math.floor((Math.random() * elements.length) + 0);
        if (elements[rand].name != "blonski") {
            elements[rand].style.backgroundColor = color;
        }
    }
    else {
        document.body.style.backgroundColor = color;
    }
}

// the horizontal displacement
var deltaX = 1;
var qCounter = 0;
function quake() {
    // make sure the browser support the moveBy method
    if (window.moveBy) {
        // shake left
        if ((qCounter % 4) == 0) {
            window.moveBy(deltaX, 0);
        }
        // shake right
        else if ((qCounter % 4) == 2) {
            window.moveBy(-deltaX, 0);
        }
        qCounter++;
    }
    else {
        console.log("hi");
    }
}

function rainbow(numOfSteps, step) {
    // This function generates vibrant, "evenly spaced" colours (i.e. no clustering). This is ideal for creating easily distinguishable vibrant markers in Google Maps and other apps.
    // Adam Cole, 2011-Sept-14
    // HSV to RBG adapted from: http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript
    var r, g, b;
    var h = step / numOfSteps;
    var i = ~~(h * 6);
    var f = h * 6 - i;
    var q = 1 - f;
    switch (i % 6) {
        case 0:
            r = 1;
            g = f;
            b = 0;
            break;
        case 1:
            r = q;
            g = 1;
            b = 0;
            break;
        case 2:
            r = 0;
            g = 1;
            b = f;
            break;
        case 3:
            r = 0;
            g = q;
            b = 1;
            break;
        case 4:
            r = f;
            g = 0;
            b = 1;
            break;
        case 5:
            r = 1;
            g = 0;
            b = q;
            break;
    }
    var c = "#" + ("00" + (~~(r * 255)).toString(16)).slice(-2) + ("00" + (~~(g * 255)).toString(16)).slice(-2) + ("00" + (~~(b * 255)).toString(16)).slice(-2);
    return (c);
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
    }, {'vorname' : $("[name=vorname]").val(), 'nachname' : $("[name=nachname]").val(), 'tel' : $("[name=tel]").val(), 'passwort' : $("[name=password]").val(), 'passwortConfirm' : $("[name=passwordConfirm]").val(), 'email' : $("[name=email]").val(), 'rollen' : $("[name=rollen]").val()})
});

var loginFormHelper = new AjaxFormHelper($("#login-form"), "Login fehlgeschlagen!", "ajax/Forms/loginForm.php", function (result) {
    location.reload();
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

var appointmentFormHelper = new AjaxFormHelperSpecial($("#appointment-form"), "Termin nicht hinzufügbar!", "ajax/Forms/appointmentForm.php", function (result) {
    toastr.success("Termin erfolgreich hinzugefügt!");
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

    $.each(faecher, function (i, fach) {
        if ($(fach).hasClass("warning")) {
            selectedFaecher.push($(fach).attr('id'));
        }
        else if ($(fach).hasClass("firstConnection")) {
            firstConnection = $(fach).attr('id');
        }
    });

    runMyAjax("ajax/nachhilfeAnfrage.php", function (result) {

        toastr.success("Anfrage gesendet!");
        selectedFaecher.forEach(function (fache) {
            var parent = $("#" + fache).parent();
            var fachen = $("#" + fache).text();
            parent.empty();
            parent.append("<div class='data-label secondary'><p class='center'>" + fachen + "</p></div>")
        });
        if (firstConnection != null) {
            var parent = $("#" + firstConnection).parent();
            var fachen = $("#" + firstConnection).text();
            parent.empty();
            parent.append("<div class='data-label firstRequest'><p class='center'>" + fachen + "</p></div>")
        }
    }, {'user': $("#user_to_show").val(), 'faecher': selectedFaecher, 'first': firstConnection})
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
        if ($("#" + element.attr('id') + "connection").val() == false) {
            if ($("#" + element.attr('id') + "anfrage").val() == false) {
                element.removeClass("warning");
                element.addClass("firstConnection");
            }
            else {
                element.removeClass("warning");
                element.addClass("success");
            }
        }
        else {
            element.removeClass("warning");
            element.addClass("success");
        }
    }
    else {
        element.removeClass("firstConnection");
        element.addClass("success");
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
        var html = "<div class='row'><div class='small-6 columns'><input type='text' id='filter'></div></div><table class='hover'><thead><tr><th>Lehrer</th><th>Schüler</th><th>Fach</th><th>Löschen</th></tr></thead><tbody id='connections'>";
        result.data.forEach(function (data) {
            html += "<tr><td>" + data.lehrerVorname + " " + data.lehrerName + "</td><td>" + data.nehmerVorname + " " + data.nehmerName + "</td><td>" + data.fachName + "</td><td><button class='tablebutton alert' id='" + data.idVerbindung + "' name='deleteConny'</td>Löschen</tr>";
        });
        html += "</tbody></table>";
        $('#results').append(html);
        $rows = $("#connections tr");
        var i = 0;
        $.each($rows, function () {
            rowsTextArray[i] = $(ev.target).text().replace(/\s+/g, ' ').toLowerCase();
            i++;
        });
    });
});
$(document).on('keyup', "#filter", function () {
    var val = $.trim($("#filter").val()).replace(/ +/g, ' ').toLowerCase();
    if (typeof $rows !== 'undefined') {
        $rows.show().filter(function (index) {
            return (rowsTextArray[index].indexOf(val) === -1);
        }).hide();
    }
});

$(document).on("click", "[name=deleteConny]", function (ev) {
    ev.preventDefault();
    runMyAjax("ajax/deleteConnection.php", function (result) {
        toastr.success("Verbindung gelöscht!");
        $(ev.target).removeClass("alert").addClass("success");
        ev.target.text = "Gelöscht";
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

$(document).on("change", "#idUser", function (ev) {
    ev.preventDefault();
    var subjects = $("#idSubject");
    if ($(ev.target).val() == "no" && subjects.val() == "no") {
        runMyAjax("ajax/Getters/getAllSubjects.php", function (result) {
            subjects.empty();
            subjects.append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    subjects.append("<option value='" + subject['idFach'] + "'>" + subject['name'] + "</option>");
                });
            }
        });
        runMyAjax("ajax/Getters/getAllConnectionUsers.php", function (result) {
            $(ev.target).empty();
            $(ev.target).append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.users) === '[object Array]') {
                result.users.forEach(function (user) {
                    $(ev.target).append("<option value='" + user['ID'] + "'>" + user['vorname'] + " " + user['name'] + "</option>");
                });
            }
        });
    }
    else if ($(ev.target).val() != "no" && subjects.val() == "no") {
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            subjects.empty();
            subjects.append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    subjects.append("<option value='" + subject['idFach'] + "'>" + subject['name'] + "</option>");
                });
            }
        }, {'user': $(ev.target).val()});
    }
    else if (subjects.val() != "no" && $(ev.target).val() == "no") {
        runMyAjax("ajax/Getters/getUsersBySubject.php", function (result) {
            $(ev.target).empty();
            $(ev.target).append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.users) === '[object Array]') {
                result.users.forEach(function (user) {
                    $(ev.target).append("<option value='" + user['ID'] + "'>" + user['vorname'] + " " + user['name'] + "</option>");
                });
            }
        }, {'fach': subjects.val()});
        runMyAjax("ajax/Getters/getAllSubjects.php", function (result) {
            var idFach = subjects.val();
            subjects.empty();
            subjects.append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    var html = "<option value='" + subject['idFach'] + "'";
                    if (subject['idFach'] == idFach) {
                        html += " selected ";
                    }
                    html += ">" + subject['name'] + "</option>";
                    subjects.append(html);
                });
            }
        });
    }
    else if (subjects.val() != "no" && $(ev.target).val() != "no") {
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = subjects.val();
            subjects.empty();
            subjects.append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    var html = "<option value='" + subject['idFach'] + "'";
                    if (subject['idFach'] == idFach) {
                        html += " selected ";
                    }
                    html += ">" + subject['name'] + "</option>";
                    subjects.append(html);
                });
            }
        }, {'user': $(ev.target).val()})
    }
});
$(document).on("change", "#idSubject", function (ev) {
    ev.preventDefault();
    var users = $("#idUser");
    if (users.val() == "no" && $(ev.target).val() != "no") {
        runMyAjax("ajax/Getters/getUsersBySubject.php", function (result) {
            users.empty();
            users.append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.users) === '[object Array]') {
                result.users.forEach(function (user) {
                    users.append("<option value='" + user['ID'] + "'>" + user['vorname'] + " " + user['name'] + "</option>");
                });
            }
        }, {'fach': $(ev.target).val()});
    }
    else if (users.val() == "no" && $(ev.target).val() == "no") {
        runMyAjax("ajax/Getters/getAllConnectionUsers.php", function (result) {
            users.empty();
            users.append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.users) === '[object Array]') {
                result.users.forEach(function (user) {
                    users.append("<option value='" + user['ID'] + "'>" + user['vorname'] + " " + user['name'] + "</option>");
                });
            }
        });
        runMyAjax("ajax/Getters/getAllSubjects.php", function (result) {
            $(ev.target).empty();
            $(ev.target).append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    $(ev.target).append("<option value='" + subject['idFach'] + "'>" + subject['name'] + "</option>");
                });
            }
        });
    }
    else if ($(ev.target).val() == "no" && users.val() != "no") {
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = $(ev.target).val();
            $(ev.target).empty();
            $(ev.target).append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    var html = "<option value='" + subject['idFach'] + "'";
                    if (subject['idFach'] == idFach) {
                        html += " selected ";
                    }
                    html += ">" + subject['name'] + "</option>";
                    $(ev.target).append(html);
                });
            }
        }, {'user': users.val()})
    }
    else if (users.val() != "no" && $(ev.target).val() != "no") {
        runMyAjax("ajax/Getters/getOfferedSubjects.php", function (result) {
            var idFach = $(ev.target).val();
            $(ev.target).empty();
            $(ev.target).append("<option value='no'>Nichts</option>");
            if (Object.prototype.toString.call(result.subjects) === '[object Array]') {
                result.subjects.forEach(function (subject) {
                    var html = "<option value='" + subject['idFach'] + "'";
                    if (subject['idFach'] == idFach) {
                        html += " selected ";
                    }
                    html += ">" + subject['name'] + "</option>";
                    $(ev.target).append(html);
                });
            }
        }, {'user': users.val()})
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
        var html = "<div class='small-12-centered columns'><input type='month' id='pdf_month'><br><button class='button success' id='submit_pdf_month'>Submit</button></div><div class='small-12 columns result-boxes'><div class='result-boxes-inner search'><table><thead><tr><th>Schüler</th><th>Lehrer</th><th>Datum</th><th>Stattgefunden</th><th>Verbindung Blockiert</th><th>Stunde löschen</th></tr></thead><tbody>";
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
                    html += "<p class='alert'>Verbindung blockiert</p>";
                }
                else {
                    html += "<p class='success'>Verbindung nicht blockiert</p>";
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
            else if (hours.akzeptiert == -1) {
                html += "<p class='alert'>Stunde wurde blockiert</p>";
            }
            else {
                html += "<p class='alert'>Stunde weder akzeptiert noch stattgefunden</p>";
            }
            if (hours.blockiert == 1) {
                html += "<p class='alert'>Verbindung blockiert</p>";
            }
            else {
                html += "<p class='success'>Verbindung nicht blockiert</p>";
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
