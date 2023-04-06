<?php

    date_default_timezone_set ('Asia/Tokyo');

    function start_rent($acount_token, $qrcode){

        //必要なファイルの呼び出し
        require_once('DBfunction.php');
        require_once('token_chack.php');
        require_once('qr_iotcode.php');
        require_once('segway_unlock.php');

        //アカウントトークンからidの取得・tokenのチェック
        $user_id = token_chack($acount_token, $dbh);
        if($user_id == 400 || $user_id == 500){
            http_response_code(8000);
            echo 'user_id error';
            exit();
        }

        //アカウントの認証が済んでいるかチェックする
        $sql = "SELECT AuthC_status FROM user_detail WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $member = $stmt->fetch();

        //今(20230403)は2　今後10
        if($member['AuthC_status'] < 2){
            http_response_code(8800);
            echo 'Account authentication error';
            exit();
        }

        //user_idがすでに無いかチェック
        $sql = "SELECT rent_id FROM on_rent WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $member = $stmt->fetchall(PDO::FETCH_ASSOC);

        if(count($member) > 0){
            http_response_code(8600);
            echo 'すでにレンタルを開始しています';
            exit();
        }

        //時刻の取得
        $now_time = date('Y-m-d-H:i:s');
    
        try{
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();

            //QRcodeからiotcodeを取得
            $iotcode = qrcode_chage($qrcode, $dbh);
            if($iotcode == 4000){
                http_response_code(8800);
                echo 'qrcpde error';
                exit();
            }

            //データベースからポートIDとセグウェイステータスを取得(条件はqrcode)
            $sql = "SELECT port_id, segway_state_id FROM segway WHERE qrcode = :qrcode";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':qrcode', $qrcode);
            $stmt->execute();
            $member = $stmt->fetch();

            //2or3ならレンタル中
            if($member['segway_state_id'] == 2 || $member['segway_state_id'] == 3){
                http_response_code(13000);
                echo 'このキックボードはレンタル中です';
                exit();
            }
            //4ならレンタル不可状態
            elseif($member['segway_state_id'] >= 4){
                http_response_code(13500);
                echo 'このキックボードはレンタルできません';
                exit();
            }

            //port_idを別の変数に格納
            $start_port_id = $member['port_id'];

            //portテーブルの現在駐車台数が0でないことを確認
            $sql = "SELECT now_number FROM port WHERE port_id = :port_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':port_id', $start_port_id);
            $stmt->execute();
            $member = $stmt->fetch();

            if ($member['now_number'] < 1){
                http_response_code(12500);
                echo 'portにセグウェイが1台もありません';
                exit();
            }

            //portテーブルの情報を更新
            $sql = "UPDATE port SET now_number = now_number - 1 WHERE port_id = :port_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':port_id', $start_port_id);
            $stmt->execute();

            //segway status を更新
            $sql = "UPDATE segway SET segway_state_id = '3' WHERE qrcode = :qrcode";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':qrcode', $qrcode);
            $stmt->execute();

            //on_rentテーブルに行を追加
            $sql = "INSERT INTO on_rent (user_id, start_port_id, start_date, iotcode) 
                VALUES (:user_id, :start_port_id, :start_date, :iotcode)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':start_port_id', $start_port_id);
            $stmt->bindValue(':start_date', $now_time);
            $stmt->bindValue(':iotcode', $iotcode);
            $stmt->execute();

            $sql = "SELECT rent_id FROM on_rent WHERE user_id = :user_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            $member = $stmt->fetch();

            require_once("logs/DBfunction_logs.php");

            //テーブル作成
            $sql = "CREATE TABLE logs_" . $member['rent_id'] . " (
                latitude double NOT NULL,
                longitude double NOT NULL
                );";

            $stmt =  $dbh_logs -> prepare($sql);
            $stmt -> execute();

            $dbh->commit();

            //ステータスコード設定
            http_response_code(200);

        }catch(Exception $ex){
            //ステータスコード設定
            http_response_code(405);
            echo $ex;
        }
    }

    if(!empty($_POST['acount_token']) && !empty($_POST['qrcode'])){
        $response = start_rent($_POST['acount_token'], $_POST['qrcode']);
        echo $response;
    }else{
        echo 'パラメータが足りません';
    }


?>