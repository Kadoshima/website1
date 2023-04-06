<?php

    $email = 'galaxykadosima@gmail.com';

    // 日本語が文字化けしないよう、設定。php.iniで設定してあれば不要
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    // URLはご自身の環境に合わせてください
    $registerToken = 'hogehoge';

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
    $isSent = mb_send_mail($email, $subject, $body, $headers);

    //if (!$isSent) throw new \Exception('メール送信に失敗しました。');

?>