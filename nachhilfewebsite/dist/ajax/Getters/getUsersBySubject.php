
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 11.01.2017
 * Time: 23:19
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$users = Benutzer::get_by_id(Benutzer::get_logged_in_user()->idBenutzer)->get_all_connections_single_by_subject($_POST['fach']);

$form_helper->response['users'] = $users;
$form_helper->success = true;
$form_helper->return_json();
