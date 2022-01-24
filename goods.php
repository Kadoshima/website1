<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAT GOODS</title>
    <!-- <link rel="stylesheet" href="reset.css"> -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/phpstyle.css">
    

    <?php
        require_once('DBfunction.php');
    ?>

</head>
<body>

    <main class="main">
        <div class="background">
                <div class="logo_div">
                    <a href="index.php"><img class="logo" src="logo.png" width="70px"></a>
                    <h1 class="appname">MY PAGE</h1>
                </div>
            <nav>
                <a href="index.php" class="login btn_06"><span>TOPページ</span></a>
                <a href="logout.php" class="login btn_06"><span>ログアウト</span></a>
            </nav>

        </div>

        <div class="background2">

            <h2 class="h2 p1">MY GOODS</h2><br>
            <h1>購入しました</h1>
            </div>
        </div>
    </main>

</body>
</html>