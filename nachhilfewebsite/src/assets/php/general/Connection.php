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
    private static $DSN = "mysql:host=mysql5.gymnasium-lohmar.webseiten.cc;dbname=db299111_20;mysql:charset=UTF-8";
    private static $DBUser = "db299111_20";
    private static $DBPass = '4fsz4gyh7Z$a';

    public static function connect($redirectOnError) {
        try {
            self::$PDO = new PDO(self::$DSN, self::$DBUser, self::$DBPass, array(
                PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" //Keep the connection since we won't use another one
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