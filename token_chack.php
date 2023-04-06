<?php

    function token_chack($acount_token, $dbh){

        $sql = "SELECT token, user_id FROM `acount_token` WHERE token = :token";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $acount_token);
        $stmt->execute();
        $member = $stmt->fetchall(PDO::FETCH_ASSOC);

        //var_dump($member);

        if(count($member) == 1){
            return $member[0]['user_id'];
        }elseif(count($member) == 0){
            return 400;
        }
        else{
            return 500;
        }
        return $member['user_id'];
    }

    // require_once('DBfunction.php');
    // token_chack('4b6ad0a729b09f2bbd675dcf4653c618', $dbh);

    if(!empty($_POST['acount_token'])){
        //access tokenを取得するファイルの読み込み
        require_once('DBfunction.php');
        token_chack($_POST['acount_token'], $dbh);
    }


?>