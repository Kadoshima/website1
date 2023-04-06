<?php

    require_once('../DBfunction.php');

    //DB関連
    try{

        //License_registarテーブルのstatus1をチェックする
        $sql = "SELECT user_id FROM License_registar WHERE status = 4";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){

            $downloaddir = 'license_csv/';
            $filepath = $downloaddir . $row['user_id'] . '.csv';

            //保存用のファイルポインターを作成
            $csv_file_pointer = fopen($filepath, 'r');

            //一行削除
            $line = fgets($csv_file_pointer);
            
            $line = fgets($csv_file_pointer);

            //string型で帰ってきたデータをカンマ区切りで配列に代入
            $responsebody = explode(',' ,$line);
            $responsebody = str_replace('"', '', $responsebody);
            
            //responseからスペース削除
            $responsebody = str_replace(' ', '', $responsebody);
            $responsebody = str_replace('　', '', $responsebody);

            //種別 = response[4] からハイフン削除
            $responsebody[4] = str_replace('-', '', $responsebody[4]);
            $responsebody[4] = str_replace('ー', '', $responsebody[4]);
            $responsebody[4] = str_replace('―', '', $responsebody[4]);
            $responsebody[4] = str_replace('一', '', $responsebody[4]);
            $responsebody[4] = str_replace('-', '', $responsebody[4]);
            $responsebody[4] = str_replace(')', '', $responsebody[4]);
            $responsebody[4] = str_replace('(', '', $responsebody[4]);
            $responsebody[4] = preg_replace("/\n|\r|\r\n/", "", $responsebody[4]);

            //登録されたデータに合っているかチェック
            $sql = "SELECT name, birthday, address FROM user_detail WHERE id = :user_id";
            $user_stmt = $dbh->prepare($sql);
            $user_stmt->bindValue(':user_id', $row['user_id']);
            $user_stmt->execute();

            $member = $user_stmt->fetch();

            $err = '';
            $AuthC_status = 3;

            //氏名
            if($member['name'] != $responsebody[0]){
                $err .= 'name,';
                $AuthC_status = 4;
            }
            //誕生日
            if($member['birthday'] != $responsebody[1]){
                $err .= 'birthday,';
                $AuthC_status = 5;
            }
            //住所
            if($member['address'] != $responsebody[2]){
                $err .= 'address,';
                $AuthC_status = 6;
            }

            //一旦有効期限は見ない　**修正必須**

            //種類
            if(empty($responsebody[4])){
                $err .= 'type,';
                $AuthC_status = 7;
            }

            if($err == ''){
                $AuthC_status = 10;
            }

            //License_registarテーブルのstatus1をチェックする
            $sql = "UPDATE License_registar SET status = 5 ,err = :err WHERE user_id = :user_id";
            $user_stmt = $dbh->prepare($sql);
            $user_stmt->bindValue(':err', $err);
            $user_stmt->bindValue(':user_id', $row['user_id']);
            $user_stmt->execute();
            

            //License_registarテーブルのstatusをチェックする
            $sql = "UPDATE user_detail SET AuthC_status = :AuthC_status WHERE id = :user_id";
            $user_stmt = $dbh->prepare($sql);
            $user_stmt->bindValue(':AuthC_status', $AuthC_status);
            $user_stmt->bindValue(':user_id', $row['user_id']);
            $user_stmt->execute();

            fclose($csv_file_pointer);
    
        }

    }catch(Exception $e){
        echo $e;
        exit();
    }
?>