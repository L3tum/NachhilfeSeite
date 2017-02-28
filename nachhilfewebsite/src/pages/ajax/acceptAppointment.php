---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 17.01.2017
 * Time: 17:28
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";
include_once __DIR__ . "/../assets/php/dbClasses/Verbindung.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";

$form_helper = new AjaxFormHelper();
$stmt = Connection::$PDO->prepare("UPDATE stunde SET akzeptiert=1 WHERE idStunde = :idStunde");
$stmt->bindParam(':idStunde', $_POST['id']);
$stmt->execute();
$stunde = Stunde::get_by_id($_POST['id']);
$connection = Verbindung::get_by_id($stunde->idVerbindung);
Benachrichtigung::add($connection->idNachhilfenehmer, "Termin akzeptiert", "Ein Termin wurde akzeptiert!", true);
Benachrichtigung::add($connection->idNachhilfelehrer, "Termin akzeptiert", "Ein Termin wurde akzeptiert!", true);
$form_helper->success = true;
$form_helper->return_json();