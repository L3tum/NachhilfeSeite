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

}