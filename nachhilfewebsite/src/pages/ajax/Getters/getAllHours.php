---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 05.02.2017
 * Time: 14:28
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
if ($_POST['date'] != "") {
    $stmt = Connection::$PDO->prepare("SELECT t1.vorname as studentVorname, t1.name as studentName, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.idStunde, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert, verbindung.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer WHERE DATE_FORMAT(stunde.datum, '%Y-%m')= :datum ORDER BY stunde.datum");
}
else{
    $stmt = $stmt = Connection::$PDO->prepare("SELECT t1.vorname as studentVorname, t1.name as studentName, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.idStunde, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert, verbindung.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer ORDER BY stunde.datum");
}
$stmt->bindParam(':datum', $_POST['date']);
$stmt->execute();
$form_helper->response['hours'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
$form_helper->success = true;
$form_helper->return_json();