---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 07.01.2017
 * Time: 14:11
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Raum.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("showAllFreeRooms")) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $endTime = date("H:i:s", strtotime("+45 minutes", strtotime($time)));
    $datumsZeit = $date. " ".$time;
    $newDatumsZeit = $date. " ".$endTime;
    $stmt = Connection::$PDO->prepare("SELECT raum.raumNummer as raumNummer FROM raum WHERE NOT EXISTS( SELECT * FROM stunde WHERE stunde.raumNummer=raum.raumNummer AND stunde.datum between :datumszeit AND :datumsEndZeit)");
    $stmt->bindParam(':datumszeit', $datumsZeit);
    $stmt->bindParam(':datumsEndZeit', $newDatumsZeit);
    if ($stmt->execute() == true) {
        $form_helper->response['raeume'] = $stmt->fetchAll(PDO::FETCH_CLASS, 'Raum');
        $form_helper->success = true;
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Es konnten keine Räume gefunden werden!");
    }
} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}