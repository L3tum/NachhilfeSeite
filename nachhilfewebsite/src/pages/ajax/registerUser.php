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
    error_reporting ( E_ERROR );
    $hash = openssl_encrypt ($_POST['email'], "aes-256-ofb", $secret);
    error_reporting ( E_ERROR | E_WARNING | E_PARSE);

    if ($stmt->execute() == true) {
        
        $form_helper->send_mail($email, $subject, $body);
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