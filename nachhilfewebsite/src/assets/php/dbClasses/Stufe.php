<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:30
 */
class Stufe
{

    public $idStufe;
    public $name;

    public static function get_all_years()
    {
        $stmt = Connection::$PDO->prepare("SELECT * FROM Stufe");
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_CLASS, 'Stufe');
        return $user;
    }
}