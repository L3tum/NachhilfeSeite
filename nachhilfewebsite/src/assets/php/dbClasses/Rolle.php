<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:22
 */
class Rolle
{

    public $idRolle;
    public $name;
    public $beschreibung;

    public function get_rechte(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM berechtigung as t1 JOIN rollenberechtigung as t2 on t2.idBerechtigunge=t1.idBerechtigung WHERE t2.idRolle= :idRolle");
        $stmt->bindParam(':idRolle', $this->idRolle);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Berechtigung');
    }
    public static function get_rechte_static($idRolle){
        $stmt = Connection::$PDO->prepare("SELECT * FROM berechtigung as t1 JOIN rollenberechtigung as t2 on t2.idBerechtigunge=t1.idBerechtigung WHERE t2.idRolle= :idRolle");
        $stmt->bindParam(':idRolle', $idRolle);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Berechtigung');
    }
}