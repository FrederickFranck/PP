<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

include 'functions.php';

ini_set("allow_url_fopen", true);
// Get the JSON contents

get_next_ferry($_POST['lat'],$_POST['long']/*,$_POST['time']*/);




    
?>
