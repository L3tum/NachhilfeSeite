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
    //Needed to specify details about the connection to the PDO interface
    private static $DSN = "mysql:host=localhost;dbname=nachhilfe";
    private static $DBUser = "nachhilfeDBUser";
    private static $DBPass = "nachhilfe";

    public static function connect($redirectOnError) {
        try {
            self::$PDO = new PDO(self::$DSN, self::$DBUser, self::$DBPass, array(
                PDO::ATTR_PERSISTENT => true //Keep the connection since we won't use another one
            ));
            return true;
        } catch (Exception $e) {
            if($redirectOnError) {
                include "special/noDBConnection.php"; //display the error page when the connection fails
            }
            return false;
        }

    }


}