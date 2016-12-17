<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 16.12.2016
 * Time: 19:38
 */

include_once  __DIR__ . "/ConfigStrings.php";

class Connection
{

    public static $PDO;
    private static $DSN = "mysql:host=localhost;dbname=nachhilfe";
    private static $DBUser = "nachhilfeDBUser";
    private static $DBPass = "nachhilfe";

    public static function connect($redirectOnError) {
        try {
            self::$PDO = new PDO(self::$DSN, self::$DBUser, self::$DBPass, array(
                PDO::ATTR_PERSISTENT => true
            ));
            return true;
        } catch (Exception $e) {
            if($redirectOnError) {
                include "special/noDBConnection.php";
            }
            return false;
        }

    }


}