---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 25.12.2016
 * Time: 13:42
 */

include_once  __DIR__ . "/../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../assets/php/general/Connection.php";
include_once  __DIR__ . "/../assets/php/general/ConfigStrings.php";
include_once  __DIR__ . "/../assets/php/general/Route.php";

$form_helper = new AjaxFormHelper();
$vorname = $form_helper->test_search_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Vorname");
$nachname = $form_helper->test_search_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöüß]{1,25}$/", "Nachname");
$fach = $form_helper->test_numeric($_POST['faecher']);
$stufe = $form_helper->test_numeric($_POST['stufen']);
$rolle = $form_helper->test_numeric($_POST['rollen']);

$otherTable = "JOIN angeboteneStufe AS t2 ON t2.idBenutzer=t1.idBenutzer ";
$otherTable2= "JOIN angebotenesFach AS t4 ON t4.idBenutzer=t1.idBenutzer ";
$otherTable3= "JOIN rolle AS t6 ON t6.idRolle=t1.idRolle ";

$firstParam = " t1.vorname = ".$vorname;
$secondParam = " AND t1.name = ".$nachname;
$thirdParam = " AND t2.idStufe = ".$stufe;
$fourthParam = " AND t4.idFach = ".$fach;
$fifthParam = " AND t6.idRolle = ".$rolle;

$newUrl = Route::get_root();
$newUrl = $newUrl."suche/?";
if($vorname == null){
    $firstParam = " t1.vorname = t1.vorname";
}
else{
    $newUrl = $newUrl."vorname=".$_POST['vorname']."&";
}
if($nachname == null){
    $secondParam = " AND t1.name = t1.name";
}
else{
    $newUrl = $newUrl."name=".$_POST['nachname']."&";
}
if($stufe == null){
    $otherTable = "";
    $thirdParam = "";
}
else{
    $newUrl = $newUrl."stufe=".$_POST['faecher']."&";
}
if($fach == null){
    $otherTable2 = "";
    $fourthParam = "";
}
else{
    $newUrl = $newUrl."fach=".$_POST['stufen']."&";
}
if($rolle == null){
    $otherTable3 = "";
    $fifthParam = "";
}
else{
    $newUrl = $newUrl."rolle=".$_POST['rollen']."&";
}
if(substr($newUrl, -1) == '?'){
    $newUrl = rtrim($newUrl, '?');
}
else if(substr($newUrl, -1) == '&'){
    $newUrl = rtrim($newUrl, '&');
}
$sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 ".$otherTable.$otherTable2.$otherTable3."WHERE".$firstParam.$secondParam.$thirdParam.$fourthParam.$fifthParam;
$sorting = $_POST['sort'];
switch($sorting){
    case "ascVorname":
        $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t1.vorname ASC";
        break;
    case "descVorname":
        $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t1.vorname DESC";
        break;
    case "ascName":
        $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t1.name ASC";
        break;
    case "descName":
        $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t1.name DESC";
        break;
    case "ascFach":
        if($fach != null) {
            $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t4.name ASC";
        }
        break;
    case "descFach":
        if($fach != null) {
            $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t4.name DESC";
        }
        break;
    case "ascStufe":
        if($stufe != null) {
            $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t2.name ASC";
        }
        break;
    case "descStufe":
        if($stufe != null) {
            $sql = "SELECT t1.name, t1.vorname, t1.idBenutzer FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t2.name DESC";
        }
        break;
}
$stmt = Connection::$PDO->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_CLASS, 'Benutzer');

$form_helper->success = true;
//set url in form helper
$form_helper->response['newUrl']=$newUrl;
$form_helper->response['users']=$users;
$form_helper->return_json();
?>