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
include_once __DIR__ . "/../assets/php/dbClasses/Verbindung.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("deleteConnection")) {
    if(!isset($_POST['id'])){
        $form_helper->success = false;
        $form_helper->return_error("Internet Fehler!");
    }
    if(Verbindung::get_by_id($_POST['id'])->has_appointments() == false || Verbindung::get_by_id($_POST['id'])->has_appointments() == null) {
        $stmt = Connection::$PDO->prepare("DELETE FROM verbindung WHERE verbindung.idVerbindung = :idVerbindung");
        $stmt->bindParam(':idVerbindung', $_POST['id']);
        $form_helper->success = $stmt->execute();
    }
    else{
        $form_helper->success = false;
        $form_helper->return_error("Es gibt noch Stunden unter dieser Verbindung! Diese müssen erst gelöscht werden!");
    }
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
?>