<?php

include 'dbconnect.php';
include 'functions.php';

ini_set("allow_url_fopen", true);
// Get the JSON contents
$json = json_decode(file_get_contents('php://input'), true);
//get_next_ferry($json['lat'],$json['long'],$json['time']);
get_next_ferry($_POST['lat'],$_POST['long'],$_POST['time']);




    
?>
