<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../login/scss/bootstrap.css">

    <?php
        require_once('../DBfunction.php');
    ?>

</head>
<body>

    <?php

    if(isset($_SESSION['username'])){
    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card login">
                        <div class="card-body">
                            <h1>新規投稿</h1>
                            <form action="post.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">商品タイトル</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="商品タイトル">
                                </div>

                                <div class="form-group">
                                    <label for="file">画像選択</label>
                                    <input type="file" name="upfile" class="form-control" accept=".jpg, .jpeg, .png" multiple>
                                    <div id="preview"></div>
                                </div>

                                <div class="form-group">
                                    <label for="explanation">商品説明</label>
                                    <textarea id="explanation" name="explanation" class="form-control" placeholder="こちらに商品内容を入力してください。" minlength="5" maxlength="10"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="price">値段</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="値段(無料の場合は0と入力)">
                                </div>

                                <div class="form-group">
                                    <label for="price">科目選択</label><br>
                                    <select name="subject">
                                        <option value="">選択してください</option>

                                        <?php
                                            $query = "SELECT SUBJECT_ID, SUBJECT_NAME FROM subject_t ROW";
                                            $stmt = $dbh->query($query);
                                            
                                            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                                                
                                                ?>
                                                <option>
                                                <?php
                                                    printf('%d, ', $row["SUBJECT_ID"]);
                                                    echo $row["SUBJECT_NAME"];
                                                ?>
                                                </option>
                                                <?php
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                                <!-- <button class="btn btn-primary">決定</button> -->


                                <div class="form-group">
                                    <label for="text">教科書選択</label><br>
                                    <select name="text">
                                        <option value="">選択してください</option>


                                        <?php
                                            $query = "SELECT TEXT_ID, TEXT_NAME FROM text_t ROW";
                                            $stmt = $dbh->query($query);
                                            
                                            while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                                                
                                                ?>
                                                <option>
                                                <?php
                                                    printf('%d, ', $row["TEXT_ID"]);
                                                    echo $row["TEXT_NAME"];
                                                ?>
                                                </option>
                                                <?php
                                            }
                                        ?>
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="way">受け渡し方法</label>
                                    <input type="text" name="way" id="way" class="form-control" placeholder="受け渡し方法を指定してください">
                                </div>

                                <button class="btn btn-primary w-100">投稿</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    else{

        echo "<h1>ログインしてください</h1>";
        echo '<h1><a href="../index.php">戻る</a><a href="../login/login.html"> / ログインする</a></h1>';

    }
    ?>

</body>

</html>
