<?php
$server = "localhost";
$user   = "root";
$pass   = "";


$connection = new mysqli($server, $user, $pass, '');

if($connection->connect_errno > 0){
    die('Unable to connect to database [' . $connection->connect_error . ']');
}

?>