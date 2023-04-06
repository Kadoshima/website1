<?php

    

    function end_rent($acount_token, $return_port_id){

        date_default_timezone_set ('Asia/Tokyo');
    
        try{

            //必要なファイルの呼び出し
            require_once('DBfunction.php');
            require_once('token_chack.php');
            require_once('qr_iotcode.php');

            //アカウントトークンからidの取得・tokenのチェック
            $user_id = token_chack($acount_token, $dbh);
            if($user_id == 400 || $user_id == 500){
                echo 'user_id error';
                exit();
            }

            //portテーブルの現在駐車台数が0でことを確認
            $sql = "SELECT max_number, now_number FROM port WHERE port_id = :port_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':port_id', $return_port_id);
            $stmt->execute();
            $member = $stmt->fetch();

            if (($member['max_number'] - $member['now_number']) < 1){
                echo 'このportには駐車できません';
                exit();
            }

            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();

            //user_idがon_rentテーブルにあるかチェック
            $sql = "SELECT * FROM on_rent WHERE user_id = :user_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();
            $onrent_member = $stmt->fetch();

            if(empty($onrent_member)){
                echo '開始されたレンタルはありません';
                exit();
            }

            //現在時刻の取得
            $now_time = date('Y-m-d H:i:s');

            //DBから帰ってきた開始時間を取得
            $start_date = $onrent_member['start_date'];

            //fee(仮)
            $plan_price = 20;//1分20円
            $fee_minutes = (int)((strtotime($now_time) - strtotime($start_date)) / 60);
            $fee = $fee_minutes * $plan_price;

            // echo $fee_minutes . '分<br>';
            // echo $fee . '円';

            //after_rentテーブルに行を追加
            $sql = "INSERT INTO after_rent (rent_id, user_id, start_port_id, end_port_id, start_date, end_date, fee) 
                VALUES (:rent_id, :user_id, :start_port_id, :end_port_id, :start_date, :end_date, :fee)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':rent_id', $onrent_member['rent_id']);
            $stmt->bindValue(':user_id', $onrent_member['user_id']);
            $stmt->bindValue(':start_port_id', $onrent_member['start_port_id']);
            $stmt->bindValue(':end_port_id', $return_port_id);
            $stmt->bindValue(':start_date', $onrent_member['start_date']);
            $stmt->bindValue(':end_date', $now_time);
            $stmt->bindValue(':fee', $fee);
            $stmt->execute();

            //portテーブルの情報を更新
            $sql = "UPDATE port SET now_number = now_number + 1 WHERE port_id = :port_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':port_id', $return_port_id);
            $stmt->execute();

            //segway status を更新 & port_idを更新
            $sql = "UPDATE segway SET segway_state_id = '1' WHERE iotcode = :iotcode";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':iotcode', $onrent_member['iotcode']);
            $stmt->execute();

            //port_idを更新
            $sql = "UPDATE segway SET port_id = :port_id WHERE iotcode = :iotcode";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':port_id', $return_port_id);
            $stmt->bindValue(':iotcode', $onrent_member['iotcode']);
            $stmt->execute();

            //on_rentテーブルから行を削除
            $sql = "DELETE FROM on_rent WHERE rent_id = :rent_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':rent_id', $onrent_member['rent_id']);
            $stmt->execute();

            $dbh->commit();

            //ステータスコード設定
            http_response_code(200);
            return 200;
        }catch(Exception $ex){
            //ステータスコード設定
            http_response_code(405);
            return $ex;
        }
    }

    if(!empty($_POST['acount_token']) && !empty($_POST['return_port_id'])){
        $response = end_rent($_POST['acount_token'], $_POST['return_port_id']);
        echo $response;
    }else{
        echo 'パラメータが足りません';
    }

    // $acount_token = '4b6ad0a729b09f2bbd675dcf4653c618';
    // $return_port_id = 2;
    // $response = end_rent($acount_token, $return_port_id);
    // echo $response;

?>