<?php
require_once('../DBfunction.php');

// GOODS_ID	
// GOODS_NAME	
// EXPLANATION	
// PRICE	
// SELLER	
// GOOD	
// TEXT_ID	
// SUBJECT_ID	
// DELIVERY_WAY	
// IMG

$sql = "INSERT INTO 
`goods_t` (`GOODS_ID`, `GOODS_NAME`, `EXPLANATION`, `PRICE`, `SELLER`, `GOOD`, `SUBJECT_ID`, `TEXT_ID`, `DELIVERY_WAY`, `IMG`) 
VALUES (NULL, :title, :explanation, :price, :seller, '0', :text_id, :subject_id, :way, :imgfile)";

$stmt = $dbh -> prepare($sql);

//前処理
$subject = $_POST['subject'];
$text = $_POST['text'];

$subject = substr($subject, 0, strpos($subject, ','));
$text = substr($text, 0, strpos($text, ','));

$raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

//プレイスフォルダー
$stmt -> bindValue(':title', $_POST['title']);
$stmt -> bindValue(':explanation', $_POST['explanation']);
$stmt -> bindValue(':price', $_POST['price']);
$stmt -> bindValue(':seller', $_SESSION['id']);
$stmt -> bindValue(':text_id', $_POST['text']);
$stmt -> bindValue(':subject_id', $_POST['subject']);
$stmt -> bindValue(':way', $_POST['way']);
$stmt -> bindValue(':imgfile', $raw_data);
// 『：』プレイスフォルダー用の目印

$stmt -> execute();

echo "登録が完了しました" . "\n";
echo '<a href = "../index.php">戻る</a>';

// 接続を閉じる
$dbh = null;

