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
    <link rel="stylesheet" href="CSS/testing.css"/>
</head>


<body style="background-color: darkgray">
<div id="root" class="container" align="left">
    <h1 style="color: deeppink">HEEEEEY</h1>
    <h2 style="background-color: whitesmoke; width: 6%">Spectacular Mountain</h2>
    <p><a style="background-color: whitesmoke" href="https://www.donaldjtrump.com/">Visit Gymnasium-Lohmar.com!</a></p>

    <!--<iframe width="560" height="315" src="https://www.youtube.com/embed/YEwlfJdTldw?autoplay=1" frameborder="0" allowfullscreen></iframe> -->

    <div class="form-group">
        <form action="index.php" method="post">
            <label style="background-color: whitesmoke" for="vorname">Vorname:</label>
            <input style="background-color: whitesmoke" class="form-control" type="text" name="vorname"/><br/>

            <label style="background-color: whitesmoke" for="vorname">Name:</label>
            <input style="background-color: whitesmoke" class="form-control" type="text" name="name"/><br/>

            <label style="background-color: whitesmoke" for="vorname">Passwort:</label>
            <input style="background-color: whitesmoke" class="form-control" type="password" name="passwort"/><br/>

            <label style="background-color: whitesmoke" for="vorname">Passwort bestätigen:</label>
            <input style="background-color: whitesmoke" class="form-control" type="password" name="passwortBestaetigt"/><br/>

            <label style="background-color: whitesmoke" for="vorname">Telefonnummer:</label>
            <input style="background-color: whitesmoke" class="form-control" type="tel" name="telefon"/><br/>

            <label style="background-color: whitesmoke" for="vorname">Email:</label>
            <input style="background-color: whitesmoke" class="form-control" type="email" name="email"/><br/>

            <label style="background-color: whitesmoke" for="vorname">Männlich:</label>
            <input style="background-color: whitesmoke" class="form-control" type="checkbox" name="maennlich"/><br/>
            <input style="background-color: whitesmoke" class="form-control" type="submit" name="submit"
                   value="Fuck off"/>
        </form>
    </div>
</div>
<div>
    <script src="https://unpkg.com/react@15/dist/react.min.js"></script>
    <script src="https://unpkg.com/react-dom@15/dist/react-dom.min.js"></script>
    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/vendor/what-input.min.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>$(document).foundation();</script>
</div>
</body>
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
