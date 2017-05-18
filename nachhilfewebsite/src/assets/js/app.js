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

function runMyAjaxFormData(ajaxPath, success, data = 0) {

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

function getScript(url, options = new Array()) {
    // Allow user to set any option except for dataType, cache, and url
    options = $.extend(options || {}, {
        dataType: "script",
        cache: true,
        url: getRootUrl() + url
    });

    // Use $.ajax() since it is more flexible than $.getScript
    // Return the jqXHR object so we can chain callbacks
    return $.ajax(options);
}

//Script loading
class ScriptLoader {
    constructor() {
        this.urls = new Array();
        this.integer = 0;
    }

    registerUrl(urlPart, ajaxPath, success = function () {
        console.info(urlPart + " loaded!");
    }, error = function (jqxhr, settings, exception) {
        console.error(exception)
    }) {
        this.urls[this.integer] = new Array();
        this.urls[this.integer]['url'] = urlPart;
        this.urls[this.integer]['ajaxPath'] = ajaxPath;
        this.urls[this.integer]['success'] = success;
        this.urls[this.integer]['error'] = error;
        this.integer++;
    }

    check() {
        var root = location.host;
        var arrelement = this.urls.find(function (element) {
            var re = new RegExp(root + "/" + element['url']);
            if (re.test(location.href)) {
                return element;
            }
        });
        if (arrelement != null) {
            this.getScript(arrelement['ajaxPath']).done(arrelement['success']).fail(arrelement['error']);
        }
    }

    getScript(url, options = new Array()) {
        // Allow user to set any option except for dataType, cache, and url
        options = $.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: getRootUrl() + url
        });

        // Use $.ajax() since it is more flexible than $.getScript
        // Return the jqXHR object so we can chain callbacks
        return $.ajax(options);
    };
}

getScript("assets/jsAjax/formHelpers.js").done(function () {
    console.info("General stuff loaded!");
}).fail(function (jqxhr, settings, exception) {
    console.error(exception)
});

var scriptLoader = new ScriptLoader();
scriptLoader.registerUrl("admin", "assets/jsAjax/administrator.js");
scriptLoader.registerUrl("chatMessagesTo", "assets/jsAjax/chatmessages.js");
scriptLoader.registerUrl("suche", "assets/jsAjax/search.js");
scriptLoader.registerUrl("user\/[0-9]*\/view", "assets/jsAjax/showUser.js");
scriptLoader.registerUrl("user\/[0-9]*\/edit", "assets/jsAjax/editUser.js");
scriptLoader.registerUrl("termine", "assets/jsAjax/termine.js");
scriptLoader.registerUrl("appointment", "assets/jsAjax/appointment.js");
scriptLoader.registerUrl("credits", "assets/jsAjax/credits.js");
scriptLoader.check();
var parts = location.href.split('/');
if (parts.length == 4 && (parts[3] == "" || parts[3] == "home")) {
    getScript("assets/jsAjax/welcome.js").done(function () {
        console.info("Welcome loaded!");
    }).fail(function (jqxhr, settings, exception) {
        console.error(exception)
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
};

$(document).foundation();

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

$(document).ready(function (ev) {
    runMyAjax("ajax/Getters/needsNotification.php", function (result) {
        if (result.ja) {
            toastr.info("Du hast neue Nachrichten!");
        }
    });
});
