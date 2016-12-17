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

ConfigStrings::set("basepath", "nachhilfewebsite/dist");


session_start();

if(!Connection::connect(true)) {
    exit;
}

if($logged_in_user = Benutzer::get_logged_in_user()) {
    echo 'YEAH';
}

Route::init();

Route::add('',function(){
    //Do something

    include "special/welcome.php";
});

Route::add('noDB',function(){
    //Do something
    include "special/noDBConnection.php";
});



Route::add('test',function(){
    //Do something
    echo 'Welcome :-)';
});


Route::run();
//print_r($_SERVER);
    ?>