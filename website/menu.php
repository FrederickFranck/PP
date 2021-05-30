<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

session_start();
include 'functions.php';
?>
<html>
<link rel="stylesheet" href="coolstyle.css">
<head>
    <title>Menu</title><?php
                        if (isset($_SESSION['name'])) {
                        ?><h2>Welcome <?php echo $_SESSION['name']; ?></h2>
    <?php } ?>
</head>

<body>
<!--body rel="preload" style="background-image: url('bg.jpg');"-->
    <div id="navbar">
        <a href="index.php">Home </a> &nbsp;
        <?php
        if (!isset($_SESSION['ID'])) {
        ?><a href="login.php">Login</a><?php
                                    } else {
                                        ?><a href="logout.php">Logout</a> &nbsp;
            <a href="history.php">History</a> &nbsp;
            <a href="overview.php">View User Data</a> &nbsp;
        <?php

                                    } ?>
    </div>
    <br />
</body>

</html>