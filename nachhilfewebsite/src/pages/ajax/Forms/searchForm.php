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

include_once  __DIR__ . "/../../assets/php/dbClasses/Benutzer.php";
include_once  __DIR__ . "/../../assets/php/general/AjaxFormHelper.php";
include_once  __DIR__ . "/../../assets/php/general/Connection.php";
include_once  __DIR__ . "/../../assets/php/general/ConfigStrings.php";
include_once  __DIR__ . "/../../assets/php/general/Route.php";



$form_helper = new AjaxFormHelper();
if(isset($_POST['vorname']) && $_POST['vorname'] != "") {
    $vorname = $form_helper->test_search_string($_POST['vorname'], "/^[a-zA-ZÄÖÜäöüß ]{1,25}$/", "Vorname");
}
else{
    $vorname = null;
}



if(isset($_POST['nachname']) && $_POST['nachname'] != "") {
    $nachname = $form_helper->test_search_string($_POST['nachname'], "/^[a-zA-ZÄÖÜäöüß ]{1,25}$/", "Nachname");
}
else{
    $nachname = null;
}



if(isset($_POST['faecher']) && $_POST['faecher'] != "hallo") {
    $fach = $form_helper->test_numeric($_POST['faecher']);
}
else{
    $fach = null;
}



if(isset($_POST['stufen']) && $_POST['stufen'] != "hallo") {
    $stufe = $form_helper->test_numeric($_POST['stufen']);
}
else{
    $stufe = null;
}



if(isset($_POST['rollen']) && $_POST['rollen'] != "hallo") {
    $rolle = $form_helper->test_numeric($_POST['rollen']);
}
else{
    $rolle = null;
}



$sorting = $_POST['sort'];
$ascDesc = $_POST['ascDesc'];



$otherTable = "JOIN angebotenestufe AS t2 ON t2.idBenutzer=t1.idBenutzer JOIN stufe AS t3 ON t2.idStufe=t3.idStufe ";
$otherTable2= "JOIN angebotenesfach AS t4 ON t4.idBenutzer=t1.idBenutzer JOIN fach AS t5 ON t5.idFach=t4.idFach ";
$otherTable3= "JOIN rolle AS t6 ON t6.idRolle=t1.idRolle ";



$newUrl = Route::get_root_forms();

$newUrl = $newUrl."suche/?";



if($vorname == null){
    $firstParam = " t1.vorname = t1.vorname";
}
else{
    $firstParam = " t1.vorname LIKE ".$vorname;
    $newUrl = $newUrl."vorname=".$_POST['vorname']."&";
}



if($nachname == null){
    $secondParam = " AND t1.name = t1.name";
}
else{
    $secondParam = " AND t1.name LIKE ".$nachname;
    $newUrl = $newUrl."name=".$_POST['nachname']."&";
}



if($stufe == null){
    $otherTable = "";
    $thirdParam = "";
}
else{
    $thirdParam = " AND t2.idStufe = ".$stufe;
    $newUrl = $newUrl."stufe=".$fach."&";
}



if($fach == null){
    $otherTable2 = "";
    $fourthParam = "";
}
else{
    $fourthParam = " AND t4.idFach = ".$fach;
    $newUrl = $newUrl."fach=".$stufe."&";
}



if($rolle == null){
    $fifthParam = "";
}
else{

    $fifthParam = " AND t6.idRolle = ".$rolle;
    $newUrl = $newUrl."rolle=".$rolle."&";
}



if($sorting != "no"){
    $newUrl = $newUrl."sorting=".$sorting."&";
}
$newUrl = $newUrl."ascDesc=".$ascDesc."&";



if(substr($newUrl, -1) == '?'){
    $newUrl = rtrim($newUrl, '?');
}
else if(substr($newUrl, -1) == '&'){
    $newUrl = rtrim($newUrl, '&');
}



$sql = "SELECT t1.gesperrt, t1.name, t1.vorname, t1.idBenutzer, t6.name as rollenname FROM benutzer AS t1 ".$otherTable.$otherTable2.$otherTable3."WHERE".$firstParam.$secondParam.$thirdParam.$fourthParam.$fifthParam;
if(isset($sorting) && $sorting != "no") {
    switch ($sorting) {
        case "Vorname":
            $sql = "SELECT t1.gesperrt, t1.name, t1.vorname, t1.idBenutzer, t6.name as rollenname FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t1.vorname";
            break;
        case "Name":
            $sql = "SELECT t1.gesperrt, t1.name, t1.vorname, t1.idBenutzer, t6.name as rollenname FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t1.name";
            break;
        case "Fach":
            if ($fach != null) {
                $sql = "SELECT t1.gesperrt, t1.name, t1.vorname, t1.idBenutzer, t6.name as rollenname FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t5.name";
            }
            break;
        case "Stufe":
            if ($stufe != null) {
                $sql = "SELECT t1.gesperrt, t1.name, t1.vorname, t1.idBenutzer, t6.name as rollenname FROM benutzer AS t1 " . $otherTable . $otherTable2 . $otherTable3 . "WHERE" . $firstParam . $secondParam . $thirdParam . $fourthParam . $fifthParam . " ORDER BY t3.name";
            }
            break;
    }
    if($ascDesc == "asc"){
        $sql = $sql." ASC";
    }
    else{
        $sql = $sql." DESC";
    }
}



$stmt = Connection::$PDO->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_CLASS, 'Benutzer');



$form_helper->success = true;
//set url in form helper
$form_helper->response['newUrl']=$newUrl;
$form_helper->response['users']=$users;
$form_helper->response['canDelete'] = Benutzer::get_logged_in_user()->has_permission("blockUser");
$form_helper->response['canUnblockUsers'] = Benutzer::get_logged_in_user()->has_permission("unblockUser");
$form_helper->return_json();
?>