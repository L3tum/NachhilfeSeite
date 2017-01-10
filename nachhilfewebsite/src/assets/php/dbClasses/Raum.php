<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:29
 */
class Raum
{

    public $raumNummer;

    public static function get_all_rooms(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM raum");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Raum');
    }
}