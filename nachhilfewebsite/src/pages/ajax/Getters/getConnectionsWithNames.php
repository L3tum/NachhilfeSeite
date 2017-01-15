---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 07.01.2017
 * Time: 01:24
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("showAllConnections")) {
    $stmt = Connection::$PDO->prepare("SELECT t2.idVerbindung as idVerbindung, t1.vorname as lehrerVorname, t1.name as lehrerName, t4.vorname as nehmerVorname, t4.name as nehmerName, t3.name as fachName FROM benutzer as t1 JOIN verbindung as t2 ON t2.idNachhilfelehrer=t1.idBenutzer JOIN benutzer as t4 ON t4.idBenutzer=t2.idNachhilfenehmer JOIN fach as t3 ON t3.idFach=t2.idFach");
    if ($stmt->execute() == true) {
        $form_helper->response['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $form_helper->success = true;
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Es konnten keine Verbindungen gefunden werden!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
