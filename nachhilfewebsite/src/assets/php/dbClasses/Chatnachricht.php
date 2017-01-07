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
    public $titel;
    public $inhalt;
    public $gelesen;

    public static function get_all_messages_between($senderId, $recieverId, $markRead = true) {

        $stmt = Connection::$PDO->prepare("SELECT * FROM chatnachricht WHERE idSender = :idBenutzer1S OR idSender = :idBenutzer2S OR idEmpfänger = :idBenutzer1E OR idEmpfänger = :idBenutzer2E");
        $stmt->bindParam(':idBenutzer1S', $senderId);
        $stmt->bindParam(':idBenutzer2S', $recieverId);

        $stmt->bindParam(':idBenutzer1E', $senderId);
        $stmt->bindParam(':idBenutzer2E', $recieverId);
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