<?php
    session_start();

    //BD関連変数
    $dsn      = 'mysql:dbname=souseid;host=localhost';
    $user     = 'root';
    $password = '';
    
    try{
        $dbh = new PDO($dsn, $user, $password);

    }catch(PDOException $e){
        print("データベースの接続に失敗しました".$e->getMessage());
        die();
    }
?>