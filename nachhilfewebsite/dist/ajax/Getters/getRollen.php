
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 05.01.2017
 * Time: 14:31
 */

include_once __DIR__ . "/../../assets/php/dbClasses/Rolle.php";
include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("showAllRoles")) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM rolle");
    if($stmt->execute() == true) {
        $form_helper->response['rollen'] = $stmt->fetchAll(PDO::FETCH_CLASS, 'Rolle');
        $form_helper->success = true;
        $form_helper->return_json();
    }
    else{
        $form_helper->return_error("Es konnten keine Rollen gefunden werden!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
