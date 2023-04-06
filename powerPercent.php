<?php

    if(!empty($_POST['acount_token'])){

        require_once('DBfunction.php');
        require_once('segway_status.php');
        $response = segway_status($_POST['acount_token'], $dbh);
        var_dump($response['data']['powerPercent']);

    }else{
        echo 'パラメータが足りません';
    }

    

?>