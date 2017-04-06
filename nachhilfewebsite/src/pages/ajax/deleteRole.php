---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 18:21
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("deleteRole")) {
    $stmt = Connection::$PDO->prepare("SELECT rolle.name FROM rolle WHERE rolle.idRolle = ". $_POST['id']);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Rolle');
    $rolle = $stmt->fetch();
    $stmt = Connection::$PDO->prepare("UPDATE benutzer SET benutzer.idRolle=NULL WHERE benutzer.idRolle = " . $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM rollenberechtigung WHERE rollenberechtigung.idRolle = ". $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM rolle WHERE rolle.idRolle = ". $_POST['id']);
    if ($stmt->execute() == true) {
        $form_helper->success = true;
        $form_helper->response['name'] = $rolle->name;
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Die Rolle konnte nicht gelöscht werden!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}