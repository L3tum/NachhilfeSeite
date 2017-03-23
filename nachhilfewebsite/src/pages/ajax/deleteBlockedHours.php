---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 23.03.2017
 * Time: 11:36
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("show_connections")) {
    $stmt = Connection::$PDO->prepare("DELETE FROM stunde WHERE akzeptiert=-1 AND DATE_FORMAT(datum, '%m.%Y')=".$_POST['id']);
    $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}