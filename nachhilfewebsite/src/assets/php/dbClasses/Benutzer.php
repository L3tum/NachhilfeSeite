<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:20
 */

include_once __DIR__ . "/../general/Connection.php";
include_once __DIR__ . "/Berechtigung.php";
include_once __DIR__ . "/Rolle.php";
include_once __DIR__ . "/Fach.php";
include_once __DIR__ . "/Stufe.php";
include_once __DIR__ . "/Verbindung.php";
include_once __DIR__ . "/Anfrage.php";
include_once __DIR__ . "/Qualifikation.php";

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
    public $rollenname;
    public $emailActivated;

    private $permissions;
    private $roleName;
    private $roleID;
    private static $currentlyLoggedIn;

    //Get a user by his ID
    public static function get_by_id($id)
    {

        if (isset($id)) {
            $stmt = Connection::$PDO->prepare("SELECT * FROM Benutzer WHERE idBenutzer = :idBenutzer");
            $stmt->bindParam(':idBenutzer', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
            $user = $stmt->fetch();
            return $user;
        }
    }

    //Get the currently logged in user (if there is one)
    public static function get_logged_in_user()
    {

        if (!isset(self::$currentlyLoggedIn)) {

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
    public function log_in()
    {

        session_regenerate_id();
        $session_id = session_id();
        $stmt = Connection::$PDO->prepare("UPDATE benutzer SET sessionID = :sessionID WHERE idBenutzer = :idBenutzer");
        $stmt->bindParam(':sessionID', $session_id);
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
    }

    public function log_out()
    {

        session_regenerate_id();
        $stmt = Connection::$PDO->prepare("UPDATE benutzer SET sessionID = :sessionID WHERE idBenutzer = :idBenutzer");
        $nullsid = "0";
        $stmt->bindParam(':sessionID', $nullsid);
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
    }

    private function get_user_permissions()
    {

        $stmt = Connection::$PDO->prepare("SELECT Berechtigung.* FROM Berechtigung LEFT JOIN RollenBerechtigung ON RollenBerechtigung.idRolle = :idRolle && RollenBerechtigung.idBerechtigung = Berechtigung.idBerechtigung WHERE Berechtigung.idBerechtigung = RollenBerechtigung.idBerechtigung");
        $stmt->bindParam(':idRolle', $this->idRolle);
        $stmt->execute();

        $permissions = Array();
        foreach ($stmt->fetchAll(PDO::FETCH_CLASS, 'Berechtigung') as $permission) {
            $permissions[$permission->name] = true;
        }
        return $permissions;
    }

    public function has_permission($permission)
    {

        if (!isset($this->permissions)) {
            $this->permissions = $this->get_user_permissions();
        }
        if (isset($this->permissions[$permission])) {
            return true;
        } else {
            return false;
        }
    }

    public function get_role()
    {

        if (!isset($this->roleName)) {
            $stmt = Connection::$PDO->prepare("SELECT * FROM Rolle WHERE idRolle = :idRolle");
            $stmt->bindParam(':idRolle', $this->idRolle);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Rolle');
            $rolle = $stmt->fetch();
            $this->roleName = $rolle->name;
        }
        return $this->roleName;
    }

    public function get_role_id(){
        if (!isset($this->roleID)) {
            $stmt = Connection::$PDO->prepare("SELECT * FROM Rolle WHERE idRolle = :idRolle");
            $stmt->bindParam(':idRolle', $this->idRolle);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Rolle');
            $rolle = $stmt->fetch();
            $this->roleID = $rolle->idRolle;
        }
        return $this->roleID;
    }

    public function get_offered_subjects()
    {

        $stmt = Connection::$PDO->prepare("SELECT * FROM fach JOIN angebotenesfach ON angebotenesfach.idBenutzer = :idBenutzer WHERE angebotenesfach.idFach = fach.idFach");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');
    }

    public function offers_subject($idSubject)
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM angebotenesfach WHERE angebotenesfach.idFach = " . $idSubject . " AND angebotenesFach.idBenutzer=" . $this->idBenutzer);
        $stmt->execute();

        $subject = $stmt->fetch();
        if ($subject != null) {
            return true;
        }
        return false;
    }

    public function offers_year($idClass)
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM angebotenestufe WHERE angebotenestufe.idStufe = " . $idClass . " AND angebotenestufe.idBenutzer=" . $this->idBenutzer);
        $stmt->execute();

        $subject = $stmt->fetch();
        if ($subject != null) {
            return true;
        }
        return false;
    }

    public function get_offered_classes()
    {

        $stmt = Connection::$PDO->prepare("SELECT * FROM stufe JOIN angebotenestufe ON angebotenestufe.idBenutzer = :idBenutzer WHERE angebotenestufe.idStufe = stufe.idStufe");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Stufe');
    }

    public function get_tutiution_connections($user)
    {

        $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfenehmer = :idAndererBenutzer && verbindung.idNachhilfelehrer = :idBenutzer OR verbindung.idNachhilfelehrer = :idAndererBenutzer && verbindung.idNachhilfenehmer = :idBenutzer");
        $stmt->bindParam(':idAndererBenutzer', $user->idBenutzer);
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
    }

    public function get_all_tutiution_connections()
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfelehrer = :idBenutzer OR verbindung.idNachhilfenehmer = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
    }

    public function has_tutiution_connection($user_id, $fach)
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE verbindung.idNachhilfelehrer = :idAndererBenutzer AND verbindung.idNachhilfenehmer = :idBenutzer AND verbindung.idFach = :idFach");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->bindParam(':idAndererBenutzer', $user_id);
        $stmt->bindParam(':idFach', $fach);
        $stmt->execute();

        $tutiution = $stmt->fetch();
        if ($tutiution != null) {
            return true;
        }
        return false;
    }

    public function get_all_anfragen()
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM anfrage WHERE anfrage.idSender = :idBenutzer OR anfrage.idEmpfänger = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Anfrage');
    }

    public function get_anfragen($user_id)
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM anfrage WHERE anfrage.idSender = :idAndererBenutzer AND anfrage.idEmpfänger = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->bindParam(':idAndererBenutzer', $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Anfrage');
    }

    public function has_anfrage($user_id, $fach)
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM anfrage WHERE anfrage.idSender = :idBenutzer AND anfrage.idEmpfänger = :idAndererBenutzer AND anfrage.idFach = :idFach");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->bindParam(':idAndererBenutzer', $user_id);
        $stmt->bindParam(':idFach', $fach);
        $stmt->execute();

        $anfrage = $stmt->fetch();
        if ($anfrage != null) {
            return true;
        }
        return false;
    }

    public function get_all_qualifications()
    {
        $stmt = Connection::$PDO->prepare("SELECT t1.name, t1.beschreibung, t1.idQualifikation FROM qualifikation AS t1 JOIN benutzer AS t2 ON t2.idBenutzer=t1.idBenutzer WHERE t1.idBenutzer=" . $this->idBenutzer);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Qualifikation');
    }

    public function get_all_appointments_as_teacher(){
        $stmt = Connection::$PDO->prepare("SELECT stunde.*, t3.idBenutzer as idBenutzer, t3.vorname as vorname, t3.name as name FROM stunde JOIN verbindung as v ON stunde.idVerbindung=v.idVerbindung JOIN benutzer as t1 ON t1.idBenutzer=v.idNachhilfelehrer JOIN benutzer as t3 ON t3.idBenutzer=v.idNachhilfenehmer WHERE v.idNachhilfelehrer = :idBenutzer AND (stunde.datum >= NOW() OR stunde.bezahltLehrer=0)");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_all_appointments_as_pupil(){
        $stmt = Connection::$PDO->prepare("SELECT stunde.*, t1.idBenutzer as idBenutzer, t1.vorname as vorname, t1.name as name FROM stunde JOIN verbindung as v ON stunde.idVerbindung=v.idVerbindung JOIN benutzer as t1 ON t1.idBenutzer=v.idNachhilfelehrer JOIN benutzer as t3 ON t3.idBenutzer=v.idNachhilfenehmer WHERE v.idNachhilfenehmer = :idBenutzer AND (stunde.datum >= NOW() OR stunde.bezahltLehrer=0)");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function has_qual($idQual){
        $stmt = Connection::$PDO->prepare("SELECT * FROM qualifikation JOIN benutzer ON benutzer.idBenutzer=qualifikation.idBenutzer WHERE qualifikation.idQualifikation = :idQual AND qualifikation.idBenutzer = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->bindParam(':idQual', $idQual);
        $stmt->execute();

        $anfrage = $stmt->fetch();
        if ($anfrage != null) {
            return true;
        }
        return false;
    }

    public function get_connection_other(){
        $stmt = Connection::$PDO->prepare("SELECT t1.idBenutzer as einsID, t1.vorname as einsvorname, t1.name as einsname, t2.idBenutzer as zweiID, t2.vorname as zweivorname, t2.name as zweiname FROM benutzer as t1 JOIN verbindung as v ON t1.idBenutzer=v.idNachhilfelehrer JOIN benutzer as t2 ON t2.idBenutzer=v.idNachhilfenehmer WHERE (v.idNachhilfenehmer = :idBenutzer OR v.idNachhilfelehrer= :idBenutzer)");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_connection_other_by_subject($idSubject){
        $stmt = Connection::$PDO->prepare("SELECT t1.idBenutzer as einsID, t1.vorname as einsvorname, t1.name as einsname, t2.idBenutzer as zweiID, t2.vorname as zweivorname, t2.name as zweiname FROM benutzer as t1 JOIN verbindung as v ON t1.idBenutzer=v.idNachhilfelehrer JOIN benutzer as t2 ON t2.idBenutzer=v.idNachhilfenehmer WHERE (v.idNachhilfenehmer = :idBenutzer OR v.idNachhilfelehrer= :idBenutzer) AND v.idFach = :idFach");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->bindParam(':idFach', $idSubject);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function is_blocked(){
        $stmt = Connection::$PDO->prepare("SELECT benutzer.gesperrt as gesperrt FROM benutzer WHERE idBenutzer = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch()['gesperrt'];
    }

    public function get_all_connections_single(){
        $connections = $this->get_connection_other();

        $others = Array();
        $i = 0;
        foreach ($connections as $connection) {
            if ($connection{'einsID'} == $this->idBenutzer) {
                $others[$i] = Array();
                $others[$i]['ID'] = $connection['zweiID'];
                $others[$i]['vorname'] = $connection['zweivorname'];
                $others[$i]['name'] = $connection['zweiname'];
            } else {
                $others[$i] = Array();
                $others[$i]['ID'] = $connection['einsID'];
                $others[$i]['vorname'] = $connection['einsvorname'];
                $others[$i]['name'] = $connection['einsname'];
            }
            $i++;
        }
        return $others;
    }
    public function get_all_connections_single_by_subject($idSubject){
        $connections = $this->get_connection_other_by_subject($idSubject);
        $others = Array();

        $i = 0;
        foreach ($connections as $connection) {
            if ($connection{'einsID'} == $this->idBenutzer) {
                $others[$i] = Array();
                $others[$i]['ID'] = $connection['zweiID'];
                $others[$i]['vorname'] = $connection['zweivorname'];
                $others[$i]['name'] = $connection['zweiname'];
            } else {
                $others[$i] = Array();
                $others[$i]['ID'] = $connection['einsID'];
                $others[$i]['vorname'] = $connection['einsvorname'];
                $others[$i]['name'] = $connection['einsname'];
            }
            $i++;
        }
        return $others;
    }
}