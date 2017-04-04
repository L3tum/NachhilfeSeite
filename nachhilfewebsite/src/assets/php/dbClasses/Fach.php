<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:30
 */
class Fach
{

    public $idFach;
    public $name;
    public $blockiert;

    public static function get_by_id($id) {

        if(isset($id)) {
            $stmt = Connection::$PDO->prepare("SELECT * FROM fach WHERE idFach = :idFach");
            $stmt->bindParam(':idFach', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Fach');
            $user = $stmt->fetch();
            return $user;
        }
    }

    public static function get_all_subjects(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM Fach");
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_CLASS, 'Fach');
        return $user;
    }
    public static function get_by_name($name){
        $stmt = Connection::$PDO->prepare("SELECT * FROM fach WHERE name= :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Fach');
        return $stmt->fetch();
    }
}