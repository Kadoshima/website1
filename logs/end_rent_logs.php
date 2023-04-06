<?php

    try{
        require_once('../DBfunction.php');
        require_once('DBfunction_logs.php');
    
        //on_rentからiotcodeを取得
        $sql = "SELECT rent_id FROM after_rent WHERE f_log = 0";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){

            // テーブルが存在するかどうかをチェックする
            $table_name = "logs_" . $row['rent_id'];
            $stmt_check = $dbh_logs->prepare("SHOW TABLES LIKE :table_name");
            $stmt_check->bindValue(':table_name', $table_name, PDO::PARAM_STR);
            $stmt_check->execute();
            $table_exists = $stmt_check->rowCount() > 0;

            if($table_exists == FALSE){

                //after_rentのflag書き換え
                $sql = "UPDATE after_rent SET f_log = 2 WHERE rent_id = " . $row['rent_id'];
                $stmt_update = $dbh->prepare($sql);
                $stmt_update->execute();
                
                echo $row['rent_id'];

                continue;
            }
    
            try{
                $log_file = fopen("logs_csv/logs_" . $row['rent_id'] . ".csv", "w");
            }catch(Exception $e){
                echo 'file err';
            }            
            
            //logの取得
            $sql = "SELECT * FROM logs_" . $row['rent_id'];
            $stmt_log = $dbh_logs->prepare($sql);

            $stmt_log->execute();
            while($log_member = $stmt_log -> fetch(PDO::FETCH_ASSOC)){
                fputcsv($log_file, $log_member);
            }
    
            fclose($log_file);
    
            //after_rentのflag書き換え
            $sql = "UPDATE after_rent SET f_log = 1 WHERE rent_id = " . $row['rent_id'];
            $stmt_update = $dbh->prepare($sql);
            $stmt_update->execute();
    
            //テーブルの削除
            $sql = "DROP TABLE logs_" . $row['rent_id'];
            $stmt_log = $dbh_logs->prepare($sql);
            $stmt_log->execute();
    
        }
    }catch(Exception $e){
        echo $e;
        exit();
    }

    

?>