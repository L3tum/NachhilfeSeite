<?php
ob_start();
$root = ConfigStrings::get("root");
if(!isset($root)) {
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    if(isset($_SERVER['HTTPS'])) {
        $root = "https://$host$uri/";
    }
    else{
        $root = "http://$host$uri/";
    }
    ConfigStrings::set("root", $root);
}
?>