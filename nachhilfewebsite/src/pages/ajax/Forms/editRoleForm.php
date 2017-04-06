---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 08.01.2017
 * Time: 18:54
 */

include_once  __DIR__ . "/../../assets/php/dbClasses/Rolle.php";
include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
$name = $form_helper->test_string($_POST['name'], "/^[a-zA-ZÄÖÜ*]{1,25}$/", "Administrator");
$idRolle = $_POST['role-id'];
$rechte = json_decode($_POST['rollen']);
$beschreibung = $_POST['beschreibung'];

$stmt = Connection::$PDO->prepare("UPDATE rolle SET name = :name ,beschreibung = :beschreibung WHERE rolle.idRolle = :idRolle");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':beschreibung', $beschreibung);
$stmt->bindParam(':idRolle', $idRolle);
$stmt->execute();
$stmt = Connection::$PDO->prepare("DELETE FROM rollenberechtigung WHERE rollenberechtigung.idRolle= :idRolle");
$stmt->bindParam(':idRolle', $idRolle);
$stmt->execute();

foreach ($rechte as $recht){
    $stmt = Connection::$PDO->prepare("INSERT INTO rollenberechtigung (rollenberechtigung.idRolle, rollenberechtigung.idBerechtigung) VALUES(:idRolle, :idBerechtigung)");
    $stmt->bindParam(':idRolle', $idRolle);
    $stmt->bindParam(':idBerechtigung', $recht);
    $stmt->execute();
}
$form_helper->success = true;
$form_helper->return_json();
