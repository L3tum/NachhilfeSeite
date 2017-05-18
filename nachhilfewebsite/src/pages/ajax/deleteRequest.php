---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 00:00
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";

$form_helper = new AjaxFormHelper();
if(!isset($_POST['id'])){
    $form_helper->return_error("Internet Fehler");
    exit();
}
$stunde = Stunde::get_by_id(intval($_POST['id']));
$stmt = Connection::$PDO->prepare("DELETE FROM stunde WHERE idStunde = :id");
$stmt->bindParam(':id', $stunde->idStunde);
$stmt->execute();
if($stunde->idNachhilfelehrer == Benutzer::get_logged_in_user()->idBenutzer){
    $benutzer = $stunde->idNachhilfenehmer;
}
else{
    $benutzer = $stunde->idNachhilfelehrer;
}
if(isset($benutzer)) {
    $string = "Die Stunde am ";
    $dateString = date('d.m.Y H:i:s', strtotime($stunde->datum));
    $string .= $dateString;
    $string .= " wurde abgesagt!";
    Benachrichtigung::add($benutzer, "Stunde abgesagt", $string);
}
$form_helper->success = true;
$form_helper->return_json();