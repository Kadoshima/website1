<?php 

//BD関連変数
$dsn      = 'mysql:dbname=souseid;host=localhost';
$user     = 'root';
$password = '';

//登録用変数
$id = $_POST['id'];
$name = $_POST['name'];
$mail = $_POST['mail'];

//暗号化
$user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// DBへ接続
try{
    $dbh = new PDO($dsn, $user, $password);

}catch(PDOException $e){
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}

// クエリの実行
$sql = "SELECT * FROM user_t WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt -> bindValue(':id', $id);
$stmt -> execute(); //ここで実行
$member = $stmt->fetch();

if($member == false){
    $sql = "INSERT INTO user_t (ID, PASSWORD, name, mail) VALUES (:id, :user_password, :name, :mail)";

    $stmt = $dbh -> prepare($sql);

    $stmt -> bindValue(':id', $id);
    $stmt -> bindValue(':user_password', $user_password);
    $stmt -> bindValue(':name', $name);
    $stmt -> bindValue(':mail', $mail);
    //『：』プレイスフォルダー用の目印

    $stmt -> execute();

    $msg = "ユーザ登録が完了しました";
    $link = '<a href = "login.html">戻る</a>';
}
else{
    $msg = "登録済みのIDです";
    //header("location: signup.php");
    $link = '<a href = "signup.php">戻る</a>';
}

// 接続を閉じる
$dbh = null;

?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>