---
layout: noLayout
---

<?php
include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();

$vorname = $form_helper->test_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Vorname");
$nachname = $form_helper->test_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Nachname");
$passwort = $form_helper->test_string($_POST['passwort'], "/^.{1,200}$/", "Passwort");
$passwort = hash("sha256" , $passwort . "349692058673618402393234575763ß23ß25230");

//Check if there is an existing user with these credentials
$stmt = Connection::$PDO->prepare("SELECT * FROM benutzer WHERE vorname = :vorname && name = :name && passwort = :passwort");
$stmt->bindParam(':vorname', $vorname);
$stmt->bindParam(':name', $nachname);
$stmt->bindParam(':passwort', $passwort);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
$user = $stmt->fetch();

if(!$user) {
    $form_helper->return_error("Passwort oder Nutzername falsch!");
}

if($user->gesperrt==1){
    $form_helper->return_error("Sie wurden gesperrt!");
}

//Set the session id
$user->log_in();

$form_helper->success = true;
$form_helper->return_json();
?>