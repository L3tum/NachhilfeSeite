---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 25.12.2016
 * Time: 13:42
 */

include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/dbClasses/AngeboteneStufe.php";
include_once  __DIR__ . "/../assets/php/dbClasses/AngebotenesFach.php";

$form_helper = new AjaxFormHelper();

$vorname = $form_helper->test_search_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Vorname");
$nachname = $form_helper->test_search_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Nachname");

echo $vorname;

$sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 :otherTable :otherTable2 :otherTable3 WHERE :params";
$otherTable = "";
$otherTable2 = "";
$otherTable3 = "";
$params = "";
if($vorname != null){
    $params += "t1.vorname='".$vorname."' ";
}
if($nachname != null){
    $params += "t1.name='".$nachname."' ";
}
$sql = trim($sql, "/s{2,}");
echo $sql;
$params = trim($params);
$params = str_replace(" ", " AND ", $params);

$stmt = Connection::$PDO->prepare($sql);
$stmt->bindParam(':otherTable', $otherTable);
$stmt->bindParam(':otherTable2', $otherTable2);
$stmt->bindParam(':otherTable3', $otherTable3);
$stmt->bindParam(':params', $params);
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_CLASS, 'Benutzer');

$form_helper->success = true;
$form_helper->response=$user;
$form_helper->return_json();
?>