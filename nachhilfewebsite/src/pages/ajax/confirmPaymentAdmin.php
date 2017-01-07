---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 07.01.2017
 * Time: 13:34
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("confirmPaymentAdmin")) {
    $stmt = Connection::$PDO->prepare("UPDATE stunde SET stunde.bezahltAdmin=1 WHERE stunde.idStunde = :idStunde");
    $stmt->bindParam(':idStunde', $_POST['idStunde']);
    if ($stmt->execute() == true) {
        $form_helper->success = true;
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Die Stunde konnte nicht verändert werden!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}