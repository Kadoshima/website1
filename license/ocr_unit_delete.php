<?php

    $apikey = '8f9fae29788abb7e13011018ec0c9a52269aeccf7cf329fa09c181400900656a92b4518df73f36be4a463ea09fc3903a9b0505b32be71f5b966a8f29827ccf45';

    $workflow_id = '3a3d7f82-c69f-4fa4-995f-dd7025f5a0ca';
    $url = 'https://crystal-tec-ocr.dx-suite.com/wf/api/standard/v2/workflows/' . $workflow_id . '/units';

    $filename = "@license.jpg";

    $params = array(
        'files' => $filename,
        'unitName' => 'test3'
    );

    $headers = array(
        'Content-Type: multipart/form-data',
        'apikey: ' . $apikey,
        'Host: api.workflow.inside.ai'
    );

    //print($url);

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

    // curlセッションを終了する
    curl_close($ch);

    //$response_array = json_decode($response, true);

    //配列を返却
    var_dump($response);

    
?>

