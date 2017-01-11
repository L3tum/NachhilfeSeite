<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:31
 */
class AngebotenesFach
{

    public $idBenutzer;
    public $idFach;

    public static function get_offered_subjects(){
        $stmt = Connection::$PDO->prepare("SELECT DISTINCT f.idFach, f.name FROM fach as f LEFT JOIN angebotenesfach ON angebotenesfach.idFach=f.idFach");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');
    }
}