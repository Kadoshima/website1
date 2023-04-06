<?php
    
    //BD関連変数
    $dsn      = 'mysql:host=mysql210.phy.lolipop.lan;dbname=LAA1480249-segwaylogs';
    $user     = 'LAA1480249';
    $password = 'Crystal0621';

    
    try{
        $dbh_logs = new PDO($dsn, $user, $password);

    }catch(PDOException $e){
        print("logsデータベースの接続に失敗しました".$e->getMessage());
        die();
    }
?>