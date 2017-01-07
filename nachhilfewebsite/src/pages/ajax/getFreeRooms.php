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

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Raum.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("showAllFreeRooms")) {
    $date = $_POST['date'];
    $stmt = Connection::$PDO->prepare("SELECT raum.raumNummer FROM raum JOIN stunde ON stunde.raumNummer=raum.raumNummer WHERE NOT stunde.datum= :datum");
    $stmt->bindParam(':datum', $date);
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