<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="reset.css"> -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="phpstyle.css">

    <?php

        $dsn      = 'mysql:dbname=test;host=localhost';
        $user     = 'admin';
        $password = '1111';

    ?>

</head>
<body>

    <main class="main">
        <div class="background">
            <div class="logo_div">
                <a href="index.php"><img class="logo" src="logo.png" width="70px"></a>
                <h1 class="appname">CAT</h1>
            </div>    
            <hr class="hr1">
            <nav class="nav">
                <h2 class="h2 p1">検索</h2><br>

                <form action="index.php" method="post">
                    <div class="location margin1">
                        <p class="p1">学部</p>
                        <input type="Undergraduate" id="Undergraduate" name="name" requiredminlength="4" maxlength="8" size="10">
                    </div>

                    <div class="human margin1">
                        <p class="p1">学年</p>
                        <input type="years" id="years" name="name" requiredminlength="4" maxlength="8" size="10">
                    </div>

                    <div class="Genre margin1">
                        <p class="p1">講義名</p>
                        <input type="lecture_name" id="lecture_name" name="name" requiredminlength="4" maxlength="8" size="10">
                    </div>

                    <a href="" class="btn btn--orange">検索</a>
                </form>

            </nav>
        </div>

        <?php

            // DBへ接続
            try{
                $dbh = new PDO($dsn, $user, $password);

                // クエリの実行
                $query = "SELECT * FROM test_2 ROW";
                $stmt = $dbh->query($query);

                // 表示処理
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    ?>
                    <!-- html -->
                    <div>
                        <div class="naiyou">

                            <div class="title">

                                <p>商品タイトル</p>
                                <?php echo $row["text_name"];?>

                            </div>

                            <div class="php_font_1">

                                <p>内容</p>
                                <?php echo $row["comments"];?>

                            </div>
                        </div>
                    </div>
                    <?php
                }

            }catch(PDOException $e){
                print("データベースの接続に失敗しました".$e->getMessage());
                die();
            }
           // 接続を閉じる
            $dbh = null;
            ?>
        </div>
    </main>
</body>
</html>