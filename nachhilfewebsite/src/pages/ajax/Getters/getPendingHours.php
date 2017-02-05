---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 07.01.2017
 * Time: 11:13
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("showPendingHours")){
    $stmt = Connection::$PDO->prepare("SELECT t1.vorname as lehrerVorname, t1.name as lehrerName, t2.vorname as nehmerVorname, t2.name as nehmerName, DATE_FORMAT(t3.datum, '%d.%m.%Y %T') as datum, t3.raumNummer as raumNummer FROM benutzer as t1 JOIN verbindung as v ON v.idNachhilfelehrer=t1.idBenutzer JOIN benutzer as t2 ON t2.idBenutzer=v.idNachhilfenehmer JOIN stunde as t3 ON t3.idVerbindung=v.idVerbindung WHERE t3.akzeptiert=1 AND t3.datum >= CURDATE() ORDER BY t3.datum");
    if($stmt->execute() == true){
        $form_helper->success = true;
        $form_helper->response['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $form_helper->return_json();
    }
    else{
        $form_helper->return_error("Es konnten keine Stunden gefunden werden!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffsrechte!");
}

