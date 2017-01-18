
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 17.01.2017
 * Time: 17:28
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
$stmt = Connection::$PDO->prepare("UPDATE stunde SET akzeptiert=1 WHERE idStunde = :idStunde");
$stmt->bindParam(':idStunde', $_POST['id']);
$stmt->execute();
$form_helper->success = true;
$form_helper->return_json();
