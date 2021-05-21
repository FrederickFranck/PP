<?php
'include dbconnect.php';

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

function is_weekend($date){
    return (date('N', $date) >= 6);
}

//SELECT `ToBazel` FROM `Ferry_Bazel_Weekend` WHERE `ToBazel` >= "15:45" LIMIT 1
function get_next_ferry($lat, $long ,$epoch){
    $connection = getConnection();
    $position = calculate_position($lat, $long);
    $epoch_f = substr($epoch, 0, 10);
    $dt = new DateTime("@$epoch_f");
    $time = $dt->format("H:i");
    
    if(is_weekend($epoch_f)){
        echo "is weekend";
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
}
?>