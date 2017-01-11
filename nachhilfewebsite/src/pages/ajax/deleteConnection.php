---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 22:58
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";


$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("deleteConnection")) {
    $stmt = Connection::$PDO->prepare("DELETE FROM verbindung WHERE verbindung.idVerbindung = :idVerbindung");
    $stmt->bindParam(':idVerbindung', $_POST['id']);
    $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}