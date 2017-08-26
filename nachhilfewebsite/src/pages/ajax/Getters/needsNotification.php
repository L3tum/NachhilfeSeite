---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 23.04.2017
 * Time: 17:07
 */

include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();

$logged_in_user = Benutzer::get_logged_in_user();
if (isset($logged_in_user) && $logged_in_user != false && $logged_in_user->hasBeenNotifiedAboutNotifications == false) {
    $benachrichtigungen = $logged_in_user->has_benachrichtigungen();
    $chats = $logged_in_user->has_unread_messages();
    $anfragen = $logged_in_user->has_received_anfragen();
    if ($benachrichtigungen != false || $chats != false || $anfragen != false) {
        $form_helper->response['ja'] = true;
    }
    else{
        $form_helper->response['ja'] = false;
    }
}
else{
    $form_helper->response['ja'] = false;
}
$logged_in_user->set_notified();
$form_helper->success = true;
$form_helper->return_json();
