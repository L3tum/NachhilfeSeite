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

include "assets/php/general/ConfigStrings.php";
include "assets/php/general/Route.php";
include "assets/php/general/Connection.php";

ConfigStrings::set("basepath", "nachhilfewebsite/dist");
ConfigStrings::set("DSN", "mysql:host=localhost;dbname=nachhilfe");
ConfigStrings::set("DBUser", "nachhilfeDBUser");
ConfigStrings::set("DBPass", "nachhilfe");


if(!Connection::connect(true)) {
    exit;
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