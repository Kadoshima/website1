<?php

    //BD関連変数
    $dsn      = 'mysql:host=mysql209.phy.lolipop.lan;dbname=LAA1480249-intertntest';
    $user     = 'LAA1480249';
    $password = 'Crystal0621';
    
    try{
        $dbh = new PDO($dsn, $user, $password);

    }catch(PDOException $e){
        print("mainデータベースの接続に失敗しました".$e->getMessage());
        die();
    }
?>