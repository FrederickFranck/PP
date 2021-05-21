<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

function getConnection(){

    $servername = "localhost";
    $username = "frederick";
    $password = "PPPPPP";
    $dbname = "PunctualPal";
    //connect to database

    $connection = mysqli_connect($servername,$username,$password,$dbname);
    if(!$connection){
    die("Connection failed " . mysqli_connect_error());
    }
    return $connection;
}

?>