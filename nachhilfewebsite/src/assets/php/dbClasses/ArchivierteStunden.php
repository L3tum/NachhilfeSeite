<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 27.08.2017
 * Time: 14:38
 */

include_once __DIR__ . "/Stunde.php";

class ArchivierteStunden{

    public $id;
    public $studentName;
    public $teacherName;
    public $datum;
    public $zeit;
    public $fach;
    public $kostenfrei;


    public static function getAll(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    //text
    public static function getAllByStudentName($stdName){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE studentName = :studentName");
        $stmt->bindParam(':studentName', $stdName);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    //text
    public static function getAllByTeacherName($teaName){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE teacherName = :teacherName");
        $stmt->bindParam(':teacherName', $teaName);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    //text
    public static function getAllByStudentAndTeacherNameAndDate($stdName, $teaName, $date){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE studentName = :studentName AND teacherName = :teacherName AND DATE_FORMAT(datum, '%m.%Y') = DATE_FORMAT(:date, '%m.%Y')");
        $stmt->bindParam(':studentName', $stdName);
        $stmt->bindParam(':teacherName', $teaName);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    //text
    public static function getAllByStudentAndTeacherNameAndDateAndSubject($stdName, $teaName, $date, $subject){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE studentName = :studentName AND teacherName = :teacherName AND DATE_FORMAT(datum, '%m.%Y') = DATE_FORMAT(:date, '%m.%Y') AND fach = :fach");
        $stmt->bindParam(':studentName', $stdName);
        $stmt->bindParam(':teacherName', $teaName);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':fach', $subject);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    //date object
    public static function getAllByDate($date){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE datum = :date");
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    //text
    public static function getAllBySubject($subject){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE fach = :fach");
        $stmt->bindParam(':fach', $subject);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    //Free: Entweder 'kostenfrei' oder 'nein'
    public static function getAllByFree($free){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE kostenfrei = :kostenfrei");
        $stmt->bindParam(':kostenfrei', $free);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }
    public static function getAllByNameAndDate($name, $date){
        $stmt = Connection::$PDO->prepare("SELECT * FROM archivierteStunden WHERE DATE_FORMAT(datum, '%m.%Y') = :date AND (studentName = :name OR teacherName = :name)");
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'ArchivierteStunden');
    }

    public static function add($stdName, $teaName, $datum, $zeit, $fach, $kostenfrei){
        $stmt = Connection::$PDO->prepare("INSERT INTO archivierteStunden (studentName, teacherName, datum, zeit, fach, kostenfrei) VALUES(:stdName, :teaName, :date, :zeit, :fach, :kostenfrei)");
        $stmt->bindParam(':stdName', $stdName);
        $stmt->bindParam(':teaName', $teaName);
        $stmt->bindParam(':date', $datum);
        $stmt->bindParam(':zeit', $zeit);
        $stmt->bindParam(':fach', $fach);
        $stmt->bindParam(':kostenfrei', $kostenfrei);
        $stmt->execute();
    }

    public static function Update()
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE bestaetigtSchueler = TRUE AND bestaetigtLehrer = TRUE AND akzeptiert = TRUE");
        $stmt->execute();
        $hours = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde');
        if(isset($hours) && $hours != false) {
            foreach ($hours as $hour) {
                $connection = Verbindung::get_by_id($hour->idVerbindung);
                $std = Benutzer::get_by_id($connection->idNachhilfenehmer);
                $stdName = $std->vorname . " " . $std->name;
                $tea = Benutzer::get_by_id($connection->idNachhilfelehrer);
                $teaName = $tea->vorname . " " . $tea->name;
                $fach = Fach::get_by_id($connection->idFach)->name;
                $kostenfrei = $hour->kostenfrei == 1 ? 'kostenfrei' : 'nein';
                $date = date('d.m.Y', strtotime($hour->datum));
                $zeit = date('H:i:s', strtotime($hour->datum));
                ArchivierteStunden::add($stdName, $teaName, $date, $zeit, $fach, $kostenfrei);
                Stunde::deleteStunde($hour->idStunde);
            }
        }

        $stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE DATE_FORMAT(datum, '%d.%m.%Y') < :today AND akzeptiert = FALSE");
        $stmt->bindParam(':today', date("d.m.Y H:i:s"));
        $stmt->execute();
        $hours = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde');
        if(isset($hours) && $hours != false) {
            foreach ($hours as $hour){
                Stunde::deleteStunde($hour->idStunde);
            }
        }

        $last = date('d.m.Y', strtotime('-7 days'));
        $stmt = Connection::$PDO->prepare("SELECT * FROM stunde WHERE DATE_FORMAT(datum, '%d.%m.%Y') < :last AND akzeptiert = TRUE AND (bestaetigtSchueler = FALSE OR bestaetigtLehrer = FALSE)");
        $stmt->bindParam(':last', $last);
        $stmt->execute();
        $hours = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stunde');
        if(isset($hours) && $hours != false){
            foreach ($hours as $hour){
                if($hour->bestaetigtSchueler == false){
                    Benachrichtigung::add($hour->idNachhilfenehmer, "Stunde bestätigen!", "Du hast eine Stunde, die schon mehr als eine Woche alt ist, noch nicht bestätigt!");
                }
                if($hour->bestaetigtLehrer == false){
                    Benachrichtigung::add($hour->idNachhilfelehrer, "Stunde bestätigen!", "Du hast eine Stunde, die schon mehr als eine Woche alt ist, noch nicht bestätigt!");
                }
            }
        }
    }
}