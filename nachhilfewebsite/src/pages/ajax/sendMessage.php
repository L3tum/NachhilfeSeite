---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 09.01.2017
 * Time: 22:34
 */

include_once __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/general/ConfigStrings.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/dbClasses/Chatnachricht.php";

$form_helper = new AjaxFormHelper();

Chatnachricht::add($_POST['reciever'], $_POST['content']);

$form_helper->success = true;
$form_helper->return_json();
?>