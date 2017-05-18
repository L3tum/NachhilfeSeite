---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 01.05.2017
 * Time: 12:36
 */

include_once __DIR__ . "/../../assets/php/dbClasses/Settings.php";
include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if(Benutzer::get_logged_in_user()->has_permission("set_settings")) {
    $form_helper->response['settings'] = array();
    $stmt = Connection::$PDO->prepare("SELECT COLUMN_NAME FROM information_schema.columns where table_schema = DATABASE() and table_name = 'settings'");
    $stmt->execute();
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    foreach ($settings as $setting){
        $value = Settings::getSetting($setting['COLUMN_NAME']);
        $form_helper->response['settings'][$i]['name'] = $setting['COLUMN_NAME'];
        $form_helper->response['settings'][$i]['current'] = $value;
        $i++;
    }
    $form_helper->success = true;
    $form_helper->return_json();
}
else{
    $form_helper->return_error("Keine Zugriffrechte!");
}