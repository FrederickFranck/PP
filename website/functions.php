<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
include 'dbconnect.php';
include 'dbh.inc.php';


$LAT_BAZEL_FERRY = 4.326043;
$LAT_HEMIKSEM_FERRY = 4.330660;
date_default_timezone_set("Europe/Brussels");


function calculate_position($latitude , $longitude){
    global $LAT_BAZEL_FERRY, $LAT_HEMIKSEM_FERRY;
    if($latitude < $LAT_BAZEL_FERRY and $latitude < $LAT_HEMIKSEM_FERRY){
        //in bazel
        return 'ToHemiksem';

    }
    if($latitude > $LAT_BAZEL_FERRY and $latitude < $LAT_HEMIKSEM_FERRY){
        //on ferry
        return 'opdeboot';

    }
    if($latitude > $LAT_BAZEL_FERRY and $latitude > $LAT_HEMIKSEM_FERRY){
        //in hemiskem
        return 'ToBazel';

    }
}

function is_weekend(/*$date*/){
    return (date('N') >= 6);
}

//SELECT `ToBazel` FROM `Ferry_Bazel_Weekend` WHERE `ToBazel` >= "15:45" LIMIT 1
function get_next_ferry($lat, $long ,$userid){
    $connection = getConnection();
    $position = calculate_position($lat, $long);
    //$epoch_f = substr($epoch, 0, 10);
    //$dt = new DateTime("@$epoch_f");
    //$time = $dt->format("H:i");
    $time = date("H:i");
    
    if(is_weekend(/*$epoch_f*/)){
        echo "is weekend \r\n";
         $sql = "SELECT $position FROM Ferry_Bazel_Weekend WHERE $position >= '".$time."' LIMIT 1";
         $result = $connection->query($sql);
         $row = $result->fetch_assoc();
         echo $row[$position];

    }
    else{
        $sql = "SELECT $position FROM Ferry_Bazel_Week WHERE $position >= '".$time."' LIMIT 1";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        echo $row[$position];
    }
    //insert into history 
    $sql = "INSERT INTO History (UserID, `Long`, Lat) VALUES ('".$userid."', '".$long."', '".$lat."') ";
    //echo $sql;
    $connection->query($sql);


    //CALCULATE ETA
    $Call = "https://router.hereapi.com/v8/routes?transportMode=bicycle&origin=%s,%s&destination=%s,%s&apiKey=KvjD4uoJ2wSTgqYlpdxCz0dLucUs2aZqex6LOAAA71I";
    if($position == 'ToBazel'){
        //Veer hemiksem
        $desLAT = "51.142462";
        $desLONG = "4.325509";
        

    }
    if($position == 'ToHemiksem'){
        //Veer bazel
        $desLAT = "51.143131";
        $desLONG = "4.330986";

    }
    $Call = sprintf($Call,$lat,$long,$desLAT,$desLONG);
    //echo $Call;
    $json = file_get_contents($Call);
    $json = json_decode($json,true);
    $ETA = $json['routes'][0]['sections'][0]['arrival']['time'];
    $ETA = explode("T",$ETA)[1];
    $ETA = explode("+",$ETA)[0];
    echo "T";
    echo $ETA;

}

function get_userid($email,$pw){
    $userDBconnection = getConnectionUserDB();
    
    //Check if password is true
    $sql = "SELECT ID, Firstname, email, `password` FROM Users WHERE '".$email."' = email";
    $result = $userDBconnection->query($sql);
    $row = $result->fetch_assoc();
    $dbpassword = $row['password'];
    $UserID = $row['ID'];
    $name = $row['Firstname'];


    $verify = hash('sha512', $pw);
    $verify = password_verify($verify, $dbpassword);

    //check if user has access to project
    if($verify){
        $sql = "SELECT PP, isAdmin FROM ProjectAccess WHERE '".$UserID."' = UserID";
        $result = $userDBconnection->query($sql);
        $row = $result->fetch_assoc();
        $access = $row['PP'];
        
        //User has access to the project
        if($access){
            echo $UserID ."$".$name;
        }    
    }
    else{
        echo "FECK OFF";
    }
}

function get_users(){
    $conn = getConnectionUserDB();
    $sql = "SELECT UserID FROM ProjectAccess WHERE PP = 1";
    $result = $conn->query($sql);
    $i = 0;
    
    while($row = mysqli_fetch_assoc($result)){
        $sql = "SELECT * FROM Users WHERE '".$row['UserID']."' = ID";
        $sub_result = $conn->query($sql);  
        $sub_row = mysqli_fetch_assoc($sub_result);
        echo var_dump($sub_row);
        $response[$i]['First name'] = $sub_row['Firstname'];
        $response[$i]['Last name'] = $sub_row['Lastname'];
        $response[$i]['E-mail'] = $sub_row['email'];
        $response[$i]['UserID'] = $sub_row['ID'];
        $i++;     
    }
    header("Content-Type: JSON");
    echo json_encode($response,JSON_PRETTY_PRINT);
}

function get_location($userid){
    $PPconnection = getConnection();
    $sql = "SELECT `Long`, Lat, `Time` FROM History WHERE '".$userid."' = UserID";
    $result = $PPconnection->query($sql);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){
        $response[$i]['Longitude'] = $row['Long'];
        $response[$i]['Latitude'] = $row['Lat'];
        $response[$i]['Time'] = $row['Time'];
        $i++;   

    }
}


function login($email, $password){
    $userDBconnection = getConnectionUserDB();
    $PPconnection = getConnection();

    //Check if password is true
    $sql = "SELECT ID, Firstname, email, `password` FROM Users WHERE '".$email."' = email";
    $result = $userDBconnection->query($sql);
    $row = $result->fetch_assoc();
    $dbpassword = $row['password'];
    $UserID = $row['ID'];
    $name = $row['Firstname'];


    $verify = hash('sha512', $password);
    $verify = password_verify($verify, $dbpassword);

    //check if user has access to project
    if($verify){
        $sql = "SELECT PP, isAdmin FROM ProjectAccess WHERE '".$UserID."' = UserID";
        $result = $userDBconnection->query($sql);
        $row = $result->fetch_assoc();
        $access = $row['PP'];
        $admin = $row['isAdmin'];
        
        //User has access to the project
        if($access){
            $sql = "INSERT INTO Users VALUES ('".$UserID."')";
            $PPconnection->query($sql);
            $_SESSION['ID'] = $UserID;
            $_SESSION['name'] = $name;
            $_SESSION['isAdmin'] = $admin;
            echo "Logged in ! ";
            header( "refresh:2;url=http://pp.iotserver.xyz");

            return true;

        }    
    }
    else{
        echo "Incorrect Password";
        return false;
    }
}
