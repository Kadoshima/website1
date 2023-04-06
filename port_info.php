<?php

    //必要なファイルの呼び出し
    require_once('DBfunction.php');

    //on_rentからiotcodeを取得
    $sql = "SELECT * FROM port";
    $stmt = $dbh->query($sql);

    //response用の配列を用意
    $response_json = array();
    
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){

        array_push($response_json, $row);

    }

    echo(json_encode($response_json, JSON_UNESCAPED_UNICODE));

?>