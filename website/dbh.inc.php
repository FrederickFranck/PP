<?php
	function getConnectionUserDB(){
		$servername = "localhost";
		$username = "dieter";
		$password = "CT5555fives";
		$dbname = "registratie";
	
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		return $conn;

	}
?>