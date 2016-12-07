<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 07.12.2016
 * Time: 22:10
 */
class Config{

    private static $registry = Array();

    public static function set($key,$value){
        self::$registry[$key] = $value;
    }

    public static function get($key){
        if(array_key_exists($key,self::$registry)){
            return self::$registry[$key];
        }
        return false;
    }
}
