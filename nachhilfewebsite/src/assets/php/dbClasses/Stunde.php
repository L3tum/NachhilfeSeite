<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:28
 */
class Stunde
{

    public $idStunde;
    public $bezahltLehrer;
    public $raumNummer;
    public $idVerbindung;
    public $datum;
    public $kommentar;
    public $findetStatt;
    public $bestaetigtSchueler;
    public $bestaetigtLehrer;
    public $bezahltAdmin;

    public static function stundeExists($idAndererBenutzer, $idFach, $date, $time, $idRoom){
        $endTime = date("H:i:s", strtotime("+45 minutes", strtotime($time)));
        $datumsZeit = $date. " ".$time;
        $newDatumsZeit = $date. " ".$endTime;
        $stmt = Connection::$PDO->prepare("SELECT stunde.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung WHERE stunde.findetStatt=1 (verbindung.idNachhilfelehrer= :idBenutzer OR verbindung.idNachhilfenehmer = :idBenutzer) AND (verbindung.idNachhilfelehrer = :idandererBenutzer OR verbindung.idNachhilfenehmer = :idandererBenutzer) AND verbindung.idFach = :idFach AND stunde.raumNummer= :raumNummer AND stunde.datum between :oldDate AND :newDate");
        $stmt->bindParam(':idBenutzer', Benutzer::get_logged_in_user()->idBenutzer);
        $stmt->bindParam(':idandererBenutzer', $idAndererBenutzer);
        $stmt->bindParam(':idFach', $idFach);
        $stmt->bindParam(':raumNummer', $idRoom);
        $stmt->bindParam(':oldDate', $datumsZeit);
        $stmt->bindParam(':newDate', $newDatumsZeit);
        $stmt->execute();
        $stunden = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde');
        if($stunden != null && count($stunden) > 0){
            return true;
        }
        else{
            return false;
        }
    }
}