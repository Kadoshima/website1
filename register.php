<?php

    require_once('DBfunction.php');

    //消す必要あり
    // $encode_json = array();
    // array_push($encode_json, $_POST['id'], $_POST['pass'], $_POST['name'], $_POST['number'], $_POST['status'], $_POST['birthday'], $_POST['age'], $_POST['address']);

    //パスワードのハッシュ化
    $user_password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    try{

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->beginTransaction();

        $sql = "INSERT INTO `user_detail`(`id`, `pass`, `name`, `number`, `AuthC_status`, `birthday`, `age`, `address`) VALUES (:id, :pass, :name, :number, :status, :birthday, :age, :address)";

        $stmt = $dbh -> prepare($sql);

        //プレイスフォルダー
        $stmt -> bindValue(':id', $_POST['id']);
        $stmt -> bindValue(':pass', $user_password);
        $stmt -> bindValue(':name', $_POST['name']);
        $stmt -> bindValue(':number', $_POST['number']);
        $stmt -> bindValue(':status', $_POST['status']);
        $stmt -> bindValue(':birthday', $_POST['birthday']);
        $stmt -> bindValue(':age', $_POST['age']);
        $stmt -> bindValue(':address', $_POST['address']);
        
        $stmt->execute();
        http_response_code( 200 ) ;

        //メール認証用トークン
        $registerToken = bin2hex(random_bytes(32));

        //メール認証用トークンの登録
        $sql = "INSERT INTO registar_token (token, user_id) VALUES (:token, :id)";
        $stmt = $dbh -> prepare($sql);

        //プレイスフォルダー
        $stmt -> bindValue(':token', $registerToken);
        $stmt -> bindValue(':id', $_POST['id']);
        $stmt->execute();

        //ここ以降メールを送るコード
        $email = $_POST['id'];

        // 日本語が文字化けしないよう、設定。php.iniで設定してあれば不要
        // mb_language("Japanese");
        // mb_internal_encoding("UTF-8");

        $url = "https://eboardsui.site/show_register_form.php?token={$registerToken}";

        $subject =  '仮登録が完了しました';

        $body = <<<EOD

            会員登録ありがとうございます！

            24時間以内に下記URLへアクセスし、本登録を完了してください。
            {$url}
            EOD;

        // Fromはご自身の環境に合わせてください
        $headers = "From : register@eboardsui.site\n";
        // text/htmlを指定し、html形式で送ることも可能
        $headers .= "Content-Type : text/plain";

        // mb_send_mailは成功したらtrue、失敗したらfalseを返す
        //第１引数 = 宛先, 2 = 題名, 3 = 内容, 4 = 付属情報(from等)
        $isSent = mb_send_mail($email, $subject, $body, $headers);

        $dbh->commit();

    }catch(Exception $e){
        http_response_code(errorCode());
    }

    // 接続を閉じる
    $dbh = null;

?>