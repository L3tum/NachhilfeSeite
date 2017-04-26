---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 13.04.2017
 * Time: 13:41
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("set_maxNumberOfFreeLessons")) {
    $stmt = Connection::$PDO->prepare("UPDATE settings SET maxNumberOfFreeLessonsPerWeek = :max");
    $stmt->bindParam(':max', $_POST['number']);
    $form_helper->success = $stmt->execute();
    $form_helper->return_json();
} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}