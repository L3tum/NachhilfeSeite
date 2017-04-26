<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:24
 */

include_once __DIR__ . "/../general/AjaxFormHelper.php";
include_once __DIR__ . "/../general/Connection.php";
include_once __DIR__ . "/Benutzer.php";

class Chatnachricht
{

    public $idEmpfänger;
    public $idSender;
    public $inhalt;
    public $gelesen;
    public $idChatnachricht;
    public $datum;

    public static function get_all_messages_between($senderId, $recieverId, $markRead = true) {

        $stmt = Connection::$PDO->prepare("SELECT * FROM chatnachricht WHERE (idSender = :idBenutzer1 AND idEmpfänger = :idBenutzer2) OR (idEmpfänger = :idBenutzer1 AND idSender = :idBenutzer2) ORDER BY datum DESC");
        $stmt->bindParam(':idBenutzer1', $senderId);
        $stmt->bindParam(':idBenutzer2', $recieverId);
        $stmt->execute();

        $messages = $stmt->fetchAll(PDO::FETCH_CLASS, 'Chatnachricht');

        if($markRead) {
            $stmt = Connection::$PDO->prepare("UPDATE chatnachricht SET gelesen = TRUE WHERE idEmpfänger = :idEmpfaenger AND idSender = :idSender");
            $stmt->bindParam(':idEmpfaenger', $recieverId);
            $stmt->bindParam(':idSender', $senderId);
            $stmt->execute();
        }

        return $messages;
    }
    public static function add($reciever_id, $content){
        $form_helper = new AjaxFormHelper();
        $content = $form_helper->test_string($content, "/^[\s\S]{1,500}$/", "Nachricht");

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

        $recieve_user->set_notified(false);
    }
}