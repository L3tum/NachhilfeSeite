---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 05.02.2017
 * Time: 12:45
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/general/Connection.php";


$form_helper = new AjaxFormHelper();

if(!isset($_POST['desc'])){
    $desc = "";
}
else{
    $desc = $_POST['desc'];
}

$stmt = Connection::$PDO->prepare("INSERT INTO berechtigung (name, beschreibung) VALUES(:name, :beschreibung)");
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':beschreibung', $desc);
$stmt->execute();

$form_helper->success = true;
$form_helper->return_json();