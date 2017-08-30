/**
 * Created by Tom on 16.05.2017.
 */

var countDownDate = new Date("Feb 1, 2017 12:00:00").getTime();
var loaded = false;

// Update the count down every 1 second
var x = setInterval(function () {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = now - countDownDate;

    // Time calculations for days, hours, minutes and seconds
    var years = Math.floor(distance / (1000 * 60 * 60 * 24 * 365.25));
    var days = Math.floor((distance % (1000 * 60 * 60 * 24 * 365.25)) / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    var attached = "Diese Seite läuft seit ";
    if (years != 0) {
        if (years > 1) {
            attached += years + " Jahren, ";
        } else {
            attached += years + " Jahr, ";
        }
    }
    if (days > 1 || days == 0) {
        attached += days + " Tagen, ";
    } else {
        attached += days + " Tag, ";
    }
    if (hours > 1 || hours == 0) {
        attached += hours + " Stunden, ";
    }
    else {
        attached += hours + " Stunde, ";
    }
    if (minutes > 1 || minutes == 0) {
        attached += minutes + " Minuten, ";
    }
    else {
        attached += minutes + " Minute, ";
    }
    if (seconds > 1 || seconds == 0) {
        attached += seconds + " Sekunden, ";
    }
    else {
        attached += seconds + " Sekunde, ";
    }
    if (!attached.endsWith("!")) {
        attached = attached.trim().replace(new RegExp(",$"), "!");
    }
    if (!loaded && years >= 1 && days == 0) {
        getScript("assets/jsAjax/oneyear.js").done(function () {
            console.info("Anniversary stuff loaded!");
        }).fail(function (jqxhr, settings, exception) {
            console.error(exception)
        });
        loaded = true;
    }

    // Display the result in the element with id="demo"
    document.getElementById("timer").innerHTML = attached;
}, 1000);

$(document).ready(function (ev) {
    $("#videos").attr('src', "https://www.youtube.com/embed/bpxtuUQ28UM?autoplay=1&loop=1");
    var authorized = false;

    if (document.getElementById("login-form") == null) {
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

    /**
     * Created by Tom on 08.04.2017.
     */


});
