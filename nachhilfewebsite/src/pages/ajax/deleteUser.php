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
    $conns = Benutzer::get_by_id($_POST['id'])->get_all_tutiution_connections();
    foreach ($conns as $con){
        $hours = $con->has_appointments();
        if(isset($hours) && $hours != false){
            foreach ($hours as $hour){
                Stunde::deleteStunde($hour->idStunde);
            }
        }
        $stmt = Connection::$PDO->prepare("DELETE FROM verbindung WHERE idVerbindung = :id");
        $stmt->bindParam(':id', $con->idVerbindung);
        $stmt->execute();
    }
    $stmt = Connection::$PDO->prepare("DELETE FROM angebotenesfach WHERE idBenutzer = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM benachrichtigung WHERE idBenutzer = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM qualifikation WHERE idBenutzer = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM beschwerde WHERE idSender = :id OR idNutzer = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM chatnachricht WHERE idSender = :id OR idEmpfänger = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM anfrage WHERE idSender = :id OR idEmpfänger = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $stmt = Connection::$PDO->prepare("DELETE FROM angebotenestufe WHERE idBenutzer = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();

    /*$stmt = Connection::$PDO->prepare("SELECT      COLUMN_NAME AS 'ColumnName'
            ,TABLE_NAME AS  'TableName'
FROM        INFORMATION_SCHEMA.COLUMNS
WHERE       COLUMN_NAME LIKE 'idBenutzer'
ORDER BY    TableName
            ,ColumnName;");
    $stmt->execute();
    $form_helper->response['tables'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/


    $stmt = Connection::$PDO->prepare("DELETE FROM benutzer WHERE idBenutzer= :id");
    $stmt->bindParam(':id', $_POST['id']);
    $form_helper->response['deletionSuccessful'] = $stmt->execute();
    $form_helper->success = true;
    $form_helper->return_json();

} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}