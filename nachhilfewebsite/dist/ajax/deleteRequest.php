

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 00:00
 */


include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";
include_once __DIR__ . "/../assets/php/dbClasses/Stunde.php";

$form_helper = new AjaxFormHelper();

$stmt = Connection::$PDO->prepare("UPDATE stunde SET stunde.akzeptiert=0, stunde.bestaetigtSchueler=0, stunde.bestaetigtLehrer=0 WHERE stunde.idStunde= :idStunde");
$stmt->bindParam(':idStunde', $_POST['id']);
$stmt->execute();

$stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE idStunde = :idStunde");
$stmt->bindParam(':idStunde', $_POST['id']);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Stunde');
$stunde = $stmt->fetch();

if($stunde->idNachhilfelehrer == Benutzer::get_logged_in_user()->idBenutzer){
    $benutzer = $stunde->idNachhilfenehmer;
}
else{
    $benutzer = $stunde->idNachhilfelehrer;
}

Benachrichtigung::add($benutzer, "Stunde abgesagt", "Die Stunde am " . date('d.m.Y H:i:s', strtotime($stunde->datum))." wurde abgesagt!");

$form_helper->success = true;
$form_helper->return_json();
