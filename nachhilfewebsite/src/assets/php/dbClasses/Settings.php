<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 13.04.2017
 * Time: 15:17
 */

include_once __DIR__ . "/../general/Connection.php";
include_once __DIR__ . "/../general/tldextract.php";

class Settings{
    public static function getSettings(){
        $stmt = Connection::$PDO->prepare("SELECT * FROM settings");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }
    public static function add($setting, $type){
        $stmt = Connection::$PDO->prepare("ALTER TABLE settings ADD " . $setting . " ". $type);
        $stmt->bindParam(':setting', $setting);
        $stmt->bindParam(':type', $type);
        return $stmt->execute();
    }
    public static function getSetting($setting){
        return Settings::getSettings()[$setting];
    }
    public static function setSetting($name, $value){
        $stmt = Connection::$PDO->prepare("UPDATE settings SET " . $name . " = :value");
        $stmt->bindValue(':value', $value);
        return $stmt->execute();
    }
    public static function check_if_int_and_return_int($value){
        if(!is_int($value)){
            if(is_numeric($value)){
                return intval($value);
            }
        }
        return $value;
    }
}