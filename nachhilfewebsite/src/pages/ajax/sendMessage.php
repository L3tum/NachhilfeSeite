---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 09.01.2017
 * Time: 22:34
 */

include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$content = $form_helper->test_string($_POST['content'], "/^[\s\S]{1,500}$/", "Nachricht");

$reciever_id = $_POST['reciever'];
$recieve_user = $form_helper->get_user_by_external_id($reciever_id);
if(!$recieve_user) {

    $form_helper->return_error("Interner Fehler: Kein Nutzer mit dieser ID gefunden.");
}

$stmt = Connection::$PDO->prepare('INSERT INTO chatnachricht (idSender, idEmpfänger, inhalt) VALUES (:idSender, :idEmpfaenger, :inhalt)');
$stmt->bindParam(':idSender', Benutzer::get_logged_in_user()->idBenutzer);
$stmt->bindParam(':idEmpfaenger', $recieve_user->idBenutzer);
$stmt->bindParam(':inhalt', $content);
$stmt->execute();


$stmt = Connection::$PDO->prepare('DELETE FROM chatnachricht WHERE idChatnachricht NOT IN (
    SELECT idChatnachricht
  FROM (
      SELECT idChatnachricht
    FROM chatnachricht
    WHERE idSender = :idSender OR idEmpfänger = :idSender OR idSender = :idEmpfaenger OR idEmpfänger = :idEmpfaenger 
    ORDER BY datum DESC
    LIMIT 10 -- keep this many records
  ) foo
);');

//$stmt = Connection::$PDO->prepare('DELETE FROM chatnachricht ORDER BY datum DESC LIMIT 10');
$stmt->bindParam(':idSender', Benutzer::get_logged_in_user()->idBenutzer);
$stmt->bindParam(':idEmpfaenger', $recieve_user->idBenutzer);

$stmt->execute();

$form_helper->success = true;
$form_helper->return_json();
?>