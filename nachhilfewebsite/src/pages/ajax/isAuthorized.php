---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 23.03.2017
 * Time: 16:59
 */

include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";

$form_helper = new AjaxFormHelper();

$current = Benutzer::get_logged_in_user();
if(isset($current) && $current != false && $current->name=="Pauly" && $current->vorname=="Tom"){
    $form_helper->response['authorized'] = true;
}
else{
    $form_helper->response['authorized'] = false;
}
$form_helper->success = true;
$form_helper->return_json();