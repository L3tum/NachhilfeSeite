---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.02.2017
 * Time: 15:28
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("del_hour")) {
    $stmt = Connection::$PDO->prepare("DELETE FROM stunde WHERE idStunde = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $form_helper->response['id'] = $_POST['id'];
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}