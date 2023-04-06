<?php

    function unit_csv_download($user_id, $unit_id) {

        $downloaddir = 'license_csv/';
        $filepath = $downloaddir . $user_id . '.csv';

        //保存用のファイルポインターを作成
        $scv_file_pointer = fopen($filepath, 'c');

        $header = array(
            'Content-Type: application/octet-stream',
            'apikey:f5210b2e0468bb03a3438cfde58e62fb68c6d6ff4358cfcff5a34787735b1729642933945a1ebfa6b23b3a81efff48c89ce30ecc936382ca141dca6f2a7b53bd',
        );

        $url = 'https://crystal-tec-ocr.dx-suite.com/wf/api/standard/v2/units/' . $unit_id . '/csv';

        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //pfを設定
        curl_setopt( $curl, CURLOPT_FILE, $scv_file_pointer );
        curl_setopt( $curl, CURLOPT_HEADER, FALSE );

        $output = curl_exec($curl);

        // コネクションを閉じる
        curl_close($curl);

        fclose($scv_file_pointer);

        /*

        //string型で帰ってきたデータをカンマ区切りで配列に代入
        $responsebody = explode(',' ,$output);

        //ラベルの削除
        unset($responsebody[0], $responsebody[1], $responsebody[2], $responsebody[3]);
        //改行部分はカンマがないので、文字列操作
        $responsebody[4] = str_replace('種類', '', $responsebody[4]);
        foreach($responsebody as $bodys){
            $bodys = str_replace('"', '', $bodys);
        }
        //$responsebody[4] = str_replace('"', '', $responsebody[4]);
        $responsebody[4] = str_replace(' ', '', $responsebody[4]);

        */

    }

?>