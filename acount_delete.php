<?php

    function access_token($acount_token, $pass){

        //必要なファイルの呼び出し
        require_once('DBfunction.php');
        require_once('token_chack.php');

        //アカウントトークンからidの取得・tokenのチェック
        $user_id = token_chack($acount_token, $dbh);
        if($user_id == 400 || $user_id == 500){
            http_response_code(8000);
            echo 'token error';
            exit();
        }

        $sql = "SELECT pass FROM user_detail WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $user_id);
        $stmt->execute();
        $member = $stmt->fetch();

        //パスワードにマッチしているかチェック
        if (password_verify($pass, $member['pass'])) {
            
            //portテーブルの情報を更新
            $sql = "DELETE FROM user_detail WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $user_id);
            $stmt->execute();

        } else {
            http_response_code( 405 );
            $response = array(
                'error' => 'password error',
            );
        }

    }

    if(!empty($_POST['user_token']) && !empty($_POST['password'])){
        access_token($_POST['user_token'], $_POST['password']);
    }else{
        echo 'Not enough arguments';
    }

?>