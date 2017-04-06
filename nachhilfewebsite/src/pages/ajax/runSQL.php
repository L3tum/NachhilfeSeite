---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 05.02.2017
 * Time: 14:11
 */

include_once __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$ajax_form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("execute_sql")){
    $stmt = Connection::$PDO->prepare($_POST['sql']);
    $stmt->execute();
    $ajax_form_helper->success = true;
    $ajax_form_helper->return_json();
}