<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 13.04.2017
 * Time: 15:17
 */

include_once __DIR__ . "/../general/Connection.php";
include_once __DIR__ . "/../general/tldextract.php";

class Settings{
    public $maxNumberOfFreeLessonsPerWeek;
    public $maxNumberOfStudents;

    public static function getSettings(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM settings");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Settings');
        return $stmt->fetch();
    }
}