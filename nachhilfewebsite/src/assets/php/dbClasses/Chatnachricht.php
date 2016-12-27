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

        $stmt = Connection::$PDO->prepare("SELECT * FROM chatnachricht WHERE idSender = :idBenutzer1 OR idSender = :idBenutzer2 OR idEmpfänger = :idBenutzer1 OR idEmpfänger = :idBenutzer2");
        $stmt->bindParam(':idBenutzer1', $senderId);
        $stmt->bindParam(':idBenutzer2', $recieverId);
        $stmt->execute();

        if($markRead) {
            $stmt = Connection::$PDO->prepare("UPDATE chatnachricht SET gelesen = TRUE WHERE idEmpfänger = :idEmpfänger AND idSender = :idSender");
            $stmt->bindParam(':idEmpfänger', $recieverId);
            $stmt->bindParam(':idSender', $senderId);
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Chatnachricht');
    }
}