<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <!-- <link rel="stylesheet" href="reset.css"> -->

    <link rel="stylesheet" href="css/substyle.css">
    <link rel="stylesheet" href="css/form.css">
    
</head>
<body>

    <main>
        <div class="background">
                <div class="logo_div">
                    <img class="logo" src="logo.png" width="70px">
                    <h1 class="appname">アカウント登録画面</h1>
                </div>
            <nav class="nav">

                <form action="register.php" method="post">

                    <div class="cp_iptxt formstyle">
                        <p>学籍番号(ep20xxx)</p>
                        <input type="text" id="lecture_name" name="lecture_name" placeholder="学籍番号" requiredminlength="4" maxlength="8" size="10">
                    </div>

                    <div class="cp_iptxt formstyle">
                        <p>パスワード(英文字16ケタ以内)</p>
                        <input type="password" id="pass" name="pass" placeholder="パスワード" requiredminlength="4" maxlength="8" size="10">
                    </div>

                    <div class="cp_iptxt formstyle">
                        <p>ニックネーム(32字以内)</p>
                        <input type="text" id="nickname" name="nickname" placeholder="ニックネーム" requiredminlength="4" maxlength="8" size="10">
                    </div>

                    <div class="cp_iptxt formstyle">
                        <p>mail(64字以内)</p>
                        <input type="text" id="mail" name="mail" placeholder="mail" requiredminlength="4" maxlength="8" size="10">
                    </div>

                    <input type="submit" id="go" name="go" requiredminlength="4" maxlength="8" size="10">

                    <!-- <a href="login.php" class="btn btn--orange">登録</a> -->
                </form>

            </nav>
        </div>

    </mian>


</body>
</html>