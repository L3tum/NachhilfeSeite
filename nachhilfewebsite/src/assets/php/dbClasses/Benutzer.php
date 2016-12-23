<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:20
 */

include_once  __DIR__ . "/../general/Connection.php";
include_once  __DIR__ . "/Berechtigung.php";
include_once  __DIR__ . "/Rolle.php";
include_once  __DIR__ . "/Fach.php";
include_once  __DIR__ . "/Stufe.php";
include_once  __DIR__ . "/Verbindung.php";

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

    private $permissions;
    private $roleName;
    private static $currentlyLoggedIn;

    //Get a user by his ID
    public static function get_by_id($id) {

        if(isset($id)) {
            $stmt = Connection::$PDO->prepare("SELECT * FROM Benutzer WHERE idBenutzer = :idBenutzer");
            $stmt->bindParam(':idBenutzer', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
            $user = $stmt->fetch();
            return $user;
        }
    }

    //Get the currently logged in user (if there is one)
    public static function get_logged_in_user() {

        if(!isset(self::$currentlyLoggedIn)) {

            $session_id = session_id();
            $stmt = Connection::$PDO->prepare("SELECT * FROM Benutzer WHERE sessionID = :sessionID");
            $stmt->bindParam(':sessionID', $session_id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
            $user = $stmt->fetch();
            self::$currentlyLoggedIn = $user;
        }
        return self::$currentlyLoggedIn;

    }

    //Set the session id to the current session id
    public function log_in() {

        session_regenerate_id();
        $session_id = session_id();
        $stmt = Connection::$PDO->prepare("UPDATE benutzer SET sessionID = :sessionID WHERE idBenutzer = :idBenutzer");
        $stmt->bindParam(':sessionID', $session_id);
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
    }

    public function log_out() {

        session_regenerate_id();
        $stmt = Connection::$PDO->prepare("UPDATE benutzer SET sessionID = :sessionID WHERE idBenutzer = :idBenutzer");
        $nullsid = "0";
        $stmt->bindParam(':sessionID', $nullsid);
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
    }

    private function get_user_permissions() {

        $stmt = Connection::$PDO->prepare("SELECT Berechtigung.* FROM Berechtigung LEFT JOIN RollenBerechtigung ON RollenBerechtigung.idRolle = :idRolle && RollenBerechtigung.idBerechtigung = Berechtigung.idBerechtigung WHERE Berechtigung.idBerechtigung = RollenBerechtigung.idBerechtigung");
        $stmt->bindParam(':idRolle', $this->idRolle);
        $stmt->execute();

        $permissions = Array();
        foreach ($stmt->fetchAll(PDO::FETCH_CLASS, 'Berechtigung') as $permission) {
            $permissions[$permission->name] = true;
        }
        return $permissions;
    }

    public function has_permission($permission) {

        if(!isset($this->permissions)) {
            $this->permissions = $this->get_user_permissions();
        }
        if(isset($this->permissions[$permission])) {
            return true;
        }
        else {
            return false;
        }
    }

    public function get_role() {

        if(!isset($this->roleName)) {
            $stmt = Connection::$PDO->prepare("SELECT * FROM Rolle WHERE idRolle = :idRolle");
            $stmt->bindParam(':idRolle', $this->idRolle);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Rolle');
            $rolle = $stmt->fetch();
            $this->roleName = $rolle->name;
        }
        return $this->roleName;
    }

    public function get_offered_subjects() {

        $stmt = Connection::$PDO->prepare("SELECT * FROM fach JOIN angebotenesfach ON angebotenesfach.idBenutzer = :idBenutzer WHERE angebotenesfach.idFach = fach.idFach");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');
    }

    public function get_offered_classes() {

        $stmt = Connection::$PDO->prepare("SELECT * FROM stufe JOIN angebotenestufe ON angebotenestufe.idBenutzer = :idBenutzer WHERE angebotenestufe.idStufe = stufe.idStufe");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Stufe');
    }

    public function get_tutiution_connections($user) {

        $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfenehmer = :idAndererBenutzer && verbindung.idNachhilfelehrer = :idBenutzer OR verbindung.idNachhilfelehrer = :idAndererBenutzer && verbindung.idNachhilfenehmer = :idBenutzer");
        $stmt->bindParam(':idAndererBenutzer', $user->idBenutzer);
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
    }



}