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
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("del_all_hours")) {
    $date = date('m.Y', strtotime($_POST['id']));
    $stmt = Connection::$PDO->prepare("DELETE FROM stunde WHERE DATE_FORMAT(stunde.datum, '%m.%Y')=".$date);
    $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}