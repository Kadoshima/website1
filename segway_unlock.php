<?php

    function segway_unlock($user_token){

        //db用プログラムの読み込み
        require_once('DBfunction.php');
        //access tokenを取得するファイルの読み込み
        require_once('access_token.php');

        //access tokenを取得する
        $access_token_response = access_token();

        //user_tokenからuser_idを取得
        $sql = "SELECT user_id FROM acount_token WHERE token = :token";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $user_token);
        $stmt->execute();
        $member = $stmt->fetch();

        if(empty($member)){
            http_response_code(555);
            echo 'token error';
            exit();
        }

        $user_id = $member['user_id'];

        //user_idからiotcodeを取得
        $sql = "SELECT iotcode FROM on_rent WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $member = $stmt->fetch();

        if(empty($member)){
            http_response_code(600);
            echo 'No rentals in progress';
            exit();
        }

        $iotcode = $member['iotcode'];

        //unlockの実行
        $url = "https://apac-api.segwaydiscovery.com/api/v2/vehicle/control/unlock";

        $authorization = 'Authorization: bearer ' . $access_token_response['access_token'];

        $headers = array(
            'Content-Type: application/json',
            $authorization
        );

        $params = array(
            "iotCode" => $iotcode
        );

        // curlのセッションを初期化する
        $ch = curl_init();

        // curlのオプションを設定する
        $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($params)
        );
        curl_setopt_array($ch, $options);

        // curlを実行し、レスポンスデータを保存する
        $response  = curl_exec($ch);

        // curlセッションを終了する
        curl_close($ch);

        http_response_code(200);
        echo $response;
        return $response;
    }

    if(!empty($_POST['user_token'])){
        segway_unlock($_POST['user_token']);
    }

?>