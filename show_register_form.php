<?php

    //必要なファイルの読み込み
    require_once('DBfunction.php');

    try{
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->beginTransaction();

        $token = $_GET['token'];

        //tokenのチェック
        $sql = "SELECT * FROM registar_token WHERE token = :token";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $member = $stmt->fetch();
    
        if(empty($member)){
            echo 'トークンが不正です。';
            exit();
        }
    
        //user_idの保管
        $user_id = $member['user_id'];
    
        //registar tokenテーブルから行の削除
        $sql = "DELETE FROM registar_token WHERE token = :token";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $member['token']);
        $stmt->execute();
    
        //userのAuthc status を更新
        $sql = "UPDATE user_detail SET AuthC_status = '2' WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $user_id);
        $stmt->execute();

        echo 'メールアドレスの認証が完了しました';

        $dbh->commit();

    }catch(Exception $e){
        echo 'トークンが不正です。<br>';
        echo $e;
    }


    

?>