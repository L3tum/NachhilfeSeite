
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 19:25
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/AngeboteneStufe.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benachrichtigung.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("deleteYear")) {
    $stmt = Connection::$PDO->prepare("SELECT * FROM angebotenestufe WHERE idStufe = :idStufe");
    $stmt->bindParam(':idStufe', $_POST['id']);
    $stmt->execute();
    $people = $stmt->fetchAll(PDO::FETCH_CLASS, 'AngeboteneStufe');
    if (isset($people) && $people != null && count($people) > 0) {
        foreach ($people as $peoples) {
            Benachrichtigung::add($peoples->idBenutzer, "Angebotene Stufe gelöscht", "Eine angebotene Stufe wurde gelöscht, da ein Administrator die Stufe gelöscht hat!");
        }
    }
    $stmt = Connection::$PDO->prepare("DELETE FROM angebotenestufe WHERE idStufe = :idStufe");
    $stmt->bindParam(':idStufe', $_POST['id']);
    $stmt->execute();

    $stmt = Connection::$PDO->prepare("DELETE FROM stufe WHERE idStufe = :idStufe");
    $stmt->bindParam(':idStufe', $_POST['id']);
    $stmt->execute();

    $form_helper->response['id'] = $_POST['id'];
    $form_helper->success = true;
    $form_helper->return_json();
} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}
