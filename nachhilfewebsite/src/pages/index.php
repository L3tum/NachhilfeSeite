<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 07.12.2016
 * Time: 21:03
 */

$request_uri = $_SERVER["REQUEST_URI"];
if(file_exists($request_uri + ".php")) {
    echo "EXISTS!";
}

//print_r($_SERVER);
    ?>