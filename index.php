<?php
session_start();
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Nachhilfe</title>
    <link rel="stylesheet" href="css/foundation.css"/>
</head>

<div class="container" align="center">
    <body>
    <h1 style="color: deeppink;">HEEEEEY</h1>
    <h2>Spectacular Mountain</h2>
    <p><a href="https://www.donaldjtrump.com/">Visit Gymnasium-Lohmar.com!</a></p>

    <!--<iframe width="560" height="315" src="https://www.youtube.com/embed/YEwlfJdTldw?autoplay=1" frameborder="0" allowfullscreen></iframe> -->

    <script src="mediaelement-and-player.min.js"></script>
    <link rel="stylesheet" href="mediaelementplayer.css"/>
    <link rel="stylesheet" href="CSS/video.css"/>

    <div class="fullscreen-bg">
        <video width="640" height="360" id="player1" preload="none">
            <source type="video/youtube" src="https://www.youtube.com/embed/YEwlfJdTldw?autoplay=1"/>
        </video>
    </div>

    <script>
        var player = new MediaElementPlayer('#player1');
    </script>

    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/vendor/what-input.min.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>$(document).foundation();</script>
    <div class="form-group">
        <form action="index.php" method="post">
            <label for="vorname">Vorname:</label>
            <input class="form-control" type="text" name="vorname"/><br/>

            <label for="vorname">Name:</label>
            <input class="form-control" type="text" name="name"/><br/>

            <label for="vorname">Passwort:</label>
            <input class="form-control" type="password" name="passwort"/><br/>

            <label for="vorname">Passwort bestätigen:</label>
            <input class="form-control" type="password" name="passwortBestaetigt"/><br/>

            <label for="vorname">Telefonnummer:</label>
            <input class="form-control" type="tel" name="telefon"/><br/>

            <label for="vorname">Email:</label>
            <input class="form-control" type="email" name="email"/><br/>

            <label for="vorname">Männlich:</label>
            <input class="form-control" type="checkbox" name="maennlich"/><br/>
            <input class="form-control" type="submit" name="submit" value="Fuck off"/>
        </form>
    </div>
    </body>
</div>
</html>

<?php

if (isset($_POST['submit'], $_POST['vorname'], $_POST['name'], $_POST['email'], $_POST['passwort'], $_POST['passwortBestaetigt'], $_POST['tel']) && !empty($_POST['vorname']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['passwort'] && $_POST['passwortBestaetigt'] && !empty($_POST['tel']))) {
    $passwortverschlusselt = crypt($_POST['passwort'], "WAS IST DAS FUER EINE SCHEISSE DU ARSCHLOCH FUCK OFF");
    $bestaetigtPasswortVerschluesselt = crypt($_POST['passwortBestaetigt'], "WAS IST DAS FUER EINE SCHEISSE DU ARSCHLOCH FUCK OFF");

    echo $passwortverschlusselt . "<br/>" . $bestaetigtPasswortVerschluesselt . "<br/>";
    if ($passwortverschlusselt !== $bestaetigtPasswortVerschluesselt) {
        echo "FEHLER DU ARSCH<br/>";
    }
    mail($_POST['email'], $_POST['name'], $_POST['vorname'] . " " . $_POST['email'] . " " . $_POST['passwort'] . " " . $_POST['tel']);
    echo "Crypt: " . crypt($_POST['vorname'] . $_POST['name'] . $_POST['email'] . $_POST['passwort'] . $_POST['passwortBestaetigt'] . $_POST['tel'], $_POST['email'] . session_id());
    var_dump($passwortverschlusselt, $bestaetigtPasswortVerschluesselt);
} else if (isset($_POST['submit'])) {
    echo "FEHLER DU ARSCH<br/>";
}
?>
