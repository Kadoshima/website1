<?php

    require_once('DBfunction.php');
    mb_internal_encoding("UTF-8");

    $sql = "SELECT * FROM spot";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $member = $stmt->fetch();

    
    $response = array(
        'spot_id' => $member['spot_id'],
        'spot_state' => $member['spot_state'],
        'spot_name' => $member['spot_name'],
        'spot_address' => $member['spot_address'],
        'max_number' => $member['max_number'],
        'now_number' => $member['now_number']
    );
    
    //結果の出力
    echo(json_encode($response));

?>