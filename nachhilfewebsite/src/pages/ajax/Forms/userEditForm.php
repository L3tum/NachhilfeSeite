---
layout: noLayout
---
<?php
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
$logged_in_user = Benutzer::get_logged_in_user();
$user_to_edit_id = $_POST['user-id'];
$user_to_edit = $form_helper->get_user_by_external_id($user_to_edit_id);
if($user_to_edit_id == $logged_in_user->idBenutzer){
    $user_is_me = true;
}
else{
    $user_is_me = false;
}
if (!$user_to_edit) {

    $form_helper->return_error("Interner Fehler: Kein Nutzer mit dieser ID gefunden.");
}

if (!($user_to_edit->idBenutzer == $logged_in_user->idBenutzer) && !$logged_in_user->has_permission("editEveryUser")) {
    $form_helper->return_error("Keine Berechtigung.");
}


if ($logged_in_user->has_permission("canEditName")) {

    $vorname = $form_helper->test_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöü ]{1,25}$/", "Vorname");
    $nachname = $form_helper->test_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöü ]{1,25}$/", "Nachname");
} else {

    $vorname = $user_to_edit->vorname;
    $nachname = $user_to_edit->name;
}

if ($_POST['passwort'] == "") {

    $passwort = $user_to_edit->passwort;
} else {

    $passwort = hash("sha256", $form_helper->test_string($_POST['passwort'], "/^.{1,200}$/", "Passwort") . $vorname . $nachname . "ei waas mach ich hier ich bin ein star bringt mich nach Bielefeld");
    $passwortWiederholung = hash("sha256", $form_helper->test_string($_POST['passwort-wiederholung'], "/^.{1,200}$/", "Zweites Passwort") . $vorname . $nachname . "ei waas mach ich hier ich bin ein star bringt mich nach Bielefeld");
    if (strcmp($passwort, $passwortWiederholung) !== 0) {
        $form_helper->return_error("Die Passwörter stimmen nicht überein.");
    }
}

$telefonnummer = $form_helper->test_string($_POST['telefonnummer'], "/^[0-9]{0,15}$/", "Telefonnummer");
$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $form_helper->return_error("Keine gültige Email-Adresse.");
}

if ((!$user_is_me && $logged_in_user::get_logged_in_user()->has_permission("editOtherRole") && !$user_to_edit->has_permission("elevated_administrator")) || ($user_is_me &&  $user_to_edit->has_permission("editSelfRole") && !$user_to_edit->has_permission("administration"))) {
    $rolle = $_POST['rollenSelector'];
} else {
    $rolle = $user_to_edit->idRolle;
}

if (((!$user_is_me && $logged_in_user->has_permission("editOtherSubjects") == true) || ($user_is_me && $logged_in_user->has_permission("editSelfSubjects"))) && $user_to_edit->has_permission("giveClasses")) {
    $faecher = json_decode($_POST['faecher']);
    $stmt = Connection::$PDO->prepare("DELETE FROM angebotenesfach WHERE angebotenesfach.idBenutzer=" . $user_to_edit_id);
    $stmt->execute();
    foreach ($faecher as $fach) {
        $stmt = Connection::$PDO->prepare("INSERT INTO angebotenesfach (angebotenesfach.idBenutzer, angebotenesfach.idFach) VALUES(:idBenutzer, :idFach)");
        $stmt->bindParam(':idBenutzer', $user_to_edit_id);
        $stmt->bindParam(':idFach', $fach);
        $stmt->execute();
    }
}
if (((!$user_is_me && $logged_in_user->has_permission("editOtherYears") == true) || ($user_is_me && $logged_in_user->has_permission("editSelfYears"))) && $user_to_edit->has_permission("giveClasses")) {
    $stufen = json_decode($_POST['stufen']);
    $stmt = Connection::$PDO->prepare("DELETE FROM angebotenestufe WHERE angebotenestufe.idBenutzer=" . $user_to_edit_id);
    $stmt->execute();
    foreach ($stufen as $stufe) {
        $stmt = Connection::$PDO->prepare("INSERT INTO angebotenestufe (angebotenestufe.idBenutzer, angebotenestufe.idStufe) VALUES(:idBenutzer, :idStufe)");
        $stmt->bindParam(':idBenutzer', $user_to_edit_id);
        $stmt->bindParam(':idStufe', $stufe);
        $stmt->execute();
    }
}

if(!isset($_POST['wantsEmails'])){
    $wantsEmails = $user_to_edit->wantsEmails;
}
else{
    $wantsEmails = $_POST['wantsEmails'];
    $wantsEmails = trim($wantsEmails, '"');
}
if($wantsEmails == "true"){
    $wantsEmails = 1;
}
else if($wantsEmails == "false"){
    $wantsEmails = 0;
}


//Check if there is an existing user with these credentials
$stmt = Connection::$PDO->prepare("UPDATE benutzer SET vorname = :vorname, name = :name, passwort = :passwort, telefonnummer = :telefonnummer, email = :email, idRolle = :rolle, wantsEmails = :wants WHERE idBenutzer = :idBenutzer");
$stmt->bindParam(':vorname', $vorname);
$stmt->bindParam(':name', $nachname);
$stmt->bindParam(':passwort', $passwort);
$stmt->bindParam(':telefonnummer', $telefonnummer);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':rolle', $rolle);
$stmt->bindParam(':idBenutzer', $user_to_edit_id);
$stmt->bindParam(':wants', $wantsEmails);
$stmt->execute();


$form_helper->success = true;
$form_helper->return_json();
?>