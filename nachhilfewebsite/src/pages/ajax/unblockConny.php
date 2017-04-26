---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.04.2017
 * Time: 14:43
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/general/Connection.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Verbindung.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Stunde.php";

$form_helper = new AjaxFormHelper();
Verbindung::unblock($_POST['id']);
Stunde::unblock_appos_connection($_POST['id']);
$form_helper->success = true;
$form_helper->return_json();