---
layout: noLayout
---
<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 13.05.2017
 * Time: 02:50
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/general/Connection.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Settings.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Chatnachricht.php";

$form_helper = new AjaxFormHelper();
$stmt = Connection::$PDO->prepare("SELECT * FROM chatnachricht WHERE gelesen = FALSE AND idChatnachricht > :idChatnachricht AND idSender = :idBenutzer1 AND idEmpfänger = :idBenutzer2 ORDER BY datum ASC");
$stmt->bindValue(':idBenutzer1', Settings::check_if_int_and_return_int($_POST['sender']));
$stmt->bindValue(':idBenutzer2', Benutzer::get_logged_in_user()->idBenutzer);
$stmt->bindValue(':idChatnachricht', Settings::check_if_int_and_return_int($_POST['latest-id']));
$stmt->execute();
$chats = $stmt->fetchAll(PDO::FETCH_CLASS, 'Chatnachricht');
$stmt = Connection::$PDO->prepare("UPDATE chatnachricht SET gelesen = TRUE WHERE idChatnachricht > :idChatnachricht AND idSender = :idBenutzer1 AND idEmpfänger = :idBenutzer2");
$stmt->bindValue(':idBenutzer1', Settings::check_if_int_and_return_int($_POST['sender']));
$stmt->bindValue(':idBenutzer2', Settings::check_if_int_and_return_int(Benutzer::get_logged_in_user()->idBenutzer));
$stmt->bindValue(':idChatnachricht', Settings::check_if_int_and_return_int($_POST['latest-id']));
$stmt->execute();

Benutzer::get_logged_in_user()->set_notified(true);
if($chats != false && count($chats) > 0){
    $form_helper->response['hasMessage'] = true;
    if(is_array($chats) && count($chats) > 1){
        $form_helper->response['hasMultiple'] = true;
        $form_helper->response['messages'] = array();
        $i = 0;
        foreach ($chats as $chat){
            $form_helper->response['messages'][$i] = array();
            $form_helper->response['messages'][$i]['date'] = date('d.m.Y', strtotime(str_replace('-', '/', $chat->datum)));
            $form_helper->response['messages'][$i]['message'] = $chat->inhalt;
            $form_helper->response['messages'][$i]['zeit'] = date('H:i', strtotime(str_replace('-', '/', $chat->datum))) . ":";
            $form_helper->response['messages'][$i]['sender'] = $chat->idSender;
            $form_helper->response['messages'][$i]['id'] = $chat->idChatnachricht;
            $i++;
        }
    }
    else{
        $form_helper->response['hasMultiple'] = false;
        $form_helper->response['date'] = date('d.m.Y', strtotime(str_replace('-', '/', $chats[0]->datum)));
        $form_helper->response['message'] = $chats[0]->inhalt;
        $form_helper->response['zeit'] = date('H:i', strtotime(str_replace('-', '/', $chats[0]->datum))) . ":";
        $form_helper->response['sender'] = $chats[0]->idSender;
        $form_helper->response['id'] = $chats[0]->idChatnachricht;
    }
}
else{
    $form_helper->response['hasMessage'] = false;
}
$form_helper->success = true;
$form_helper->return_json();

