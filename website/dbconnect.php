<?php
$servername = "localhost";
$username = "frederick";
$password = "PPPPPP";
$dbname = "PunctualPal";
//connect to database

$connection = mysqli_connect($servername,$username,$password,$dbname);
if(!$connection){
    die("Connection failed " . mysqli_connect_error());
}
?>