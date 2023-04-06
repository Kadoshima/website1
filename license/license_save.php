<?php

    //エラー処理(ここから)

    // ①POSTリクエストによるページ遷移かチェック
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo '不正なアクセスです！';
        exit();
    }

    // ②エラーコード2だった場合（HTMLのファイル制限超過）
    if ($_FILES['upload']['error'] === 2) {
        echo 'ファイルサイズを小さくしてください！';
        
?>
    <button type="button" onclick="history.back()">戻る</button>
<?php

        exit();
    // ③サイズが0だった場合（ファイルが空）
    } elseif ($_FILES['upload']['size'] === 0) {
        echo 'ファイルを選択してください！';

?>
    <button type="button" onclick="history.back()">戻る</button>
<?php

        exit();
    }

    //エラー処理(ここまで)
 
    require_once('../DBfunction.php');

    $token = $_POST['token'];

    //DB関連
    try{

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->beginTransaction();

        //user_tokenからuser_idを取得
        $sql = "SELECT user_id FROM acount_token WHERE token = :token";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $member = $stmt->fetch();

        if(empty($member)){
            http_response_code(6000);
            echo 'トークンが無効です.<br>
                ログイン済みのスマホアプリからアップロードしてください。';
            exit();
        }

        $user_id = $member['user_id'];

        //同じuser_idで登録されたデータがないかチェック
        $sql = "SELECT upload_date FROM License_registar WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $member = $stmt->fetch();

        if(!empty($member)){
            echo 'すでにアップロードされたデータがあります。<br>
            アップロード日時 : ' . $member['upload_date'];
            exit();
            //修正用ページの追加が必要
        }

        //license registarテーブルに1(仕事前)として登録
        $sql = "INSERT INTO License_registar(user_id, status) VALUES (:user_id, 1)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();


        //*** 重複の可能性あり　修正必 ***/

        //license registarテーブルから
        $sql = "SELECT registar_id FROM License_registar WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $member = $stmt->fetch();
        
        //license registarテーブルのIDからファイル名を決定
        $registar_id = $member['registar_id'];

        // ファイルの保存先(ディレクトリ)
        $uploaddir = 'license_picture/';
        //registar_id + 拡張子
        $filename = $registar_id . strrchr($_FILES['upload']['name'], '.');

        //最終的なパス(ディレクトリ + ファイル名)
        $uploadpath = $uploaddir . $filename;

        // アップロードされたファイルに、パスとファイル名を設定して保存
        $success = move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath);

        if($success){
            echo 'アップロードが完了しました<br>
                    確認まで少々お待ちください。';
        }else{
            echo 'アップロードに失敗しました。<br>
                時間をおいてアップロードし直してください。';
            exit();
        }

        $dbh->commit();

        //license registarテーブルのpicture_nameを更新
        $sql = "UPDATE License_registar SET picture_name = :filename WHERE registar_id = :registar_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':filename', $filename);
        $stmt->bindValue(':registar_id', $registar_id);
        $stmt->execute();

    }catch(Exception $e){
        echo $e;
        exit();
    }
    

?>