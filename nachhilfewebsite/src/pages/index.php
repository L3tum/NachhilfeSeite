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

Route::add('user/(.*)/edit',function($id){
    //Do something
    $user_to_edit_id = $id;
    if($user_to_edit_id == Benutzer::get_logged_in_user()->idBenutzer || Benutzer::get_logged_in_user()->has_permission("editEveryUser")) {
        include 'main/editUser.php';
    }
    else {
        Route::redirect_to_root();
    }

});

Route::add('user/(.*)/view',function($id){
    //Do something
    $user_to_show_id = $id;
    include 'main/showUser.php';
});


Route::add('noDB',function(){
    //Do something
    include "special/noDBConnection.php";
});



Route::add('suche',function(){
    //Do something
    include 'main/search.php';
});


Route::run();
//print_r($_SERVER);
    ?>