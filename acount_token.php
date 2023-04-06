<?php

    function acount_token($user_id, $dbh){

        try{
            $sql = "SELECT token, expiry FROM acount_token WHERE user_id = :user_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            $member = $stmt->fetch();

        }catch(Exception $e){
            http_response_code(405);
            return $e;
        }

        if(!empty($member)){
            http_response_code(600);
            return ($member['token']);
            exit();
        }
        
        //トークン生成
        $TOKEN_LENGTH = 16;
        $bytes = random_bytes($TOKEN_LENGTH);
        $token = bin2hex($bytes);

        //有効期限
        $expiry = date('Y-m-d', strtotime("-3 day"));
        
        try{
            $sql = "INSERT INTO acount_token (`token`, `user_id`, `expiry`) VALUES (:token, :user_id, :expiry)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':expiry', $expiry);
            $stmt->execute();

            return ($token);
            exit();

        }catch(Exception $e){
            http_response_code(405);
            return $e;
        }

    }
    
?>