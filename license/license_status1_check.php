<?php

    require_once('../DBfunction.php');
    require_once('ocr_unitregistar.php');

    //DB関連
    try{

        //License_registarテーブルのstatus1をチェックする
        $sql = "SELECT picture_name FROM License_registar WHERE status = 1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){

            $response = ocr_registar($row['picture_name']);

            //登録できなかった場合の処理
            if(empty($response)){
                $sql = "UPDATE License_registar SET status = 5 WHERE picture_name = :picture_name";
                $update_stmt = $dbh->prepare($sql);
            }else{
                $sql = "UPDATE License_registar SET status = 2, unit_id = :unit_id WHERE picture_name = :picture_name";
                $update_stmt = $dbh->prepare($sql);
                $update_stmt->bindValue(':unit_id', $response['unitId']);
            }

            $update_stmt->bindValue(':picture_name', $row['picture_name']);
            $update_stmt->execute();
    
        }

        

    }catch(Exception $e){
        echo $e;
        exit();
    }
?>