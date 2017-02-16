---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 14.02.2017
 * Time: 15:53
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();

if (Benutzer::get_logged_in_user()->has_permission("delete_user")) {
    $stmt = Connection::$PDO->prepare("DELETE FROM benutzer WHERE idBenutzer= :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();

} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}