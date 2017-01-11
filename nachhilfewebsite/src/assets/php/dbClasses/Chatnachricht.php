<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:24
 */
class Chatnachricht
{

    public $idEmpfänger;
    public $idSender;
    public $inhalt;
    public $gelesen;
    public $idChatnachricht;

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
}