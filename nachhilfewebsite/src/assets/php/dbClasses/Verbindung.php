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
    public $kostenfrei;

    public static function get_id_by_ids($idandererBenutzer, $idFach){
        $stmt = Connection::$PDO->prepare("SELECT verbindung.idVerbindung FROM verbindung WHERE (verbindung.idNachhilfelehrer= :idBenutzer OR verbindung.idNachhilfenehmer = :idBenutzer) AND (verbindung.idNachhilfelehrer = :idandererBenutzer OR verbindung.idNachhilfenehmer = :idandererBenutzer) AND verbindung.idFach = :idFach");
        $stmt->bindParam(':idBenutzer', Benutzer::get_logged_in_user()->idBenutzer);
        $stmt->bindParam(':idandererBenutzer', $idandererBenutzer);
        $stmt->bindParam(':idFach', $idFach);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Verbindung');
        return $stmt->fetch();
    }
}