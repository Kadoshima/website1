<?php
    
    date_default_timezone_set('Asia/Tokyo');
    require_once('DBfunction.php');

    $user_id = $_POST['user_id'];

    //仮
    $user_id = 'test444';

    $now_time = new DateTime();
    $now_time->format('Y-m-d');

    $query = "SELECT token, expiry FROM acount_token";
    $stmt = $dbh->query($query);
    
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        
        $check_time = new DateTime($row['expiry']);
        $check_time -> format('Y-m-d');

        try{
            if($check_time < $now_time){
                $sql = "DELETE FROM `acount_token` WHERE token = :token";
                $delete_stmt = $dbh->prepare($sql);
                $delete_stmt->bindValue(':token', $row['token']);
                $delete_stmt->execute();
            }
        }catch(Exception $e){
            echo $e;
        }


    }


?>
