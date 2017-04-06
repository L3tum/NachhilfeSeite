---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 23:38
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("canReport")) {
    $stmt = Connection::$PDO->prepare("INSERT INTO beschwerde (beschwerde.idSender, beschwerde.idNutzer, beschwerde.grund) VALUES(:id1, :id2, :grund)");
    $stmt->bindParam(':id1', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->bindParam(':id2', $_POST['id']);
    $stmt->bindParam(':grund', $_POST['reason']);
    $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}