---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 01.05.2017
 * Time: 13:46
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Settings.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
if (Benutzer::get_logged_in_user()->has_permission("set_settings")) {
    $bool = true;
    $names = $_POST['names'];
    $values = $_POST['values'];
    for($i = 0; $i < count($names); $i++){
        $value = $values[$i];
        if(isset($value) && $value != ""){
            if(is_numeric($value) && !is_int($value)){
                $value = intval($value);
            }
            if(Settings::setSetting($names[$i], $value) == false){
                $bool = false;
            }
        }
    }
    if($bool == false){
        $form_helper->return_error("Etwas ist schief gelaufen!");
    }else {
        $form_helper->success = true;
        $form_helper->return_json();
    }
} else {
    $form_helper->return_error("Keine Zugriffrechte!");
}