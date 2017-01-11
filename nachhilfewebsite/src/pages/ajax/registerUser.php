---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 05.01.2017
 * Time: 14:08
 */

include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Route.php";
include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/PHPMailer/PHPMailerAutoload.php";

$mail = new PHPMailer;

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("registerNewUser")) {
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email = $_POST['email'];
    $rolle = $_POST['rolle'];

    $stmt = Connection::$PDO->prepare("INSERT INTO benutzer (vorname, name, email, passwort, idRolle) VALUES( :vorname , :nachname , :email , :password , :rolle )");
    $stmt->bindParam(':vorname', $vorname);
    $stmt->bindParam(':nachname', $nachname);
    $stmt->bindParam(':email', $email);
    $stmt->bindValue(':password', "Null");
    $stmt->bindParam(':rolle', $rolle);

    $secret = "52df1c3b0748b09539d64a781fda";
    $hash = md5($_POST['email'].$secret);


    if (true) {



        //Send mail using gmail
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
        $mail->Subject = "Registrierung bei der Nachhilfe des Gymnasiums Lohmar";
        $mail->Body = "Danke für deine Registerierung! Um diese abzuschließen, klicke bitte auf den Link:" . Route::get_root() . "verifyEmail/" . $hash;

        try{
            $mail->Send();
            echo "Success!";
        } catch(Exception $e){
            //Something went bad
            echo "Fail - " . $mail->ErrorInfo;
        }

        $form_helper->success = true;
        $form_helper->response['name'] = $vorname . " " . $nachname;
        $form_helper->return_json();
    } else {
        $form_helper->return_error("Registrierung fehlgeschlagen!");
    }
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}
?>