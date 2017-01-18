
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 19:49
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("addNewSubject")) {
    $stmt = Connection::$PDO->prepare("INSERT INTO fach (fach.name) VALUES(:name)");
    $stmt->bindParam(':name', $_POST['subject']);
    $stmt->execute();
    $form_helper->response['name'] = $_POST['subject'];
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
