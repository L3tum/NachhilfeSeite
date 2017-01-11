---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 28.12.2016
 * Time: 12:06
 */
include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/Route.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/ConfigStrings.php";

$form_helper = new AjaxFormHelper();
if(!isset($_POST['user']) || !isset($_POST['faecher'])){
    $form_helper->return_error("Fach oder Benutzer ungültig!");
    exit();
}
$user = $_POST['user'];
$faecher = $_POST['faecher'];

foreach ($faecher as $fach) {
    if (Benutzer::get_logged_in_user()->has_anfrage($user, $fach)) {
        $form_helper->return_error("Du hast bereits eine Anfrage geschickt!");
        exit();
    } else if (Benutzer::get_logged_in_user()->has_tutiution_connection($user, $fach)) {
        $form_helper->return_error("Du hast bereits eine Nachhilfeverbindung mit diesem Benutzer!");
        exit();
    }
    $stmt = Connection::$PDO->prepare("INSERT INTO anfrage (anfrage.idSender, anfrage.idEmpfänger, anfrage.idFach) VALUES( :idSender , :idEmpfaenger , :idFach )");
    $stmt->bindParam(':idSender', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->bindParam(':idEmpfaenger', $user);
    $stmt->bindParam(':idFach', $fach);
    $stmt->execute();
}
$form_helper->success = true;
$form_helper->return_json();
?>