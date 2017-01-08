<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 18.12.2016
 * Time: 10:21
 */
class Berechtigung
{

    public $idBerechtigung;
    public $name;

    public static function get_all_rights(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM berechtigung");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Berechtigung');
    }
}