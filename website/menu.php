<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

session_start();
include 'functions.php';
?>
<html>
<head><title>Menu</title><?php
if(isset($_SESSION['name'])){
    ?><h2>Welcome <?php echo $_SESSION['name'];?></h2>
    <?php } ?>
</head>
    <body>
        <div id="navbar">
            <a href="index.php">Home</a>
            <?php
            if(!isset($_SESSION['ID'])){
                $_SESSION['ID'] = "0";
                ?><a href="login.php">Login</a><?php
            }
            else{
                ?><a href="logout.php">Logout</a><?php
            }?>
            <a href="ferry.php">Ferry</a>
            <a href="overview.php">View Data</a>
        </div>
    </body>
</html>