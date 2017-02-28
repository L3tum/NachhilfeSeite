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

    public static function get_by_id($idRole){
        $stmt = Connection::$PDO->prepare("SELECT * FROM rolle WHERE rolle.idRolle = ".intval($idRole));
        $stmt->bindValue(':idRolle', intval($idRole));
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Rolle');
        $rolle = $stmt->fetch();
        return $rolle;
    }

    public function get_rechte(){
        $stmt = Connection::$PDO->prepare("SELECT t1.idBerechtigung, t1.name FROM berechtigung as t1 JOIN rollenberechtigung as t2 on t2.idBerechtigung=t1.idBerechtigung WHERE t2.idRolle=".intval($this->idRolle));
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Berechtigung');
    }
    public static function get_rechte_static($idRolle){
        $stmt = Connection::$PDO->prepare("SELECT * FROM berechtigung as t1 JOIN rollenberechtigung as t2 on t2.idBerechtigung=t1.idBerechtigung WHERE t2.idRolle= :idRolle");
        $stmt->bindValue(':idRolle', intval($idRolle));
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Berechtigung');
    }
    public static function get_all_roles(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM rolle");
        $stmt->execute();
        $rolle = $stmt->fetchAll(PDO::FETCH_CLASS, 'Rolle');
        return $rolle;
    }

    public function has_right($right){
        $stmt = Connection::$PDO->prepare("SELECT * FROM rollenberechtigungen JOIN rolle as t1 ON t1.idRolle=rollenberechtigung.idRolle WHERE t1.idRolle= :idRolle AND rollenberechtigung.idBerechtigung= :right");
    }
}