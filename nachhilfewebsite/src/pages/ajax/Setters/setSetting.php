---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 01.05.2017
 * Time: 18:25
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Settings.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("add_settings")) {
    $setting_name = $form_helper->test_string($_POST['name'], "/^[a-zA-ZÄÖÜäöüß ]{1,100}$/", "Vorname");
    $setting_value = $_POST['value'];
    $form_helper->success = Settings::add($setting_name, $setting_value);
    $form_helper->return_json();
} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}