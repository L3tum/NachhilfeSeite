---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 18:56
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Verbindung.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";
include_once __DIR__ . "/../assets/php/dbClasses/AngebotenesFach.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("deleteSubject")) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idFach = :idSubject");
    $stmt->bindParam(':idSubject', $_POST['id']);
    $stmt->execute();
    $connections = $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
    if (isset($connections) && $connections != null && count($connections) > 0) {
        $stmt = Connection::$PDO->prepare("SELECT * FROM angebotenesfach WHERE idFach = :idSubject");
        $stmt->bindParam(':idSubject', $_POST['id']);
        $stmt->execute();
        $people = $stmt->fetchAll(PDO::FETCH_CLASS, 'AngebotenesFach');
        $name = Fach::get_by_id($_POST['id'])->name;
        if (isset($people) && $people != null && count($people) > 0) {
            foreach ($people as $peoples) {
                Benachrichtigung::add($peoples->idBenutzer, "Angebotenes Fach gelöscht", "Das angebotene Fach " . $name . " wurde gelöscht, da ein Administrator das Fach gelöscht hat!", true);
            }
        }
        $stmt = Connection::$PDO->prepare("DELETE FROM angebotenesfach WHERE idFach = :idSubject");
        $stmt->bindParam(':idSubject', $_POST['id']);
        $stmt->execute();
        $form_helper->success = false;
        $form_helper->return_error("Es gibt noch Verbindungen mit diesem Fach! Diese müssen erst gelöscht werden.");
    }
    else {
        $stmt = Connection::$PDO->prepare("DELETE FROM fach WHERE idFach = :idSubject");
        $stmt->bindParam(':idSubject', $_POST['id']);
        $stmt->execute();

        $form_helper->response['id'] = $_POST['id'];
        $form_helper->success = true;
        $form_helper->return_json();
    }
} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}