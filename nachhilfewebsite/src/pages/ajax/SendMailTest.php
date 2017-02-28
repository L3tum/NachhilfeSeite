---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 26.02.2017
 * Time: 13:58
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$ajax_form_helper = new AjaxFormHelper();
$ajax_form_helper->response["hi"] = $ajax_form_helper->send_mail("nachhilfegylo@gmail.com", "Test", "Dies ist ein Test.Danke");
$ajax_form_helper->success = true;
$ajax_form_helper->return_json();
