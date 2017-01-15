---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 18:41
 */

include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/dbClasses/Fach.php";

$form_helper = new AjaxFormHelper();
$form_helper->response['subjects'] = Fach::get_all_subjects();
$form_helper->success = true;
$form_helper->return_json();