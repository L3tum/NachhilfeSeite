---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 07.01.2017
 * Time: 12:42
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("showUnpaidHours")) {
    $stmt = Connection::$PDO->prepare("SELECT t1.vorname as lehrerVorname, t1.name as lehrerName, t2.vorname as nehmerVorname, t2.name as nehmerName, DATE_FORMAT(t3.datum, '%d.%m.%Y %T') as datum, t3.bezahltAdmin as adminBezahlt, t3.bezahltLehrer as lehrerBezahlt, t3.idStunde as idStunde FROM benutzer as t1 JOIN verbindung as v ON v.idNachhilfelehrer=t1.idBenutzer JOIN benutzer as t2 ON t2.idBenutzer=v.idNachhilfenehmer JOIN stunde as t3 ON t3.idVerbindung=v.idVerbindung WHERE t3.findetStatt=1 AND t3.datum <= CURDATE() AND (t3.bezahltLehrer = 0 OR t3.bezahltAdmin = 0) AND t3.bestaetigtSchueler=1 AND t3.bestaetigtLehrer=1");
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