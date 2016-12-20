
<?php
include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();

$vorname = $form_helper->test_string($_POST['vorname'], "/^[a-zA-ZÄÖÜ*]{1,20}$/", "Vorname");
$nachname = $form_helper->test_string($_POST['nachname'], "/^[a-zA-ZÄÖÜ*]{1,20}$/", "Nachname");
$password = $form_helper->test_string($_POST['password'], "/^.{1,200}$/", "Passwort");

$stmt = Connection::$PDO->prepare("SELECT * FROM benutzer WHERE vorname = :vorname && name = :name && passwort = :passwort");
$stmt->bindParam(':vorname', $vorname);
$stmt->bindParam(':name', $nachname);
$stmt->bindParam(':passwort', $password);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Benutzer');
$user = $stmt->fetch();

if(!$user) {
    $form_helper->return_error("Passwort oder Nutzername falsch!");
}

$user->log_in();

$form_helper->success = true;
$form_helper->return_json();
?>
