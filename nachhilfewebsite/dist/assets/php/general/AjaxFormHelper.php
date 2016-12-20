<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 17.12.2016
 * Time: 20:16
 */

include_once __DIR__ . "/Connection.php";
class AjaxFormHelper
{

    public $response = Array();
    public $success;

    function __construct() {

        $this->set_up_defaults();

    }

    public function set_up_defaults() {

        if(!Connection::connect(false)) {
            $this->return_error("Keine Verbindung zur Datenbank!");
        }
        session_start();
    }

    public function return_error($text) {

        $this->success = false;
        $this->response['errorReason'] = $text;
        $this->return_json();
    }

    public function return_json() {

        $this->response['success'] = $this->success;
        echo json_encode($this->response);
        exit;
    }

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
}