---
layout: noLayout
---

<?php
include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
$logged_in_user = Benutzer::get_logged_in_user();
$user_to_edit_id = $_POST['user-id'];
$user_to_edit = $form_helper->get_user_by_external_id($user_to_edit_id);
if(!$user_to_edit) {

    $form_helper->return_error("Interner Fehler: Kein Nutzer mit dieser ID gefunden.");
}

if(!($user_to_edit->idBenutzer == $logged_in_user->idBenutzer) && !$logged_in_user->has_permission("editEveryUser")) {
    $form_helper->return_error("Keine Berechtigung.");
}


if($logged_in_user->has_permission("canEditName")) {

    $vorname = $form_helper->test_string($_POST['vorname'], "/^[a-zA-ZÄÖÜ*]{1,25}$/", "Vorname");
    $nachname = $form_helper->test_string($_POST['nachname'], "/^[a-zA-ZÄÖÜ*]{1,25}$/", "Nachname");
}
else {

    $vorname = $user_to_edit->vorname;
    $nachname = $user_to_edit->name;
}

if($_POST['passwort'] == "") {

    $passwort = $user_to_edit->passwort;
}
else {

    $passwort = hash("sha256", $form_helper->test_string($_POST['passwort'], "/^.{1,200}$/", "Passwort") . $vorname . $nachname . "ei waas mach ich hier ich bin ein star bringt mich nach Bielefeld");
    $passwortWiederholung = hash("sha256", $form_helper->test_string($_POST['passwort-wiederholung'], "/^.{1,200}$/", "Zweites Passwort") . $vorname . $nachname . "ei waas mach ich hier ich bin ein star bringt mich nach Bielefeld");
    if(strcmp($passwort, $passwortWiederholung) !== 0) {
        $form_helper->return_error("Die Passwörter stimmen nicht überein.");
    }
}

$telefonnummer = $form_helper->test_string($_POST['telefonnummer'], "/^[0-9]{0,15}$/", "Telefonnummer");
$email = $_POST['email'];
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $form_helper->return_error("Keine gültige Email-Adresse.");
}

//Check if there is an existing user with these credentials
$stmt = Connection::$PDO->prepare("UPDATE benutzer SET vorname = :vorname, name = :name, passwort = :passwort, telefonnummer = :telefonnummer, email = :email WHERE idBenutzer = :idBenutzer");
$stmt->bindParam(':vorname', $vorname);
$stmt->bindParam(':name', $nachname);
$stmt->bindParam(':passwort', $passwort);
$stmt->bindParam(':telefonnummer', $telefonnummer);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':idBenutzer', $user_to_edit_id);
$stmt->execute();


$form_helper->success = true;
$form_helper->return_json();
?>