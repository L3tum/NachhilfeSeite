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
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/general/Route.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/ConfigStrings.php";
$form_helper = new AjaxFormHelper();
if (!isset($_POST['user']) || (!isset($_POST['faecher']) && !isset($_POST['firstConnection']) && !isset($_POST['firstRequest']))) {
    $form_helper->return_error("Fach oder Benutzer ungültig!");
}
$user_id = $_POST['user'];
$user = Benutzer::get_by_id($user_id);
if (!$user) {
    $form_helper->return_error("Benutzer ungültig!");
}
$errorMessage = "";
$logged_in = Benutzer::get_logged_in_user();
if (isset($_POST['firstConnection'])) {
    $pays_self = false;
    $pays_self = $logged_in->get_first_anfrage() == false ? false : true;

    $newFirstConnection = $logged_in->get_tuition_connection($user_id, $_POST['firstConnection']);

    if (!$pays_self) {
        $firstConnection = $logged_in->get_first_connection();

        //has first connection already and its not the same
        if ($firstConnection != false && $firstConnection->idVerbindung != $newFirstConnection->idVerbindung) {
            $stmt = Connection::$PDO->prepare("UPDATE verbindung SET kostenfrei=0 WHERE idVerbindung = :id");
            $stmt->bindParam(':id', $firstConnection->idVerbindung);
            $stmt->execute();

            $stmt = Connection::$PDO->prepare("UPDATE verbindung SET kostenfrei=1 WHERE idVerbindung = :id");
            $stmt->bindParam(':id', $_POST['firstConnection']);
            $stmt->execute();
        }
        //Has first connection already but its the same
        else if($firstConnection != false && $firstConnection->idVerbindung == $newFirstConnection->idVerbindung){

        }
        //Doesnt have first connection
        else{
            $stmt = Connection::$PDO->prepare("UPDATE verbindung SET kostenfrei=1 WHERE idVerbindung = :id");
            $stmt->bindParam(':id', $_POST['firstConnection']);
            $stmt->execute();
        }
        $pays_self = true;
    }
    else{
        $errorMessage .= "Es wurde bereits eine kostenlose Anfrage gesendet! \n";
    }
}
if (isset($_POST['firstRequest'])) {
    if (!$pays_self) {
        $firstRequest = $logged_in->get_first_anfrage();

        $newFirstRequest = $logged_in->get_anfrage($user_id, $_POST['firstRequest']);

        //Has first request already
        if ($firstRequest != false) {
            //new first request is already a request
            if($newFirstRequest != false){
                //Old and new first requests are not the same
                if($firstRequest->idAnfrage != $newFirstRequest->idAnfrage){
                    $stmt = Connection::$PDO->prepare("UPDATE anfrage SET kostenfrei=0 WHERE idAnfrage = :id");
                    $stmt->bindParam(':id', $firstRequest->idAnfrage);
                    $stmt->execute();

                    $stmt = Connection::$PDO->prepare("UPDATE anfrage SET kostenfrei=1 WHERE idAnfrage = :id");
                    $stmt->bindParam(':id', $newFirstRequest->idAnfrage);
                    $stmt->execute();
                }
                //Are the same (nothing happens)
            }
            //New first request does not exist, but old does
            else{
                $stmt = Connection::$PDO->prepare("UPDATE anfrage SET kostenfrei=0 WHERE idAnfrage = :id");
                $stmt->bindParam(':id', $firstRequest->idAnfrage);
                $stmt->execute();

                $stmt = Connection::$PDO->prepare("INSERT INTO anfrage (idSender, idEmpfänger, idFach, kostenfrei) VALUES(:idBenutzer, :idAndererBenutzer, :idFach, 1)");
                $stmt->bindParam(':idBenutzer', $logged_in->idBenutzer);
                $stmt->bindParam(':idAndererBenutzer', $user_id);
                $stmt->bindParam(':idFach', $_POST['firstRequest']);
                $stmt->execute();
            }
        }
        //Old first request does not exist, but new does
        else if($newFirstRequest != false){
            $stmt = Connection::$PDO->prepare("UPDATE anfrage SET kostenfrei=1 WHERE idAnfrage = :id");
            $stmt->bindParam(':id', $newFirstRequest->idAnfrage);
            $stmt->execute();
        }
        //Neither already exist
        else{
            $stmt = Connection::$PDO->prepare("INSERT INTO anfrage (idSender, idEmpfänger, idFach, kostenfrei) VALUES(:idBenutzer, :idAndererBenutzer, :idFach, 1)");
            $stmt->bindParam(':idBenutzer', $logged_in->idBenutzer);
            $stmt->bindParam(':idAndererBenutzer', $user_id);
            $stmt->bindParam(':idFach', $_POST['firstRequest']);
            $stmt->execute();
        }
        $pays_self = true;
    }
}

if(isset($_POST['faecher'])) {
    $faecher = $_POST['faecher'];

    foreach ($faecher as $fach) {
        if ($logged_in->has_anfrage($user_id, $fach)) {
            $form_helper->return_error("Du hast bereits eine Anfrage geschickt!");
            exit();
        } else if ($logged_in->has_tutiution_connection($user_id, $fach)) {
            $form_helper->return_error("Du hast bereits eine Nachhilfeverbindung mit diesem Benutzer!");
            exit();
        }
        $stmt = Connection::$PDO->prepare("INSERT INTO anfrage (anfrage.idSender, anfrage.idEmpfänger, anfrage.idFach, anfrage.kostenfrei) VALUES( :idSender , :idEmpfaenger , :idFach , :kostenfrei )");
        $stmt->bindParam(':idSender', Benutzer::get_logged_in_user()->idBenutzer);
        $stmt->bindParam(':idEmpfaenger', $user_id);
        $stmt->bindParam(':idFach', $fach);
        $stmt->bindValue(':kostenfrei', !$pays_self);
        $stmt->execute();
        $pays_self = true;
    }
}
if ($user->wantsEmails) {
    $subject = "Nachhilfeanfrage von {$logged_in->vorname} {$logged_in->name}";
    $body = "Du hast eine Nachhilfeanfrage von {$logged_in->vorname} {$logged_in->name} im Nachhilfeportal bekommen!";
    $form_helper->send_mail($user->email, $subject, $body);
}
$user->set_notified(false);
$form_helper->success = true;
$form_helper->return_json();
?>