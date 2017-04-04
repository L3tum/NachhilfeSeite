---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 14.02.2017
 * Time: 15:49
 */

include_once __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";

$form_helper = new AjaxFormHelper();
$stmt = Connection::$PDO->prepare("SELECT * FROM benutzer WHERE gesperrt=1");
$stmt->execute();
$form_helper->response['users'] = $stmt->fetchAll(PDO::FETCH_CLASS, 'Benutzer');
$form_helper->success = true;
$form_helper->return_json();
