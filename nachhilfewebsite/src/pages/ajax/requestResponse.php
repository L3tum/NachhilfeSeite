---
layout: noLayout
---

<?php
include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once __DIR__ . "/../assets/php/dbClasses/Anfrage.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$response = $_POST['response'];
$form_helper = new AjaxFormHelper();
$request_id = $_POST['idRequest'];
$sender_id = $_POST['idSendingUser'];;
$fach_id = $_POST['idFach'];
$kostenfrei = $_POST['kostenfrei'];

if(!ctype_digit($request_id)) {
    $this->return_error("Interner Fehler: ID ist keine Zahl");
}

if(!ctype_digit($sender_id)) {
    $this->return_error("Interner Fehler: ID ist keine Zahl");
}


if(!isset($response)) {
    $form_helper->return_error("Interner Fehler!");
}

else if($response == "acceptRequest") {
    $stmt = Connection::$PDO->prepare("INSERT INTO verbindung (idNachhilfenehmer, idNachhilfelehrer, idFach, kostenfrei) VALUES (:idNehmer, :idLehrer, :idFach, :kostenfrei)");
    $stmt->bindParam(':idNehmer', $sender_id);
    $stmt->bindParam(':idLehrer', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->bindParam(':idFach', $fach_id);
    $stmt->bindParam(':kostenfrei', $kostenfrei);
    $stmt->execute();

    $stmt = Connection::$PDO->prepare("DELETE FROM anfrage WHERE idAnfrage = :idAnfrage");
    $stmt->bindParam(':idAnfrage', $request_id);
    $stmt->execute();

    $stmt = Connection::$PDO->prepare("INSERT INTO benachrichtigung (idBenutzer, titel, inhalt) VALUES (:idBenutzer, :titel, :inhalt)");
    $stmt->bindParam(':idBenutzer', $sender_id);
    $stmt->bindValue(':titel', "Anfrage angenommen!");
    $stmt->bindValue(':inhalt', "Ein Nachhilfelehrer hat deine Anfrage angenommen!");
}
else if($response == "denyRequest") {
    if($kostenfrei == 1) {

        $stmt = Connection::$PDO->prepare("SELECT * FROM anfrage WHERE idSender = :idSender AND idEmpfänger = :idEmpfang");
        $stmt->bindParam(':idSender', $sender_id);
        $stmt->bindParam(':idEmpfang', Benutzer::get_logged_in_user()->idBenutzer);
        $stmt->execute();
        $form_helper->response['requests'] = $stmt->fetchAll(PDO::FETCH_CLASS, 'Anfrage');

        $stmt = Connection::$PDO->prepare("DELETE FROM anfrage WHERE idSender = :idSender AND idEmpfänger = :idEmpfang");
        $stmt->bindParam(':idSender', $sender_id);
        $stmt->bindParam(':idEmpfang', Benutzer::get_logged_in_user()->idBenutzer);
        $stmt->execute();
    }
    else{
        $stmt = Connection::$PDO->prepare("DELETE FROM anfrage WHERE idAnfrage = :idAnfrage");
        $stmt->bindParam(':idAnfrage', $request_id);
        $stmt->execute();

        $stmt = Connection::$PDO->prepare("INSERT INTO benachrichtigung (idBenutzer, titel, inhalt) VALUES (:idBenutzer, :titel, :inhalt)");
        $stmt->bindParam(':idBenutzer', $sender_id);
        $stmt->bindValue(':titel', "Anfrage abgelehnt!");
        $stmt->bindValue(':inhalt', "Ein Nachhilfelehrer hat deine Anfrage abgelehnt!");
    }
}

$form_helper->success = true;
$form_helper->return_json();
?>
