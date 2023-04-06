<?php

    require_once('../DBfunction.php');
    require_once('ocr_unitstatus_get.php');
    require_once('ocr_unit_download.php');

    //DB関連
    try{

        //License_registarテーブルのstatus1をチェックする
        $sql = "SELECT user_id, unit_id FROM License_registar WHERE status = 3";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){

            $response = unit_status_get($row['unit_id']);

            // [{"unitId":"70b920a4-c202-4536-bfa3-504ddea328d3","unitName":"10.jpg","dataProcessingStatus":400,"dataCheckStatus":200,"dataCompareStatus":0,"csvDownloadStatus":0,"workflowId":"3a3d7f82-c69f-4fa4-995f-dd7025f5a0ca","revision":28,"createdAt":"2023-03-07T21:42:36.360415Z","updatedAt":"2023-03-07T21:42:36.360415Z"}]

            //dataProcessingStatus == 0 == ユニットなし
            $status = 4;
            if($response[0]['dataProcessingStatus'] == 0){
                echo 'define unit';
                $status = 6;
            }

            //dataProcessingStatus == 200 == データ化未完了
            elseif($response[0]['dataProcessingStatus'] == 200){
                continue;
            
            //dataProcessingStatus == 400 == データ化完了
            }elseif($response[0]['dataProcessingStatus'] == 400){
                unit_csv_download($row['user_id'], $row['unit_id']);
            }

            $sql = "UPDATE License_registar SET status = :status WHERE unit_id = :unit_id";
            $update_stmt = $dbh->prepare($sql);
            $update_stmt->bindValue(':status', $status);
            $update_stmt->bindValue(':unit_id', $row['unit_id']);
            $update_stmt->execute();
    
        }

    }catch(Exception $e){
        echo $e;
        exit();
    }
?>