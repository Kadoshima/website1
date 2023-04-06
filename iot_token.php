<?php

//token発行用URL
$url = "https://apac-api.segwaydiscovery.com/oauth/token";

//パラメータの設定
//プログラム内に直書きだとよくないので、改善対象
$param = array(
    'client_id' => "A20078",
    'client_secret' => "ddfc76a7-67ad-4e4f-a122-1d393b4d14e8",
    "grant_type" => "client_credentials"
);
$contents_array = post_request($url, $param);

function post_request($url, $param)
{

  //curlおじさんを初期化
  $ch = curl_init();
  //配列をhttp_build_queryでエンコードしてあげること
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));

  //上記で述べたピア問題
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

  //相手側からのデータの返り値を文字列で取得
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  //TRUE を設定すると、ヘッダの内容も出力します。
  //curl_setopt($ch, CURLOPT_HEADER, 1);

  //Content-Typeとユーザエージェントを指定
  $headers = array(
    "Content-Type: application/x-www-form-urlencoded",
  );
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  //送信先の指定
  curl_setopt($ch, CURLOPT_URL, $url);
  //curlおじさん実行
  $response_json = curl_exec($ch);
  $result = json_decode($response_json);
  //curlおじさんを閉じる
  curl_close($ch);

  print($response_json);

}

?>
