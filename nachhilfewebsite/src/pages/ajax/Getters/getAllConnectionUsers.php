---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 23:31
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$current_user = Benutzer::get_logged_in_user();
$others = $current_user->get_all_connections_single();
$form_helper->response['users'] = $others;
$form_helper->success = true;
$form_helper->return_json();
