---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.04.2017
 * Time: 14:48
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$stmt = Connection::$PDO->prepare("UPDATE stunde SET stunde.akzeptiert=1 WHERE stunde.idStunde=" . intval($_POST['id']));
$form_helper->success = $stmt->execute();
$form_helper->return_json();