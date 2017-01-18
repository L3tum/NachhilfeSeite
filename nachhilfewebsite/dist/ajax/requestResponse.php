
<?php
include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$response = $_POST['response'];
$form_helper = new AjaxFormHelper();
$request_id = $_POST['idRequest'];
$sender_id = $_POST['idSendingUser'];;
$fach_id = $_POST['idFach'];

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
    $stmt = Connection::$PDO->prepare("INSERT INTO verbindung (idNachhilfenehmer, idNachhilfelehrer, idFach) VALUES (:idNehmer, :idLehrer, :idFach)");
    $stmt->bindParam(':idNehmer', $sender_id);
    $stmt->bindParam(':idLehrer', Benutzer::get_logged_in_user()->idBenutzer);
    $stmt->bindParam(':idFach', $fach_id);
    $stmt->execute();

    $stmt = Connection::$PDO->prepare("DELETE FROM anfrage WHERE idAnfrage = :idAnfrage");
    $stmt->bindParam(':idAnfrage', $request_id);
    $stmt->execute();
}
else if($response == "denyRequest") {
    $stmt = Connection::$PDO->prepare("DELETE FROM anfrage WHERE idAnfrage = :idAnfrage");
    $stmt->bindParam(':idAnfrage', $request_id);
    $stmt->execute();
}

$form_helper->success = true;
$form_helper->return_json();
?>

