---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 08.01.2017
 * Time: 13:36
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("showAllTakenRooms")) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    if($date == null){
        $stmt = Connection::$PDO->prepare("SELECT t1.vorname as lehrerVorname, t1.name as lehrerName, t2.vorname as nehmerVorname, t2.name as nehmerName, t3.raumNummer, t3.datum FROM benutzer as t1 JOIN verbindung as v ON v.idNachhilfelehrer=t1.idBenutzer JOIN benutzer as t2 ON v.idNachhilfenehmer=t2.idBenutzer JOIN stunde as t3 ON t3.idVerbindung=v.idVerbindung");
    }
    else {
        $endTime = date("H:i:s", strtotime("+45 minutes", strtotime($time)));
        $datumsZeit = $date . " " . $time;
        $newDatumsZeit = $date . " " . $endTime;
        $stmt = Connection::$PDO->prepare("SELECT t1.vorname as lehrerVorname, t1.name as lehrerName, t2.vorname as nehmerVorname, t2.name as nehmerName, t3.raumNummer, t3.datum FROM benutzer as t1 JOIN verbindung as v ON v.idNachhilfelehrer=t1.idBenutzer JOIN benutzer as t2 ON v.idNachhilfenehmer=t2.idBenutzer JOIN stunde as t3 ON t3.idVerbindung=v.idVerbindung WHERE t3.datum between :datumsZeit AND :endDatumsZeit");
        $stmt->bindParam(':datumsZeit', $datumsZeit);
        $stmt->bindParam(':endDatumsZeit', $newDatumsZeit);
    }
    if ($stmt->execute() == true) {
        $form_helper->response['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $form_helper->success = true;
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Es konnten keine Räume gefunden werden!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}