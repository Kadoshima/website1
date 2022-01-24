<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAT</title>
    <!-- <link rel="stylesheet" href="reset.css"> -->
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/phpstyle.css">

    <?php
        require_once('DBfunction.php');
        error_reporting(0);
    ?>

</head>
<body>

    <main class="main">
        <div class="background">
                <div class="logo_div">
                    <a href="index.php"><img class="logo" src="logo.png" width="70px"></a>
                    <h1 class="appname">CAT</h1>

                    <?php
                        if(isset($_SESSION['username'])){
                            ?>
                                <div id="username">
                                    <a href="mypage.php"><?php print($_SESSION['username'] . '様');?></a>
                                </div>

                                <div class="login_w">
                                    <a href="mypage.php" class="login btn_06"><span>MY PAGE</span></a>
                                    <a href="logout.php" class="login btn_06"><span>ログアウト</span></a>
                                </div>

                            <?php
                        }
                        else{
                            ?>
                                <div id="username">
                                    <?php print('ゲスト様');?>
                                </div>

                                <div class="login_w">
                                    <a href="login/login.html" class="login btn_06"><span>ログイン</span></a>
                                    <a href="login/register.html" class="login btn_06"><span>登録</span></a>
                                </div>
                                
                            <?php
                        }
                    ?>

                    <div class="login_w">
                    </div>

                </div>
        </div>
        <div class="background2">
            <div class="container">

                <nav class="search">

                    <form action="index.php" method="post">

                        <div class="cp_iptxt formstyle">
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


                        <div class="cp_iptxt formstyle">
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

                        <input type="submit" class="btn btn--orange" name="go" requiredminlength="4" maxlength="8" size="10" value="検索">

                    </form>

                </nav>

                <a class="upper" href="post/goods_post.php"></a>

                <?php

                    //前処理

                    $text = $_POST['text'];
                    $subject = $_POST['subject'];
                
                    $text = substr($text, 0, strpos($text, ','));
                    $subject = substr($subject, 0, strpos($subject, ','));
            
                    

                    if($_POST['subject'] != NULL && $_POST['text'] != NULL){
                        $sql = "SELECT GOODS_NAME, PRICE, IMG FROM goods_t WHERE TEXT_ID = :text && SUBJECT_ID = :subject";
                        $stmt = $dbh -> prepare($sql);
                        $stmt -> bindValue(':text', $text);
                        $stmt -> bindValue(':subject', $subject);
                        $stmt -> execute();
                        //echo "どちらも指定";
                    }
                    elseif($_POST['subject'] != NULL){
                        $sql = "SELECT GOODS_NAME, PRICE, IMG FROM goods_t WHERE SUBJECT_ID = :subject";
                        $stmt = $dbh -> prepare($sql);
                        $stmt -> bindValue(':subject', $subject);
                        $stmt -> execute();
                        //echo "subject指定";
                    }
                    elseif($_POST['text'] != NULL){
                        $sql = "SELECT GOODS_NAME, PRICE, IMG FROM goods_t WHERE TEXT_ID = :text";
                        $stmt = $dbh -> prepare($sql);
                        $stmt -> bindValue(':text', $text);
                        $stmt -> execute();
                        //echo "text指定";
                    }
                    else{
                        $sql = "SELECT GOODS_NAME, PRICE, IMG FROM goods_t ROW";
                        $stmt = $dbh->query($sql);
                        //echo "どちらも指定なし";
                    }
                    // クエリの実行
                    
                    ?>
            
                    <div class="row">

                        <?php
                        // 表示処理
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                            ?>
                            <!-- html -->
                            
                                <div class="naiyou col-lg-2">

                                    <?php $img = base64_encode($row['IMG']); ?>
                                    <img class="img " src="data:;base64,<?php echo $img; ?>"><br>


                                    <div class="php_font_1">

                                        <?php echo $row["GOODS_NAME"] . '<br>';?>
                                        <?php echo $row["PRICE"] . '円';?>

                                    </div>

                                    <form action="goods.php" type="submit">
                                        
                                        <button>購入</button>
                                    </form>
                                </div>
                            
                            <?php
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>