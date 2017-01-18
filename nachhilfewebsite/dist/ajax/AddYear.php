
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 19:14
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("addNewYear")) {
    $stmt = Connection::$PDO->prepare("INSERT INTO stufe (stufe.name) VALUES(:name)");
    $stmt->bindParam(':name', $_POST['year']);
    $stmt->execute();
    $form_helper->response['name'] = $_POST['year'];
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
