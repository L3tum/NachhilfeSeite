---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 15.01.2017
 * Time: 12:29
 */

include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();
$stmt = Connection::$PDO->prepare("DELETE FROM qualifikation WHERE idQualifikation = :idQual");
$stmt->bindParam(':idQual', $_POST['id']);
$stmt->execute();
$form_helper->response['name'] = $_POST['name'];
$form_helper->success = true;
$form_helper->return_json();