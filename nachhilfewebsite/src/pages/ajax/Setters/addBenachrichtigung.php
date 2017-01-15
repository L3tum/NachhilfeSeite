---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 18:13
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benachrichtigung.php";

if(!isset($_POST['idBenutzer'], $_POST['titel'], $_POST['inhalt'])){
    $form_helper->return_error("Nicht alle Parameter gesetzt!");
    exit();
}
$form_helper = new AjaxFormHelper();
Benachrichtigung::add($_POST['idBenutzer'], $_POST['titel'], $_POST['inhalt']);
$form_helper->response['titel'] = $_POST['titel'];
$form_helper->success = true;
$form_helper->return_json();