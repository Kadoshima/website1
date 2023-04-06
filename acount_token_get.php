<?php

    $user_id = $_GET['user_id'];

    require_once('DBfunction.php');

    try{
        $sql = "SELECT token FROM acount_token WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $member = $stmt->fetch();

        http_response_code(200);

        return $member['token'];

    }catch(Exception $e){
        http_response_code(405);
        echo $e;
    }
    
?>