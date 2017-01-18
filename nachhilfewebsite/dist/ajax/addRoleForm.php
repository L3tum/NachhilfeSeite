
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 10.01.2017
 * Time: 18:54
 */

include_once  __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
$name = $form_helper->test_string($_POST['name'], "/^[a-zA-ZÄÖÜ*]{1,25}$/", "Administrator");
$rechte = json_decode($_POST['rollen']);
$beschreibung = $_POST['beschreibung'];

$stmt = Connection::$PDO->prepare("INSERT INTO rolle (rolle.idRolle, rolle.name, rolle.beschreibung) VALUES(NULL, :name, :beschreibung)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':beschreibung', $beschreibung);
$stmt->execute();
$stmt = Connection::$PDO->prepare("SELECT LAST_INSERT_ID()");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$idRolle = $stmt->fetch();
foreach ($rechte as $recht) {
    $stmt = Connection::$PDO->prepare("INSERT INTO rollenberechtigung (rollenberechtigung.idRolle, rollenberechtigung.idBerechtigung) VALUES(:idRolle, :idBerechtigung)");
    $stmt->bindParam(':idRolle', $idRolle['LAST_INSERT_ID()']);
    $stmt->bindParam(':idBerechtigung', $recht);
    $stmt->execute();
}
$form_helper->success = true;
$form_helper->return_json();
