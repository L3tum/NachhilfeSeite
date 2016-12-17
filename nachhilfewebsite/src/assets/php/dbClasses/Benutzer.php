<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:20
 */

include_once  __DIR__ . "/../general/Connection.php";

class Benutzer
{

    public $idBenutzer;
    public $vorname;
    public $name;
    public $email;
    public $passwort;
    public $telefonnummer;
    public $gesperrt;
    public $sessionID;
    public $idRolle;

    public static function get_logged_in_user() {
        $session_id = session_id();
        $stmt = Connection::$PDO->prepare("SELECT * FROM Benutzer WHERE sessionID = :sessionID");
        $stmt->bindParam(':sessionID', $session_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
        $user = $stmt->fetch();
        echo var_dump($user);
        if($user !== null) {

        }
        return null;
    }

    public static function log_user_in($user) {

    }
}