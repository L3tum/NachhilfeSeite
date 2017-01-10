---
layout: noLayout
---

<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 07.12.2016
 * Time: 21:03
 */

include_once  "assets/php/general/ConfigStrings.php";
include_once  "assets/php/general/Route.php";
include_once  "assets/php/general/Connection.php";
include_once  __DIR__ . "/assets/php/dbClasses/Benutzer.php";

$root = ConfigStrings::get("root");
if(!isset($root)) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $root = "http://$host$uri/";
    ConfigStrings::set("root", $root);
}


session_start();

if(!Connection::connect(true)) {
    exit;
}

$logged_in_user = Benutzer::get_logged_in_user();

if(!$logged_in_user) {
    include "special/welcome.php";
    exit;
}

Route::init();

Route::add404(function(){

    Route::redirect_to_root();
    

});


Route::add('',function(){


    include "main/home.php";
    
});

Route::add('logout',function(){

    Benutzer::get_logged_in_user()->log_out();
    Route::redirect_to_root();
});

Route::add('user/(.+)/edit',function($id){
    //Do something
    $user_to_edit_id = $id;
    if($user_to_edit_id == Benutzer::get_logged_in_user()->idBenutzer || Benutzer::get_logged_in_user()->has_permission("editEveryUser")) {
        include 'main/editUser.php';
    }
    else {
        Route::redirect_to_root();
    }

});

Route::add('user/(.+)/view',function($id){
    //Do something
    $user_to_show_id = $id;
    include 'main/showUser.php';
});


Route::add('noDB',function(){
    //Do something
    include "special/noDBConnection.php";
});



Route::add('suche/?\??(.*)',function($param1 = null){
    //Do something
    if(isset($param1)){
        $params = explode('&', $param1);
        foreach ($params as $param){
            $arr = explode('=', $param);
            switch($arr[0]){
                case 'vorname':
                    $vorname_sel = $arr[1];
                    break;
                case 'name':
                    $name_sel = $arr[1];
                    break;
                case 'stufe':
                    $stufe_sel = $arr[1];
                    break;
                case 'fach':
                    $fach_sel = $arr[1];
                    break;
                case 'rolle':
                    $rolle_sel = $arr[1];
                    break;
                case 'sorting':
                    $sorting_sel = $arr[1];
                    break;
                case 'ascDesc':
                    $ascDesc_sel = $arr[1];
            }
        }
    }
    include 'main/search.php';
});

Route::add('notifications',function(){
    //Do something
    include 'main/notifications.php';
});

Route::add('user/(.*)/chatMessagesTo/(.*)',function($id_sender, $id_reciever){

    include 'main/viewChatMessages.php';
});

Route::add('admin', function(){
    include 'main/administrator.php';
});

Route::add('role/(.+)/edit', function($param){
    if(Benutzer::get_logged_in_user()->has_permission("editRole")) {
        $idRole = $param;
        include 'main/editRole.php';
    }
    else{
        Route::redirect_to_root();
    }
});

Route::add('role/(.+)/view', function($param){
    if(Benutzer::get_logged_in_user()->has_permission("viewRole")) {
        $idRole = $param;
        include 'main/viewRole.php';
    }
    else{
        Route::redirect_to_root();
    }
});

Route::add('role/add', function(){
    if(Benutzer::get_logged_in_user()->has_permission("addRole")){
        include 'main/addRole.php';
    }
    else{
        Route::redirect_to_root();
    }
});


Route::run();
//print_r($_SERVER);
    ?>