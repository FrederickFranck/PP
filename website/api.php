<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

date_default_timezone_set("Europe/Brussels");
include './cs/cheapscraperapi.php';
include './pp/functions.php';
include './mb/moodboardapi.php';
include 'requesttokenfunctions.php';

$url = $_REQUEST['request'];
$method = $_SERVER['REQUEST_METHOD'];

$url_list = explode("/",$url);
$project = $url_list[0];

$bearertoken = str_replace('Bearer ', '', getBearerToken());

if ($method == "POST") {
    $json = json_decode(file_get_contents('php://input'), true);
}

if($project == "token"){
    header('Location:requesttoken.php');
}
    
if(!checkToken($bearertoken)){
    exit("Acces Denied !");
}

switch($project){ 
    case "pp":
       
	switch($url_list[1]){
	  case "ferry":
        get_next_ferry($_POST['lat'],$_POST['long'],$_POST['time']);
        break;
        }
        //echo "pp";
        break;

    case "moodboard":
        switch ($url_list[1]){
            case "user":
              AllStudents();
              break;
            
            case "values":
              AllValues();
              break;
            }

    case "cheapscraper":
      switch ($url_list[1]){
        case "info":
          AllInfo();
          break;
        
        case "users":
          users();
          break;
        }
        //echo "CheapScraper";
        break;

    default:
	echo "non supported API call";
    echo $bearertoken;
	return;
}

function getBearerToken(){
    $headers = null;
    if (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

function checkToken($token){
    $conn = getConnectionAPI();
    $sql = "SELECT * FROM AccessToken WHERE token = '".$token."' AND isEnabled = 1";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) == 0){
        return false;
    }
    return true;
}
?>
