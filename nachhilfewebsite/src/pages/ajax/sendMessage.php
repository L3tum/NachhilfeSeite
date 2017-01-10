<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 09.01.2017
 * Time: 22:34
 */

include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$content = $form_helper->test_string($_POST['content'], "/^[a-zA-ZÄÖÜ*]{1,500}$/", "Nachricht");
