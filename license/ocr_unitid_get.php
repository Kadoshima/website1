<?php

    $header = array(
        'Content-Type: application/json',
        'apikey:f5210b2e0468bb03a3438cfde58e62fb68c6d6ff4358cfcff5a34787735b1729642933945a1ebfa6b23b3a81efff48c89ce30ecc936382ca141dca6f2a7b53bd',
    );


    $workflow_id = '3a3d7f82-c69f-4fa4-995f-dd7025f5a0ca';
    $url = 'https://crystal-tec-ocr.dx-suite.com/wf/api/standard/v2/workflows/' . $workflow_id . '/units/ids';

    $curl=curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE); // 証明書の検証を無効化
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE); // 証明書の検証を無効化
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE); // 返り値を文字列に変更
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡

    $output= curl_exec($curl);

    // エラーハンドリング用
    $errno = curl_errno($curl);
    // コネクションを閉じる
    curl_close($curl);

    // エラーハンドリング
    // if ($errno !== CURLE_OK) {
    // }

    echo $output;

?>