<?php

    require_once('DBfunction.php');
    error_reporting(0);

    $query = "SELECT ID, NAME_F, NAME_L, AGE FROM user_t ROW";
    $stmt = $dbh->query($query);

    $i = 0;
    $encode_json = array();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        
        $encode_json[$i] = $row;
        $i++;
 
    }

    echo(json_encode($encode_json));
    return json_encode($encode_json);

?>

