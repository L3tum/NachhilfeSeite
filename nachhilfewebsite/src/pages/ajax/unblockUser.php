---
layout: noLayout
---


<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 19:30
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("unblockUser")) {
    $stmt = Connection::$PDO->prepare("UPDATE benutzer SET benutzer.gesperrt=NULL WHERE benutzer.idBenutzer=".$_POST['user']);
    $stmt->execute();
    $form_helper->response['name'] = Benutzer::get_by_id($_POST['user'])->vorname. " ".Benutzer::get_by_id($_POST['user'])->name;
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}