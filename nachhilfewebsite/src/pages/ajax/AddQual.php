---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 22:17
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
$stmt = Connection::$PDO->prepare("INSERT INTO qualifikation (qualifikation.name, qualifikation.beschreibung, qualifikation.idBenutzer) VALUES(:name, :desc, :idBenutzer)");
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':desc', $_POST['desc']);
$stmt->bindParam(':idBenutzer', $_POST['id']);
$stmt->execute();
$form_helper->response['name'] = $_POST['name'];
$form_helper->success = true;
$form_helper->return_json();