<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:27
 */
class Verbindung
{

    public $idVerbindung;
    public $idNachhilfenehmer;
    public $idNachhilfelehrer;
    public $idFach;
    public $blockiert;
    public $kostenfrei;

    public function is_first() {
        $stmt = Connection::$PDO->prepare("SELECT * FROM `verbindung` WHERE idVerbindung = (SELECT idVerbindung FROM verbindung WHERE idNachhilfenehmer = :idNehmer ORDER BY idVerbindung ASC LIMIT 1) && idVerbindung = :idVerbindung");
        $stmt->bindParam(':idNehmer', $this->idNachhilfenehmer);
        $stmt->bindParam(':idVerbindung', $this->idVerbindung);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Verbindung');
        return $stmt->fetch() != false;
    }

    public static function get_id_by_ids($idandererBenutzer, $idFach){
        $stmt = Connection::$PDO->prepare("SELECT verbindung.idVerbindung FROM verbindung WHERE (verbindung.idNachhilfelehrer= :idBenutzer OR verbindung.idNachhilfenehmer = :idBenutzer) AND (verbindung.idNachhilfelehrer = :idandererBenutzer OR verbindung.idNachhilfenehmer = :idandererBenutzer) AND verbindung.idFach = :idFach");
        $stmt->bindParam(':idBenutzer', Benutzer::get_logged_in_user()->idBenutzer);
        $stmt->bindParam(':idandererBenutzer', $idandererBenutzer);
        $stmt->bindParam(':idFach', $idFach);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Verbindung');
        return $stmt->fetch();
    }

    public static function get_by_user_ids($idBenutzer, $idAndererBenutzer){
        $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE (verbindung.idNachhilfelehrer= :idBenutzer OR verbindung.idNachhilfenehmer = :idBenutzer) AND (verbindung.idNachhilfelehrer = :idandererBenutzer OR verbindung.idNachhilfenehmer = :idandererBenutzer)");
        $stmt->bindParam(':idBenutzer', $idBenutzer);
        $stmt->bindParam(':idandererBenutzer', $idAndererBenutzer);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');
    }

    public static function is_teacher($idBenutzer, $idVerbindung){
        $stmt = Connection::$PDO->prepare("SELECT * FROM verbindung WHERE idVerbindung = :idVerbindung");
        $stmt->bindParam(':idVerbindung', $idVerbindung);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Verbindung');
        $verbindung = $stmt->fetch();
        if($idBenutzer == $verbindung->idNachhilfelehrer){
            return true;
        }
        else{
            return false;
        }
    }

    public static function is_first_connection($idVerbindung, $idBenutzer){
        return Verbindung::get_by_id($idVerbindung)->kostenfrei;
    }

    public function has_appointments(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE idVerbindung = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $this->idVerbindung);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Stunde');
        $user = $stmt->fetch();
        return $user;
    }

    public static function get_by_id($idVerbindung){
        $stmt = Connection::$PDO->prepare("SELECT * FROM Verbindung WHERE idVerbindung = :idBenutzer");
        $stmt->bindParam(':idBenutzer', $idVerbindung);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Verbindung');
        $user = $stmt->fetch();
        return $user;
    }
    public static function block($idVerbindung){
        $stmt = Connection::$PDO->prepare("UPDATE verbindung SET verbindung.blockiert=1 WHERE verbindung.idVerbindung = :idVerbindung");
        $stmt->bindParam(':idVerbindung', $idVerbindung);
        $stmt->execute();
    }
    public static function unblock($idVerbindung){
        $connection = Verbindung::get_by_id($idVerbindung);
        if(Fach::get_by_id($connection->idFach)->blockiert == 0) {
            $stmt = Connection::$PDO->prepare("UPDATE verbindung SET verbindung.blockiert=0 WHERE verbindung.idVerbindung = :idVerbindung");
            $stmt->bindParam(':idVerbindung', $idVerbindung);
            $stmt->execute();
        }
    }
}