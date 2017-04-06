---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 25.03.2017
 * Time: 14:16
 */

include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../../assets/php/dbClasses/Rolle.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("administration")){
    $form_helper->response['roles'] = Rolle::get_all_roles();
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("No permission");
}