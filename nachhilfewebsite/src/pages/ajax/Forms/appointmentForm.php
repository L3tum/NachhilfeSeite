---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 12.01.2017
 * Time: 00:04
 */

include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";
include_once __DIR__ . "/../assets/php/dbClasses/Verbindung.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();

$idandererBenutzer = $_POST['idUser'];
$idFach = $_POST['idSubject'];
$date = $_POST['datetime_app'];
$time = $_POST['time_app'];
$datumsZeit = $date. " ".$time;
$room = $_POST['idRoom'];

if(Stunde::stundeExists($idandererBenutzer, $idFach, $date, $time, $room)){
    $form_helper->return_error("Eine Stunde in diesem Zeitraum existiert bereits!");
}
else{
    $idVerbindung = Verbindung::get_id_by_ids($idandererBenutzer, $idFach)->idVerbindung;
    $stmt = Connection::$PDO->prepare("INSERT INTO stunde (stunde.raumNummer, stunde.idVerbindung, stunde.datum) VALUES(:raumNummer, :idVerbindung, :datum)");
    $stmt->bindParam(':raumNummer', $room);
    $stmt->bindParam('idVerbindung', $idVerbindung);
    $stmt->bindParam(':datum', $datumsZeit);
    $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();
}