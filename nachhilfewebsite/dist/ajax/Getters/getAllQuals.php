
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 12:41
 */

include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$form_helper->response['quals'] = Benutzer::get_by_id($_POST['id'])->get_all_qualifications();
$form_helper->success = true;
$form_helper->return_json();


