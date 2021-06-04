<?php

include 'functions.php';

ini_set("allow_url_fopen", true);
// Get the JSON contents

get_next_ferry($_POST['lat'],$_POST['long']/*,$_POST['time']*/);

    
?>
