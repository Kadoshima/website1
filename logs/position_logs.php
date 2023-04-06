<?php

try{

    require_once('../access_token.php');
    require_once('../DBfunction.php');

    //access_tokenの取得
    $access_token = access_token();

    //on_rentからiotcodeを取得
    $sql = "SELECT rent_id, iotcode FROM on_rent";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){

        $url = "https://apac-api.segwaydiscovery.com/api/v2/vehicle/query/current/location?iotCode=" . $row['iotcode'];

        $authorization = 'Authorization: bearer ' . $access_token['access_token'];

        $headers = array(
            $authorization
        );

        // curlのセッションを初期化する
        $ch = curl_init();

        // curlのオプションを設定する
        $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        );

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        var_dump($response);

        // curlを実行し、レスポンスデータを保存する
        $response  = json_decode(curl_exec($ch));

        var_dump($response->data);

        require_once('DBfunction_logs.php');
        
        $sql = "INSERT INTO logs_" . $row['rent_id'] . "(latitude, longitude) VALUES (:latitude, :longitude)";
        $user_stmt = $dbh_logs->prepare($sql);
        $user_stmt->bindValue(':latitude', $response->data->latitude);
        $user_stmt->bindValue(':longitude', $response->data->longitude);
        $user_stmt->execute();

        // curlセッションを終了する
        curl_close($ch);
    }
}catch(Exception $ex){
    echo $ex;
}

?>