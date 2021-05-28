<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

session_start();
if(!isset($_SESSION['ID'])){
    $_SESSION['ID'] = "0";
}
include 'functions.php';
?>
<html>
<head><title>Menu</title></head>
    <body>
        <div id="navbar">
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="ferry.php">Ferry</a>
        </div>
    </body>
</html>