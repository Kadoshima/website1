<?php
require_once('../DBfunction.php');

//フォームからの値をそれぞれ変数に代入
$id = $_POST['id'];


$sql = "SELECT * FROM user_t WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
/*
$stmt->bindValue(':pass', $pass);
$stmt->bindValue(':nickname', $nickname);
*/
$stmt->execute();
$member = $stmt->fetch();

//指定したハッシュがパスワードにマッチしているかチェック

if (password_verify($_POST['password'], $member['PASSWORD'])) {
    //DBのユーザー情報をセッションに保存s
    $_SESSION['id'] = $member['ID'];
    $_SESSION['username'] = $member['name'];
    $msg = 'ログインしました。';
    $link = '<a href="../mypage.php">MY PAGE</a>';
} else {
    $msg = 'IDもしくはパスワードが間違っています。';
    $link = '<a href="login.html">戻る</a>';
}

?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>