<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:25
 */
class Benachrichtigung
{

    public $idBenutzer;
    public $titel;
    public $inhalt;
    public $idBenachrichtigung;

    public static function get_all_by_user($idBenutzer){
        $stmt = Connection::$PDO->prepare("SELECT * FROM benachrichtigung WHERE idBenutzer= :idBenutzer");
        $stmt->bindParam(':idBenutzer', $idBenutzer);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Benachrichtigung');
    }

    public static function add($idBenutzer, $titel, $inhalt){
        $stmt = Connection::$PDO->prepare("INSERT INTO benachrichtigung (idBenutzer, titel, inhalt) VALUES(:idBenutzer, :titel, :inhalt)");
        $stmt->bindParam(':idBenutzer', $idBenutzer);
        $stmt->bindParam(':titel', $titel);
        $stmt->bindParam(':inhalt', $inhalt);
        $stmt->execute();
    }
}