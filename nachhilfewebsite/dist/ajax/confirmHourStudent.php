
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 23:09
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("takeClasses")) {
    $stmt = Connection::$PDO->prepare("UPDATE stunde SET stunde.bestaetigtSchueler=1 WHERE stunde.idStunde=".$_POST['id']);
    $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
