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
    public $raumNummer;
    public $idVerbindung;
    public $datum;
    public $kommentar;
    public $bestaetigtSchueler;
    public $bestaetigtLehrer;
    public $akzeptiert;
    public $lehrerVorgeschlagen;

    public static function stundeExists($idAndererBenutzer, $idFach, $date, $time, $idRoom){
        $endTime = date("H:i:s", strtotime("+45 minutes", strtotime($time)));
        $datumsZeit = $date. " ".$time;
        $newDatumsZeit = $date. " ".$endTime;
        $stmt = Connection::$PDO->prepare("SELECT stunde.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung WHERE stunde.akzeptiert=1 AND (verbindung.idNachhilfelehrer= :idBenutzer OR verbindung.idNachhilfenehmer = :idBenutzer) AND (verbindung.idNachhilfelehrer = :idandererBenutzer OR verbindung.idNachhilfenehmer = :idandererBenutzer) AND verbindung.idFach = :idFach AND stunde.raumNummer= :raumNummer AND stunde.datum between :oldDate AND :newDate");
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

    public static function deleteStunde($idStunde){
        $stmt = Connection::$PDO->prepare("DELETE FROM stunde WHERE idStunde = :idStunde");
        $stmt->bindParam(':idStunde', $idStunde);
        $stmt->execute();
    }
    public static function get_all_lessons($date){
        if ($date != "") {
            $stmt = Connection::$PDO->prepare("SELECT t1.vorname as studentVorname, t1.name as studentName, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer WHERE DATE_FORMAT(stunde.datum, '%Y-%m')= :datum ORDER BY stunde.datum");
            $stmt->bindParam(':datum', $date);
        }
        else{
            $stmt = $stmt = Connection::$PDO->prepare("SELECT t1.vorname as studentVorname, t1.name as studentName, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer ORDER BY stunde.datum");
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function get_lessons_by_user_date($date, $user_id){
        if ($date != "") {
            $stmt = Connection::$PDO->prepare("SELECT verbindung.idNachhilfenehmer as idStudent, t1.vorname as studentVorname, t1.name as studentName, verbindung.idNachhilfelehrer as idTeacher, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert, verbindung.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer WHERE DATE_FORMAT(stunde.datum, '%Y-%m')= :datum AND (verbindung.idNachhilfenehmer = :idBenutzer OR verbindung.idNachhilfelehrer = :idBenutzer) ORDER BY stunde.datum GROUP BY verbindung.idVerbindung");
            $stmt->bindParam(':datum', $date);
        }
        else{
            $stmt = $stmt = Connection::$PDO->prepare("SELECT verbindung.idNachhilfenehmer as idStudent, t1.vorname as studentVorname, t1.name as studentName, verbindung.idNachhilfelehrer as idTeacher, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert, verbindung.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer WHERE (verbindung.idNachhilfenehmer = :idBenutzer OR verbindung.idNachhilfelehrer = :idBenutzer) ORDER BY stunde.datum");
        }
        $stmt->bindParam(':idBenutzer', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_lessons_by_user_date_connection($date, $idVerbindung){
        if ($date != "") {
            $stmt = Connection::$PDO->prepare("SELECT verbindung.idNachhilfenehmer as idStudent, t1.vorname as studentVorname, t1.name as studentName, verbindung.idNachhilfelehrer as idTeacher, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert, verbindung.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer WHERE DATE_FORMAT(stunde.datum, '%Y-%m')= :datum AND verbindung.idVerbindung= :idVerbindung ORDER BY stunde.datum");
            $stmt->bindParam(':datum', $date);
        }
        else{
            $stmt = $stmt = Connection::$PDO->prepare("SELECT verbindung.idNachhilfenehmer as idStudent, t1.vorname as studentVorname, t1.name as studentName, verbindung.idNachhilfelehrer as idTeacher, t2.vorname as teacherVorname, t2.name as teacherName, DATE_FORMAT(stunde.datum, '%d.%m.%Y %T') as date, stunde.bestaetigtSchueler, stunde.bestaetigtLehrer, stunde.akzeptiert, verbindung.* FROM stunde JOIN verbindung ON verbindung.idVerbindung=stunde.idVerbindung JOIN benutzer as t1 ON verbindung.idNachhilfenehmer=t1.idBenutzer JOIN benutzer as t2 ON verbindung.idNachhilfelehrer=t2.idBenutzer WHERE verbindung.idVerbindung= :idVerbindung ORDER BY stunde.datum");
        }
        $stmt->bindParam(':idVerbindung', $idVerbindung);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function block_appos_connection($idVerbindung){
        $stmt = Connection::$PDO->prepare("UPDATE stunde SET stunde.akzeptiert=-1 WHERE stunde.idVerbindung = :idVerbindung");
        $stmt->bindParam(':idVerbindung', $idVerbindung);
        $stmt->execute();
    }
}