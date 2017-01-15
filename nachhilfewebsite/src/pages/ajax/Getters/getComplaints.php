---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 08.01.2017
 * Time: 14:51
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("showAllComplaints")) {
    $stmt = Connection::$PDO->prepare("SELECT t1.idBenutzer as gegenID, t1.vorname as gegenVorname, t1.name as gegenName, t2.idBenutzer as vonID, t2.vorname as vonVorname, t2.name as vonName, t3.grund as grund FROM benutzer as t1 JOIN beschwerde as t3 ON t3.idNutzer=t1.idBenutzer JOIN benutzer as t2 ON t2.idBenutzer=t3.idSender");
    if ($stmt->execute() == true) {
        $form_helper->response['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $form_helper->success = true;
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Es konnten keine Beschwerden gefunden werden!");
    }
} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}