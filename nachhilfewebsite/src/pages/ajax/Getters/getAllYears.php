---
layout: noLayout
---


<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 19:23
 */

include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/dbClasses/Stufe.php";

$form_helper = new AjaxFormHelper();
$form_helper->response['years'] = Stufe::get_all_years();
$form_helper->success = true;
$form_helper->return_json();