<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 17.12.2016
 * Time: 20:16
 */

session_start();
header('Set-Cookie: "PHPSESSID' . session_id() . ';path=/"');

include_once __DIR__ . "/Connection.php";
include_once __DIR__ . "/tldextract.php";
include_once __DIR__ . "/../dbClasses/Benutzer.php";
include_once __DIR__ . "/../dbClasses/Settings.php";
include_once __DIR__ . "/../PHPMailer/PHPMailerAutoload.php";

class AjaxFormHelper
{

    //response array. Contains all data that should get sent back to JS
    public $response = Array();
    public $success;

    function __construct()
    {

        $this->set_up_defaults();

    }

    public function set_up_defaults()
    {
        //Connect to database
        if (!Connection::connect(false)) {
            $this->return_error("Keine Verbindung zur Datenbank!");
        }
    }

    //return an error message and success false
    public function return_error($text)
    {

        $this->success = false;
        $this->response['errorReason'] = $text;
        $this->return_json();
    }

    //return the current response array as json
    public function return_json()
    {

        $this->response['success'] = $this->success;
        echo json_encode($this->response);
        exit;
    }

    //Check if the string is set and if it matches the regex pattern. Real name is a human readable name of the variable.
    public function test_string($string, $pattern, $realname)
    {

        if (isset($string)) {
            if (!preg_match($pattern, $string)) {
                $this->return_error($realname . " entspricht nicht den Kritierien!");
            }
            return $string;
        } else {
            $this->return_error($realname . " ist nicht gesetzt!");
        }

    }

    //Check if string exists and matches pattern, otherwise just null. Easier for search form
    public function test_search_string($string, $pattern, $realname)
    {
        $string = trim($string, '\'');
        if (isset($string)) {
            if (!preg_match($pattern, $string)) {
                return null;
            }
            return "'%" . $string . "%'";
        } else {
            return null;
        }
    }

    public function test_numeric($number)
    {
        $number = trim($number, '\'');
        if (is_numeric($number)) {
            return $number;
        }
        return null;
    }

    public function get_user_by_external_id($id)
    {
        if (!ctype_digit($id)) {
            $this->return_error("Interner Fehler: ID ist keine Zahl");
        } else {
            return Benutzer::get_by_id($id);
        }
    }

    public function send_mail($email, $subject, $body)
    {
        //Send mail using gmail
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 465; // set the SMTP port for the GMAIL server
        $mail->Username = "nachhilfegylo@gmail.com"; // GMAIL username
        $mail->Password = "NSsrQ(@aMmd(57nEFW8r"; // GMAIL password

//Typical mail data
        $mail->AddAddress($email);
        $mail->SetFrom('admin@gylo-nachhilfe.de', "Nachhilfe");
        $mail->Subject = $subject;
        $mail->Body = $body;

        try {
            $mail->Send();
        } catch (Exception $e) {
            return_error($e->getMessage());
        }
    }
}