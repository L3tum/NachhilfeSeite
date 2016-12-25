<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 17.12.2016
 * Time: 20:16
 */

include_once __DIR__ . "/Connection.php";
include_once  __DIR__ . "/../dbClasses/Benutzer.php";
class AjaxFormHelper
{

    //response array. Contains all data that should get sent back to JS
    public $response = Array();
    public $success;

    function __construct() {

        $this->set_up_defaults();

    }

    public function set_up_defaults() {

        //Connect to database
        if(!Connection::connect(false)) {
            $this->return_error("Keine Verbindung zur Datenbank!");
        }
        //Start the session to do account related things
        session_start();
    }

    //return an error message and success false
    public function return_error($text) {

        $this->success = false;
        $this->response['errorReason'] = $text;
        $this->return_json();
    }

    //return the current response array as json
    public function return_json() {

        $this->response['success'] = $this->success;
        echo json_encode($this->response);
        exit;
    }

    //Check if the string is set and if it matches the regex pattern. Real name is a human readable name of the variable.
    public function test_string($string, $pattern, $realname) {

        if(isset($string)) {
            if(!preg_match($pattern, $string)) {
                $this->return_error($realname . " entspricht nicht den Kritierien!");
            }
            return $string;
        }
        else {
            $this->return_error($realname . " ist nicht gesetzt!");
        }

    }

    //Check if string exists and matches pattern, otherwise just null. Easier for search form
    public function test_search_string($string, $pattern, $realname){
        if(isset($string)) {
            if(!preg_match($pattern, $string)) {
                return null;
            }
            return $string;
        }
        else {
            return null;
        }
    }

    public function get_user_by_external_id($id) {
        if(!ctype_digit($id)) {
            $this->return_error("Interner Fehler: ID ist keine Zahl");
        }
        else {
            return Benutzer::get_by_id($id);
        }
    }
}