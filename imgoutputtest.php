<?php 
    $dsn      = 'mysql:dbname=mysql;host=localhost;charset=utf8';
    $user     = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);

    $sql_select = "SELECT ext,img FROM tbl_dinoimg WHERE id = ?";
    $result1=$dbh->prepare($sql_select);
    //パラメータをセット
    $id=1;
    $result1->bindparam(1,$id,PDO::PARAM_INT);
    $result1->execute();
    $row = $result1 -> fetch(PDO::FETCH_ASSOC);
    //取得した画像バイナリデータをbase64で変換。
    $img = base64_encode($row['img']);
 ?>
    <!-- エンコードした情報をimgタグに表示 -->
    <img src="data:;base64,<?php echo $img; ?>"><br>