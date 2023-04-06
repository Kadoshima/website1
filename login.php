<?php

    require_once('DBfunction.php');

    //フォームからの値をそれぞれ変数に代入
    $id = $_POST['id'];

    require_once('acount_token.php');
    $acount_token = acount_token($id, $dbh);

    $sql = "SELECT * FROM `user_detail` WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $member = $stmt->fetch();

    //IDが存在していたかチェック
    if(empty($member)){
        http_response_code(408);
        $response = array(
            'error' => 'id not registered',
        );
    }else{

        //パスワードにマッチしているかチェック
        if (password_verify($_POST['pass'], $member['pass'])) {
            
            http_response_code(200);

            $response = array(
                'id' => $member['id'],
                'name' => $member['name'], 
                'token' => $acount_token,
                'number' => $member['number'],
                'status' => $member['AuthC_status'],
                'birthday' => $member['birthday'], 
                'age' => $member['age'],
                'address' => $member['address']
            );
        } else {
            http_response_code( 405 );
            $response = array(
                'error' => 'password error',
            );
        }

    }

    //結果の出力
    echo(json_encode($response, JSON_UNESCAPED_UNICODE));
    
?>