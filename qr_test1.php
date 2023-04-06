<?php

    $url = "https://apac-api.segwaydiscovery.com/oauth/token";

    $params = array(
        'client_id' => "A20078",
        'client_secret' => "ddfc76a7-67ad-4e4f-a122-1d393b4d14e8",
        "grant_type" => "client_credentials"
    );

    $headers = array(
        'Content-Type: application/x-www-form-urlencoded'
    );

    // curlのセッションを初期化する
    $ch = curl_init();

    // curlのオプションを設定する
    $options = array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($params)
    );
    curl_setopt_array($ch, $options);

    // curlを実行し、レスポンスデータを保存する
    $response  = curl_exec($ch);
    print var_dump($response);

    // curlセッションを終了する
    curl_close($ch);

    //print $response

    
?>
