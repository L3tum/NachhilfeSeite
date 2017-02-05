---
layout: noLayout
---


<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 16.01.2017
 * Time: 09:20
 */

include_once __DIR__ . "/../../assets/php/dbClasses/Benachrichtigung.php";
include_once  __DIR__ . "/../../assets/php/general/Connection.php";
include_once  __DIR__ . "/../../assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();

$notification_id = $_POST['idNotification'];
if(!ctype_digit($notification_id)) {
    $form_helper->return_error("Interner Fehler: ID ist keine Zahl");
}

$stmt = Connection::$PDO->prepare("DELETE FROM benachrichtigung WHERE idBenachrichtigung = :idBen AND idBenutzer = :idBenutzer");
$stmt->bindParam(':idBen', $notification_id);
$stmt->bindParam(':idBenutzer', Benutzer::get_logged_in_user()->idBenutzer);
$stmt->execute();

$form_helper->success = true;
$form_helper->return_json();

?>