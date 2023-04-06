<?php

    function segway_status($qrcode){

        try{

            require_once('access_token.php');
            require_once('DBfunction.php');
    
            //access_tokenの取得
            $access_token = access_token();
    
            //on_rentからiotcodeを取得
            $sql = "SELECT iotcode FROM segway WHERE qrcode = :qrcode";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':qrcode', $qrcode);
            $stmt->execute();
            $member = $stmt->fetch();
    
            //response用の配列を用意
            $response_json = array();
            
            $url = "https://apac-api.segwaydiscovery.com/api/v2/vehicle/query/current/status?iotCode=" . $member['iotcode'];
        
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
        
            // curlを実行し、レスポンスデータを保存する
            $response  = json_decode(curl_exec($ch), true);

            // repuest errorのチェック
            if(empty($response['data'])){
                echo 'qrcode error';
                exit();
            }

            //充電％の更新
            // $energy = $response['data']['powerPercent'];

            // $sql = "UPDATE segway SET energy_per = :energy_per WHERE iotcode = :iotcode";
            // $update_stmt = $dbh->prepare($sql);
            // $update_stmt->bindValue(':energy_per', $energy);
            // $update_stmt->bindValue(':iotcode', $row['iotcode']);
            // $update_stmt->execute();

            http_response_code(200);
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        
            // curlセッションを終了する
            curl_close($ch);
        }
        catch(Exception $ex){
            echo $ex;
        }
    }

    if(!empty($_GET['qrcode'])){
        segway_status($_GET['qrcode']);
    }

?>