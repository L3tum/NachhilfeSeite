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

    public static function get_by_id($id) {

        if(isset($id)) {
            $stmt = Connection::$PDO->prepare("SELECT * FROM Fach WHERE idFach = :idFach");
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
}