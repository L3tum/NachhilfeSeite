<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:26
 */
class Qualifikation
{

    public $idQualifikation;
    public $idBenutzer;
    public $name;
    public $beschreibung;

    public function get_all_quals(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM qualifikation");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Qualifikation');
    }
}