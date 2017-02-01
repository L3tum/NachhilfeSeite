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
}
$user_id = $_POST['user'];
$user = Benutzer::get_by_id($user_id);
if(!$user) {
    $form_helper->return_error("Benutzer ungültig!");
}

$faecher = $_POST['faecher'];
$logged_in = Benutzer::get_logged_in_user();
foreach ($faecher as $fach) {
    if ($logged_in->has_anfrage($user_id, $fach)) {
        $form_helper->return_error("Du hast bereits eine Anfrage geschickt!");
        exit();
    } else if ($logged_in->has_tutiution_connection($user_id, $fach)) {
        $form_helper->return_error("Du hast bereits eine Nachhilfeverbindung mit diesem Benutzer!");
        exit();
    }
    $stmt = Connection::$PDO->prepare("INSERT INTO anfrage (anfrage.idSender, anfrage.idEmpfänger, anfrage.idFach) VALUES( :idSender , :idEmpfaenger , :idFach )");
    $stmt->bindParam(':idSender', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->bindParam(':idEmpfaenger', $user_id);
    $stmt->bindParam(':idFach', $fach);
    $stmt->execute();
}

$subject = "Nachhilfeanfrage von {$logged_in->vorname} {$logged_in->name}";
$body = "Du hast eine Nachhilfeanfrage von {$logged_in->vorname} {$logged_in->name} im Nachhilfeportal bekommen!";
$form_helper->send_mail($user->email, $subject, $body);
$form_helper->success = true;
$form_helper->return_json();
?>