---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 25.03.2017
 * Time: 15:06
 */

include_once  __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();

$vorname = $form_helper->test_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöüß ]{1,25}$/", "Vorname");
$nachname = $form_helper->test_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöüß ]{1,25}$/", "Nachname");
$passwort = $form_helper->test_string($_POST['passwort'], "/^.{1,200}$/", "Passwort");
if($passwort != $_POST['passwortConfirm']){
    $form_helper->return_error("Die Passwörter stimmen nicht überein!");
}
$passwort = hash("sha256" , $passwort . "349692058673618402393234575763ß23ß25230" );

$stmt = Connection::$PDO->prepare("INSERT INTO benutzer (vorname, name, email, telefonnummer, passwort, idRolle, emailActivated, wantsEmails) VALUES(:vorname, :name, :email, :tel , :passwort, :rolle, 1, 1)");
$stmt->bindParam(':vorname', $vorname);
$stmt->bindParam(':name', $nachname);
$stmt->bindParam(':email', $_POST['email']);
$stmt->bindParam(':passwort', $passwort);
$stmt->bindParam(':rolle', $_POST['rollen']);
$stmt->bindParam(':tel', $_POST['tel']);
$stmt->execute();
$form_helper->success = true;
$form_helper->return_json();