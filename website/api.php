<?php

$url = $_REQUEST['request'];
$method = $_SERVER['REQUEST_METHOD'];

$url_list = explode("/",$url);
$project = $url_list[0];


if ($method == "POST") {
    $json = json_decode(file_get_contents('php://input'), true);
}


switch($project){

    case "pp":
        echo "Punctuality Pal";
        break;

    case "moodboard":
        echo "moodboard";
        break;

    case "cheapscraper":
        echo "CheapScraper";
        break;

    default:
        http_response_code(404);
        return;
}
?>
