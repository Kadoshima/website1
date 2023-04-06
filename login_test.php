<?php

    require_once('DBfunction.php');
    error_reporting(0);

    //フォームからの値をそれぞれ変数に代入
    $id = $_GET['id'];
    echo("id=" . $id . "\n");

    try{
        $sql = "SELECT * FROM user_t WHERE ID = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        /*
        $stmt->bindValue(':pass', $pass);
        $stmt->bindValue(':nickname', $nickname);
        */
        $stmt->execute();
        $member = $stmt->fetch();
    }catch(Exception $e){
        echo '捕捉した例外: ',  $e->getMessage(), "\n";
    }

    if ( $member != NULL) {
        // //DBのユーザー情報をセッションに保存s
        // $_SESSION['id'] = $member['ID'];
        // $_SESSION['username'] = $member['name'];
        // $msg = 'ログインしました。';
        // $link = '<a href="../mypage.php">MY PAGE</a>';
        echo "ログイン成功";
        return 100;
    } else {
        // $msg = 'IDもしくはパスワードが間違っています。';
        echo "ログイン失敗";
        return 200;
    }
    
?>