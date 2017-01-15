---
layout: noLayout
---


<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 00:00
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();

$stmt = Connection::$PDO->prepare("UPDATE stunde SET stunde.abgesagt=1 WHERE stunde.idStunde= :idStunde");
$stmt->bindParam(':idStunde', $_POST['id']);
$stmt->execute();
$form_helper->success = true;
$form_helper->return_json();