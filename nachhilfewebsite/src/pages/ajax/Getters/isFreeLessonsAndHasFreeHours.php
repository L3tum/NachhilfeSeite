---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 17.04.2017
 * Time: 14:27
 */

include_once __DIR__ . "/../../assets/php/dbClasses/Stunde.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Verbindung.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Settings.php";
include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();

$idandererBenutzer = $_POST['idUser'];
$idFach = $_POST['idSubject'];
$date = $_POST['datetime_app'];
$idBenutzer = Benutzer::get_logged_in_user()->idBenutzer;
$verbindung = Verbindung::get_id_by_ids($idandererBenutzer, $idFach);
if($verbindung->kostenfrei){
    $form_helper->response['isFirst'] = true;
}
else{
    $form_helper->response['isFirst'] = false;
}
$currDate = new DateTime();
$week = $currDate->format("W");
$lessons = Stunde::get_all_lessons_by_user_and_week_free($idBenutzer, $week);
if($lessons != false) {
    $counter = count($lessons);
    if($counter >= Settings::getSettings()->maxNumberOfFreeLessonsPerWeek){
        $form_helper->response['hasFree'] = false;
    }
    else{
        $form_helper->response['hasFree'] = true;
    }
}
else{
    $form_helper->response['hasFree'] = true;
}
$form_helper->success = true;
$form_helper->return_json();