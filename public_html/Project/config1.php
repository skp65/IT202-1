<?php

session_start();
$host = "localhost";
$username="root";
$password="";
$database="aqbqrs7b7dbmq659";
$connect =mysqli_connect($host,$username,$password,$database);
if(!$connect)
{
    die("Connectin failed".mysqli_connect_error());
}
?>
