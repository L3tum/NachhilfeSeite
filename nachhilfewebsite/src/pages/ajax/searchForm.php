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

include_once  __DIR__ . "../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "../assets/php/general/Connection.php";
include_once  __DIR__ . "../assets/php/dbClasses/AngeboteneStufe.php";
include_once  __DIR__ . "../assets/php/dbClasses/AngebotenesFach.php";

$form_helper = new AjaxFormHelper();

$vorname = $form_helper->test_search_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Vorname");
$nachname = $form_helper->test_search_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Nachname");
$stufe = $form_helper->test_search_string($_POST['stufe'], "^([\d]{0,2}|[Q1-2]){1}$", "10");
$fach = $form_helper->test_search_string($_POST['fach'], "^[a-zA-ZÄÖÜäöüß]{1,25}$", "Deutsch");


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
if($stufe != null){
    $otherTable = "JOIN angeboteneStufe AS t2 ON t1.idBenutzer=t2.idBenutzer JOIN stufe AS t3 ON t2.idStufe=t3.idStufe";
    $params += "t3.name='".$stufe."' ";
}
if($fach != null){
    $otherTable2 = "JOIN angebotenesFach AS t4 ON t1.idBenutzer=t4.idBenutzer JOIN fach AS t5 ON t5.idFach=t4.idFach";
    $params += "t5.name='".$fach."' ";
}
if($_POST['verbindung2'] == true){
    $otherTable3 = "JOIN verbindung AS t6 ON t6.idNachhilfenehmer=t1.idBenutzer";
    $params += "t6.idNachhilfelehrer='".Benutzer::get_logged_in_user()->idBenutzer."' ";
}
else if($_POST['nachhilfegeber'] == true){
    $otherTable3 = "JOIN verbindung AS t6 ON t6.idNachhilfelehrer=t1.idBenutzer";
}
if($_POST['verbindung1'] == true){
    $otherTable3 = $otherTable3 = "JOIN verbindung AS t6 ON t6.idNachhilfelehrer=t1.idBenutzer";
    $params = "t6.idNachhilfenehmer='".Benutzer::get_logged_in_user()->idBenutzer."' ";
}
$sql = trim($sql, "\s{2,}");
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