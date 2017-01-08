---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 08.01.2017
 * Time: 15:12
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("deleteComplaints")) {
    $stmt = Connection::$PDO->prepare("DELETE FROM beschwerde WHERE beschwerde.idSender = :id1 AND beschwerde.idNutzer = :id2");
    $ids = $_POST['IDs'];
    $ida = explode(',', $ids);
    $stmt->bindParam(':id1', $ida[1]);
    $stmt->bindParam(':id2', $ida[0]);
    if ($stmt->execute() == true) {
        $form_helper->success = true;
        $form_helper->response['id'] = $_POST['ID'];
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Die Beschwerde konnte nicht gelöscht werden!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}