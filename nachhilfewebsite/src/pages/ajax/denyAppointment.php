---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 17.01.2017
 * Time: 17:30
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();

$stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE idStunde = :idStunde");
$stmt->bindParam(':idStunde', $_POST['id']);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Stunde');
$stunde = $stmt->fetch();

if($stunde->idNachhilfelehrer == Benutzer::get_logged_in_user()->idBenutzer){
    Benachrichtigung::add($stunde->idNachhilfenehmer, "Termin abgelehnt", "Ein Termin wurde abgelehnt!", true);
}
else{
    Benachrichtigung::add($stunde->idNachhilfelehrer, "Termin abgelehnt", "Ein Termin wurde abgelehnt!", true);
}

$stmt = Connection::$PDO->prepare("DELETE FROM stunde WHERE idStunde = :idStunde");
$stmt->bindParam(':idStunde', $_POST['id']);
$stmt->execute();

$form_helper->success = true;
$form_helper->return_json();
