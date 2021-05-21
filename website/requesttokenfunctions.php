<?php
function getConnectionAPI(){
    $servername = "localhost";
    $username = "API";
    $password = "CT5555fives";
    $dbname = "API";
    //connect to database

    $connection = mysqli_connect($servername,$username,$password,$dbname);
    if(!$connection){
    die("Connection failed " . mysqli_connect_error());
    }
    return $connection;

}

function register($firstname,$lastname,$email,$pp,$mb,$cs,$connection){
    if(!isset($pp)){
        $pp = 0;
    }

    if(!isset($mb)){
        $mb = 0;
    }

    if(!isset($cs)){
        $cs = 0;
    }
        
    $result = $connection->query("SELECT UUID()");
    $row = $result->fetch_assoc();
    $token = $row["UUID()"];
    $sql = "INSERT INTO AccessToken (Firstname , Lastname , email , token , AccessPP , AccessMoodboard , AccessCheapScrpr ) VALUES ('".$firstname."','".$lastname."','".$email."','".$token."','".$pp."','".$mb."','".$cs."')";
    $reg = $connection->query($sql);   
    echo "Your token (it can take some time before it is activated)  ";
    echo $token;
}
?>