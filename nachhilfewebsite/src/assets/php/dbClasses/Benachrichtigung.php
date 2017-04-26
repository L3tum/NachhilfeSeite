<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 14.12.2016
 * Time: 22:25
 */

include_once  __DIR__ . "/../PHPMailer/PHPMailerAutoload.php";
include_once  __DIR__ . "/../dbClasses/Benutzer.php";

class Benachrichtigung
{

    public $idBenutzer;
    public $titel;
    public $inhalt;
    public $idBenachrichtigung;

    public static function get_all_by_user($idBenutzer){
        $stmt = Connection::$PDO->prepare("SELECT * FROM benachrichtigung WHERE idBenutzer= :idBenutzer");
        $stmt->bindParam(':idBenutzer', $idBenutzer);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Benachrichtigung');
    }

    public static function add($idBenutzer, $titel, $inhalt, $email = false){
        $logged_in = Benutzer::get_logged_in_user();
        $stmt = Connection::$PDO->prepare("INSERT INTO benachrichtigung (idBenutzer, titel, inhalt) VALUES(:idBenutzer, :titel, :inhalt)");
        $stmt->bindParam(':idBenutzer', $idBenutzer);
        $stmt->bindParam(':titel', $titel);
        $stmt->bindParam(':inhalt', $inhalt);
        $stmt->execute();
        $benutzer = Benutzer::get_by_id($idBenutzer);
        if($email == true && $benutzer->wantsEmails) {
            Benachrichtigung::send_mail(Benutzer::get_by_id($idBenutzer)->email, $titel, $inhalt);
        }
        $benutzer->set_notified(false);
    }

    public static function send_mail($email, $subject, $body) {
        //Send mail using gmail
        $mail = new PHPMailer;
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

        try{
            $mail->Send();
        } catch(Exception $e){

            return_error("Email konnte nicht gesendet werden!");
        }
    }
}