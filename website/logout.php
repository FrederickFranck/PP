<?php
session_start();
unset($_SESSION['ID']);
unset($_SESSION['name']);
unset($_SESSION['isAdmin']);
echo "Logged out ! ";

header("refresh:2;url=http://pp.iotserver.xyz");
