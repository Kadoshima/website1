<?php

  require_once('DBfunction.php');

  if (isset($_POST['upload'])) {//送信ボタンが押された場合

    //$_FILES['upfile']['error'] の値を確認
    switch ($_FILES['file']['error']) {
      case UPLOAD_ERR_OK: // OK
        echo 'OK';
        break;
      case UPLOAD_ERR_NO_FILE:   // ファイル未選択
        echo 'NO';
        throw new RuntimeException('ファイルが選択されていません');
      case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
      case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
        echo 'NO';
        throw new RuntimeException('ファイルサイズが大きすぎます');
      default:
        echo 'NO';
        throw new RuntimeException('その他のエラーが発生しました');
    }

    //$image = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $image = 'test';

    if(strrchr($_FILES['image']['name'], '.') == '.JPG'){
      $image .= '.jpeg';
    }else{
      $image .= strrchr($_FILES['image']['name'], '.');//アップロードされたファイルの拡張子を取得
    }

    $file = "images/$image";

    echo $image . '<br>';

    // $sql = "INSERT INTO images(name) VALUES (:image)";
    // $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(':image', $image, PDO::PARAM_STR);

    if (!empty($_FILES['image']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
      $f = move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);//imagesディレクトリにファイル保存
      var_dump($f);
      if (exif_imagetype($file)) {//画像ファイルかのチェック
        $message = '画像をアップロードしました';
      } else {
        $message = '画像ファイルではありません';
      }
    }
    
  }
?>

<h1>画像アップロード</h1>
<!--送信ボタンが押された場合-->
<?php if (isset($_POST['upload'])): ?>
    <p><?php echo $message; ?></p>
    <p><a href="image.php">画像表示へ</a></p>
<?php else: ?>
    <form method="post" enctype="multipart/form-data">
        <p>アップロード画像</p>
        <input type="file" name="image">
        <button><input type="submit" name="upload" value="送信"></button>
    </form>
<?php endif;?>