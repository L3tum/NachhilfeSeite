---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 03.02.2017
 * Time: 12:58
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$current_user = Benutzer::get_logged_in_user();
$connection = $current_user->get_first_connection();
$form_helper->response['firstConnection'] = $connection==false? false : true;
$form_helper->success = true;
$form_helper->return_json();