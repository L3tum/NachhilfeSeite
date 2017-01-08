---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 08.01.2017
 * Time: 18:54
 */

include_once  __DIR__ . "/../assets/php/dbClasses/Rolle.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";

$form_helper = new AjaxFormHelper();

$name = $form_helper->test_string($_POST['name'], "/^[a-zA-ZÄÖÜ*]{1,20}$/", "Administrator");

$stmt = Connection::$PDO->prepare("UPDATE rolle SET name = :name");
$stmt->bindParam(':name', $name);
