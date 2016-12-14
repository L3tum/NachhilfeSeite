<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 07.12.2016
 * Time: 21:03
 */

$basepath = "nachhilfewebsite/";

include "assets/php/general/ConfigStrings.php";
include "assets/php/general/Route.php";

ConfigStrings::set("basepath", "nachhilfewebsite/dist");

Route::init();

Route::add('',function(){
    //Do something
    echo 'Welcome :-)';
});


Route::add('/test',function(){
    //Do something
    echo 'Welcome :-)';
});


Route::run();
//print_r($_SERVER);
    ?>