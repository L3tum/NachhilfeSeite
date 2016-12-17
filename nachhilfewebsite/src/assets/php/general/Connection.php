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

    public static function connect($redirectOnError) {
        if(ConfigStrings::get("DSN") !== null) {

            try {
                Connection::$PDO = new PDO(ConfigStrings::get("DSN"),ConfigStrings::get("DBUser"),ConfigStrings::get("DBPass"), array(
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


}