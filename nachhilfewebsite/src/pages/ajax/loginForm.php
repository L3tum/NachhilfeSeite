---
layout: noLayout
---

<?php
include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";

$form_helper = new AjaxFormHelper;
$form_helper->return_error("TEST");
//$vorname = $_POST['vorname'];
//$vorname = $_POST['vorname'];
//echo Benutzer::get_logged_in_user();
?>