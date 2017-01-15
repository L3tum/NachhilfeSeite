---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 09.01.2017
 * Time: 18:22
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$permission = $_POST['permission'];

$form_helper->response['permission'] = Benutzer::get_logged_in_user()->has_permission($permission);
$form_helper->success = true;
$form_helper->return_json();