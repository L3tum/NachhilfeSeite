---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11.01.2017
 * Time: 20:51
 */

include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";
include_once __DIR__ . "/../assets/php/dbClasses/Verbindung.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";

$form_helper = new AjaxFormHelper();

if(isset($_POST["idNehmer"])) {
    $idNehmer = $_POST["idNehmer"];

    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfenehmer = :id");
    $stmt->bindParam(':id', $idNehmer);

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Verbindung');
    $verbindung = $stmt->fetch();

}
else if(isset($_POST["idGeber"])) {
    $idGeber = $_POST["idGeber"];

    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idNachhilfelehrer = :id");
    $stmt->bindParam(':id', $idGeber);

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Verbindung');
    $verbindung = $stmt->fetch();

}
else {
    $form_helper->return_error("Interner Fehler: ID nicht gesetzt");
}

$stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE idVerbindung = :id");
$stmt->bindParam(':id', $verbindung->idVerbindung);
$stmt->execute();
$open = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde');

if(!empty($open)){
    Stunde::block_appos_connection($verbindung->idVerbindung);
    Verbindung::block($verbindung->idVerbindung);
}
else {
    $stmt = Connection::$PDO->prepare("DELETE FROM verbindung WHERE idVerbindung = :id");
    $stmt->bindParam(':id', $verbindung->idVerbindung);
    $stmt->execute();
}

$form_helper->success = true;
$form_helper->return_json();