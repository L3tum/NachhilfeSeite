
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 22:42
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("giveClasses") || Benutzer::get_logged_in_user()->has_permission("takeClasses")) {
    $stmt = Connection::$PDO->prepare("SELECT DISTINCT f.idFach, f.name FROM fach as f LEFT JOIN angebotenesfach ON angebotenesfach.idFach=f.idFach");
    $stmt->execute();
    $form_helper->response['subjects'] = $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
