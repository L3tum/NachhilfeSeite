<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<div class="container" align="center">
<h1 style="color: deeppink;">HEEEEEY</h1>

<h2>Spectacular Mountain</h2>
<body background="pics/tr2.jpg">
<p><a href="https://www.donaldjtrump.com/">Visit Gymnasium-Lohmar.com!</a></p>
</body>
    
<form action="index.php" method="post">
    Vorname: <input type="text" name="username"/><br/>
    Name: <input type="text" name="username"/><br/>
    Passwort: <input type="password" name="passwort"/><br/>
    Passwort bestätigen: <input type="password" name="passwortBestaetigt"/><br/>
    Telefonnummer: <input type="tel" name="tel"/><br/>
    Email: <input type="email" name="email" /><br/>
    Männlich: <input type="checkbox" name="m"/><br/>
    <input type="submit" name="submit" value="Fuck off"/>
</form>
</div>
</html>

<?php

if(isset($_POST['submit'], $_POST['username'], $_POST['email'], $_POST['passwort'], $_POST['passwortBestaetigt'], $_POST['tel']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['passwort'] && $_POST['passwortBestaetigt'] && !empty($_POST['tel']))) {
    $passwortverschlusselt;
    $bestaetigtPasswortVerschluesselt;
    $passwortverschlusselt = crypt($_POST['passwort'], "WAS IST DAS FUER EINE SCHEISSE DU ARSCHLOCH FUCK OFF");
    $bestaetigtPasswortVerschluesselt = crypt($_POST['passwortBestaetigt'], "WAS IST DAS FUER EINE SCHEISSE DU ARSCHLOCH FUCK OFF");

    echo $passwortverschlusselt."<br/>".$bestaetigtPasswortVerschluesselt."<br/>";
    if($passwortverschlusselt !== $bestaetigtPasswortVerschluesselt){
        echo "FEHLER DU ARSCH<br/>";
    }
    mail($_POST['email'], $_POST['username'], $_POST['username']." ".$_POST['email']." ".$_POST['passwort']." ".$_POST['tel']);
    echo "Crypt: ".crypt($_POST['username'].$_POST['email'].$_POST['passwort'].$_POST['passwortBestaetigt'].$_POST['tel'], $_POST['email'].session_id());
    var_dump($passwortverschlusselt, $bestaetigtPasswortVerschluesselt);
}
if(isset($_POST['submit'])){
    echo "FEHLER DU ARSCH<br/>";
}
?>
